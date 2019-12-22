<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MetaTag;
use App\Repositories\Admin\ProductRepository;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\SBlog\Core\BlogApp;

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
        
        Metatag::setTags(['title' => 'Список продуктов']);
        return view('blog.admin.product.index', compact('products', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Category();
        
        Metatag::setTags(['title' => 'Создание нового продукта']);
        return view('blog.admin.product.create', [
            'categories' => Category::with('children')
                ->where('parent_id', '=', '0')
                ->get(),
            'delimiter' => '-',
            'item' => $item,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd(__METHOD__);
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
        dd(__METHOD__);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd(__METHOD__);
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
    *  Related products
    */
    public function related(Request $request)
    {
        $q = isset($request->q) ? htmlspecialchars(trim($request->q)) : '';
        $data['items'] = [];
        $limit = 8;
        $products = $this->productRepository->getProducts($q, $limit);
        
        if (!empty($products)){
            $i = 0;
            foreach ($products as $product){
                $data['items'][$i]['id'] = $product->id;
                $data['items'][$i]['text'] = $product->title;
                $i++;
            }
        }
        echo json_encode($data);
        die;
    }
    /**
    * Ajax upload single image
    * @param Request $request
    */
    public function ajaxImageUpload(Request $request) 
    {
        if ($request->isMethod('get')) {
            return view('blog.admin.product.include.image_single_edit');
        } else {
            $valid = \Validator::make(
                $request->all(), 
                [
                    'file' => 'image|max:5000',
                ],
                [
                    'file.image' => 'Файл должен быть картинкой',
                    'file.max' => 'Максимальный размер файла - 5Мб',
                ]
            );
            if ($valid->fails()) {
                return array (
                    'fail' => true,
                    'errors' => $valid->erorrs()
                );
            }
            
            $extension = $request->file('file')->getClientOriginalExtension();
            $dir = 'uploads/single/';
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $request->file('file')->move($dir, $filename);
            $wmax = BlogApp::get_instance()->getProperty('img_width');
            $hmax = BlogApp::get_instance()->getProperty('img_height');
            $this->productRepository->uploadImg($dir, $filename, $wmax, $hmax);
            
            return $filename;
        }
    }
    
    public function ajaxImageRemove($filename) 
    {
        \File::delete('uploads/single/' . $filename);
    }
}
