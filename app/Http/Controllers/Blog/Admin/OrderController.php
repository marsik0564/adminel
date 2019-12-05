<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MetaTag;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\OrderRepository;

class OrderController extends AdminBaseController
{
    private $orderRepository;
    
    public function __construct()
    {
        parent::__construct();
        $this->orderRepository = app(OrderRepository::class);      
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 10;
        $countOrders = MainRepository::getCountOrders();
        $paginator = $this->orderRepository->getAllOrders($perpage);
        Metatag::setTags(['title' => 'Список заказов']);
        return view('blog.admin.order.index', compact('countOrders', 'paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $item = $this->orderRepository->getId($id);
        if (empty($id)) {
            abort(404);
        }
        $order = $this->orderRepository->getOneOrder($item->id);
        if (empty($order)) {
            abort(404);
        }
        $order_products = $this->orderRepository->getAllOrderProductId($item->id);
        
        
        Metatag::setTags(['title' => "Заказ №{$item->id}"]);
        return view('blog.admin.order.edit', compact('order', 'item', 'order_products'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}