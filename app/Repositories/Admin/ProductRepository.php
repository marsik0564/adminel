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
    
    public function getLastProducts($perpage)
    {
        $get = $this->startConditions()
            ->orderBy('id', 'DESC')
            ->limit($perpage)
            ->get();
        
        return $get;
    }
    
    public function getAllProducts($perpage)
    {
        $get_all = $this->startConditions()
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.title AS cat')
            ->orderBy/*Raw('LENGTH(products.title)',*/('products.title')
            ->paginate($perpage);
         
        return $get_all;
    }
    
    public function getProducts($q, $limit)
    {
        $products = $this->startConditions()
            ->select('id', 'title')
            ->where('title', 'LIKE', ["%{$q}%"])
            ->limit($limit)
            ->get();
            
        return $products;
    }
    
    public function uploadImg($dir, $name, $wmax, $hmax)
    {
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $name));
        $uploadfile = $dir . $name;
        \Session::put('single', $name);
        self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
        
    }
    
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