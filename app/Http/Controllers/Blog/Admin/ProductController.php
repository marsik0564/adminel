<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MetaTag;
use App\Repositories\Admin\ProductRepository;
use App\Models\Admin\Product;
use App\Models\Admin\Category;

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
    
    public function ajaxImageUpload() {
        
    }
    
    public function ajaxImageRemove() {
        
    }
}
