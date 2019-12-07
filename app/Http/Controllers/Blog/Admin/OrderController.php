<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminOrderSaveRequest;
use Illuminate\Http\Request;
use MetaTag;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\OrderRepository;
use App\Models\Admin\Order;

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

    public function save(AdminOrderSaveRequest $request, $id)
    {
        $result = $this->orderRepository->saveOrderComment($id);
        if ($result) {
            return redirect()
                ->route('blog.admin.orders.edit', $id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'ошибка сохранения']);
        }
    }
    
    public function forcedestroy($id)
    {
        if (empty($id)) {
            return back()
                ->withErrors(['msg' => 'Запись не найдена']);
        }
        $result = Order::withTrashed()->find($id)->forceDelete();
        if ($result) {
            return redirect()
                ->route('blog.admin.orders.index', $id)
                ->with(['success' => 'Успешно удалено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка удаления']);
        }
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
        if (empty($item->id)) {
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

    public function change($id)
    {
        $result = $this->orderRepository->changeStatusOrder($id);
        if ($result){
            return redirect()
                ->route('blog.admin.orders.edit', $id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
            ->withErrors(['msg' => 'ошибка сохранения']);
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
        $st = $this->orderRepository->changeStatusOrder($id, '2');
        if ($st) {
            $result = Order::destroy($id);
            if ($result) {
                return redirect()
                    ->route('blog.admin.orders.index')
                    ->with(['success' => "Запись №$id удалена"]); 
            } else {
                return back()
                    ->withErrors(['msg' => 'ошибка удаления']);
            }
        } else {
            return back()
                ->withErrors(['msg' => 'ошибка изменения статуса']);
        }
    } 
}
