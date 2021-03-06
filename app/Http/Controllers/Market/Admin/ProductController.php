<?php

namespace App\Http\Controllers\Market\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MetaTag;
use App\Repositories\Admin\ProductRepository;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\SMarket\Core\MarketApp;
use App\Http\Requests\AdminImageUploadRequest;
use App\Http\Requests\AdminProductUpdateRequest;
use App\Http\Requests\AdminProductCreateRequest;

class ProductController extends AdminBaseController
{
    private $productRepository;
    
    public function __construct()
    {
        parent::__construct();
        $this->productRepository = app(ProductRepository::class);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 10;
        $products = $this->productRepository->getAllProducts($perpage);
        $count = $products->total();
        
        MetaTag::setTags(['title' => 'Список продуктов']);
        return view('market.admin.product.index', compact('products', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        MetaTag::setTags(['title' => 'Создание нового продукта']);
        return view('market.admin.product.create', [
            'categories' => Category::with('children')
                ->where('parent_id', '=', '0')
                ->get(),
            'delimiter' => '-',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\AdminProductCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminProductCreateRequest $request)
    {
        $data = $request->input();
        $data['status'] = $request->status ? '1' : '0';
        $data['hit'] = $request->hit ? '1' : '0';
        $data['brand_id'] = '0';
        $product = (new Product())->create($data);
        $id = $product->id; 
        $save = $product->save();
        if (!empty($save)) {
            $this->productRepository->editFilter($id, $data);
            $this->productRepository->editRelatedProduct($id, $data);
            $this->productRepository->saveGallery($id);
            \Session::forget('single');
            return redirect()
                ->route('market.admin.products.index')
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->getInfoProduct($id);
        marketApp::get_instance()->setProperty('parent_id', $product->category_id);
        
        $filter = $this->productRepository->getFiltersProduct($id);
        $related_products = $this->productRepository->getRelatedProducts($id);
        $images = $this->productRepository->getGalleryProduct($id);
        //dd($related_products, $filter);
        MetaTag::setTags(['title' => 'Редактирование продукта №'.$id]);
        return view('market.admin.product.edit', compact('product', 'filter', 'related_products', 'images'),[
            'categories' => Category::with('children')
                ->where('parent_id', '=', '0')
                ->get(),
            'delimiter' => '-',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\AdminProductUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminProductUpdateRequest $request, $id)
    {
        $product = $this->productRepository->getID($id);
        if (empty($product)) {
            return back()
                ->withErrors(['msg' => "Товар №$id не найден"]);
        }
        $data = $request->all();
        $data['img'] = $request->img ?? '';
        $data['status'] = $request->status ? '1' : '0';
        $data['hit'] = $request->hit ? '1' : '0';
        $save = $product->update($data);
        
        if (!empty($save)) {
            $this->productRepository->editFilter($id, $data);
            $this->productRepository->editRelatedProduct($id, $data);
            $this->productRepository->saveGallery($id);
            \Session::forget('single');
            return redirect()
                ->route('market.admin.products.edit', $id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd(__METHOD__);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    public function deleteProduct($id)
    {
        $img_path = $this->productRepository->deleteImgGalleryFromPath($id);
        if (!empty($img_path)) {
            $db = $this->productRepository->deleteFromDB($id);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка удаления картинок']);
        }
        if (!empty($db)) {
            return redirect()
                ->route('market.admin.products.index')
                ->with(['success' => 'Успешно удалено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
    
    /**
    *  Related products
    */
    public function related(Request $request)
    {
        $q = isset($request->q) ? htmlspecialchars(trim($request->q)) : '';
        $data['items'] = [];
        $limit = 8;
        $products = $this->productRepository->getProducts($q, $limit);
        $edited_product_id = $request->this_id ?? 0;
         
        if (!empty($products)){
            $i = 0;
            foreach ($products as $product){
                if ($product->id != $edited_product_id) {
                    $data['items'][$i]['id'] = $product->id;
                    $data['items'][$i]['text'] = $product->title;
                    $i++;
                }
            }
        }
        echo json_encode($data);
        die;
    }
    
    /**
    * Ajax upload single image
    * @param AdminImageUploadRequest $request
    */
    
    public function ajaxImageUpload(AdminImageUploadRequest $request) 
    {
        if ($request->isMethod('get')) {
            return view('market.admin.product.include.image_single_edit');
        } else {
            $extension = $request->file('file')->getClientOriginalExtension();
            $dir = 'uploads/single/';
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $request->file('file')->move($dir, $filename);
            $wmax = marketApp::get_instance()->getProperty('img_width');
            $hmax = marketApp::get_instance()->getProperty('img_height');
            $this->productRepository->uploadImg($dir, $filename, $wmax, $hmax);
            
            return $filename;
        }
    }
    
    /**
    * Delete single image
    */
    
    public function ajaxImageRemove($filename) 
    {
        \File::delete('uploads/single/' . $filename);
    }
    
    /**
    * Ajax gellery upload
    * @param AdminImageUploadRequestd $request
    */
    
    public function ajaxGalleryUpload(AdminImageUploadRequest $request) 
    {
        if (isset($_GET['upload'])) {
            $wmax = marketApp::get_instance()->getProperty('gallery_width');
            $hmax = marketApp::get_instance()->getProperty('gallery_height');
            $name = $_POST['name'];
            $dir = 'uploads/gallery/';
            $this->productRepository->uploadGallery($dir, $name, $wmax, $hmax);
        }
    }
    
    public function ajaxGalleryDelete ()
    {
        $id = $_POST['id'] ?? null;
        $src = $_POST['src'] ?? null;
        if (!$id || !$src) {
            return;
        }
        if (\DB::delete("DELETE FROM galleries WHERE product_id = ? AND img = ?", [$id, $src])) {
            unlink("uploads/gallery/$src");
            exit('1');
        }
        return;
    }
    
    /**
    * Return product status = 1
    */
    public function returnStatus ($id)
    {
        $result = $this->productRepository->returnStatusOne($id);
        
        if (!empty($result)) {
            return redirect()
                ->route('market.admin.products.index')
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения']);
        }
    }
    
    /**
    * Return product status = 0
    */
    public function deleteStatus ($id)
    {
        $result = $this->productRepository->deleteStatusOne($id);
        
        if (!empty($result)) {
            return redirect()
                ->route('market.admin.products.index')
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения']);
        }
    }
}
