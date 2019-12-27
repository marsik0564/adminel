<?php

namespace App\Repositories\Admin;

use App\Repositories\CoreRepository;
use App\Models\Admin\Product as Model;

class ProductRepository extends CoreRepository
{

    public function __construct()
    {
        parent::__construct();
    }
    
    protected function getModelClass()
    {
        return Model::class;
    }
    
    /**
    * Get Last Products
    */
    
    public function getLastProducts($perpage)
    {
        $get = $this->startConditions()
            ->orderBy('id', 'DESC')
            ->limit($perpage)
            ->get();
        
        return $get;
    }
    
    /**
    * Get All Products
    */
    
    public function getAllProducts($perpage)
    {
        $get_all = $this->startConditions()
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.title AS cat')
            ->orderBy/*Raw('LENGTH(products.title)',*/('products.title')
            ->paginate($perpage);
         
        return $get_all;
    }
    
    /**
    * Get Products
    */
    
    public function getProducts($q, $limit)
    {
        $products = $this->startConditions()
            ->select('id', 'title')
            ->where('title', 'LIKE', ["%{$q}%"])
            ->limit($limit)
            ->get();
            
        return $products;
    }
    
     /**
    * Upload and resize single image Ajax
    */
    
    public function uploadImg($dir, $name, $wmax, $hmax)
    {
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $name));
        $uploadfile = $dir . $name;
        \Session::put('single', $name);
        self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
        
    }
    
    /**
    * Upload and resize gallery Ajax
    */
    public function uploadGallery($dir, $name, $wmax, $hmax)
    {
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES[$name]['name']));
        $new_name = md5(time()) . ".$ext";
        $uploadfile = $dir . $new_name;
        \Session::push('gallery', $new_name);
        if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)) {
            self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
            $res = ['file' => $new_name];
            echo json_encode($res);
        }
    }
    
    public function editFilter($id, $data)
    {
        $filter = \DB::table('attribute_products')
            ->where('product_id', '=', $id)
            ->pluck('attr_id')
            ->toArray();
        $attrs = array_values($data['atrrs']);  
          
        if ($attrs != $filter) {
            //если удалены старые фильтры
            if (!empty(array_diff($filter, $attrs))) {
                $sql_attrs = '('.implode(',', array_diff($filter, $attrs)).')';
                \DB::table('attribute_products')
                    ->where('product_id', '=', $id)
                    ->where('attr_id', 'IN', $sql_attrs)
                    ->delete();
            }
            //если добавлены новые фильтры
            if (!empty(array_diff($attrs, $filter))) {
                $sql_attrs = '';
                foreach (array_diff($attrs, $filter) as $new_attr) {
                    $sql_attrs .= "($new_attr, $id),";
                }
                $sql_attrs = rtrim($sql_attrs, ',');
                \DB::insert("INSERT INTO attribute_products (attr_id, product_id) VALUES $sql_attrs");
            }
        }
    }
    
    public function editRelatedProduct($id, $data)
    {
        $related_product_old = \DB::table('related_products')
            ->select('related_id')
            ->where('product_id', '=', $id)
            ->pluck('related_id')
            ->toArray();
            
        $related_product_new = $data['related'];
        if ($related_product_new != $related_product_old) {
            //если удалены старые рилейты
            if (!empty(array_diff($related_product_old, $related_product_new))) {
                $sql_related = '('.implode(',', array_diff($related_product_old, $related_product_new)).')';
                \DB::table('related_products')
                    ->where('product_id', '=', $id)
                    ->where('related_id', 'IN', $sql_related)
                    ->delete();
            }
            //если добавлены новые рилейты
            if (!empty(array_diff($related_product_new, $related_product_old))) {
                $sql_related = '';
                foreach (array_diff($related_product_new, $related_product_old) as $new_related) {
                    $sql_related .= "($new_related, $id),";
                }
                $sql_related = rtrim($sql_related, ',');
                \DB::insert("INSERT INTO related_products (related_id, product_id) VALUES $sql_related");
            }
        }
    }
    
    public function saveGallery($id)
    {
        if (!empty(\Session::get('gallery'))) {
            $sql_gallery = '';
            foreach (\Session::get('gallery') as $new_img) {
                $sql_gallery .= "('$new_img', $id),";
            }
            $sql_gallery = rtrim($sql_gallery, ',');
            \DB::insert("INSERT INTO galleries (img, product_id) VALUES $sql_gallery");
            \Session::forget('gallery');
        }
    }
    
    /**
    * Get info about product
    */
    
    public function getInfoProduct($id)
    {
        $product = $this->startConditions()
            ->find($id);
        
        return $product;
    }
    
    /**
    * Get filters for product
    */
    
    public function getFiltersProduct($id)
    {
        $filter = \DB::table('attribute_products')
            ->where('product_id', '=', $id)
            ->pluck('attr_id')
            ->all();
            
        return $filter;
    }
    
    /**
    * Get related products for product
    */
    
    public function getRelatedProducts($id)
    {
        $related_products = $this->startConditions()
            ->join('related_products', 'products.id', '=', 'related_products.related_id')
            ->select('products.title', 'related_products.related_id')
            ->where('related_products.product_id', '=', $id)
            ->toBase()
            ->get();
            
        return $related_products;
    }
    
    /**
    * Get gallery for product
    */
    public function getGalleryProduct($id)
    {
        $gallery = \DB::table('galleries')
            ->where('product_id', $id)
            ->pluck('img')
            ->all();
            
        return $gallery;
    }
    
    /**
    * Image resize
    */
    public static function resize($target, $dest, $wmax, $hmax, $ext)
    {
        list($w_orig, $h_orig) = getimagesize($target);
        $ratio = $w_orig / $h_orig;
        
        if ($wmax / $hmax > $ratio) {
            $wmax = $hmax * $ratio;
        } else {
            $hmax = $wmax / $ratio;
        }
        
        $img = "";
        switch ($ext) {
            case('gif'):
                $img = imagecreatefromgif($target);
                break;
            case('png'):
                $img = imagecreatefrompng($target);
                break;
            case('webp'):
                $img = imagecreatefromwebp($target);
                break;
            case('bmp'):
                $img = imagecreatefrombmp($target);
                break;
            default:
                $img = imagecreatefromjpeg($target);   
        }
        $newImg = imagecreatetruecolor($wmax, $hmax);
        if ($ext == 'png') {
            imagesavealpha($newImg, true);
            $transPng = imagecolorallocatealpha($newImg, 0 ,0 ,0 , 127);
            imagefill($newImg, 0, 0, $transPng);
        }
        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig);
        switch ($ext) {
            case('gif'):
                imagegif($newImg, $dest);
                break;
            case('png'):
                imagepng($newImg, $dest);
                break;
            case('webp'):
                imagewebp($newImg, $dest);
                break;
            case('bmp'):
                imagebmp($newImg, $dest);
                break;
            default:
                imagejpeg($newImg, $dest);
        }
        imagedestroy($newImg);
    }
}