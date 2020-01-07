@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        <h1>
            Редактировать
            Заказ №{{ $item->id }}
            @if ($order->status == 0)
                <a href="{{ route('market.admin.orders.change', $item->id) }}/?status=1" 
                    class="btn btn-success btn-xs">
                    Одобрить
                </a>
                <a href="#" class="btn btn-warning btn-xs redact">Редактировать</a>
            @elseif ($order->status == 1)
                <a href="{{ route('market.admin.orders.change', $item->id) }}/?status=0" 
                    class="btn btn-secondary btn-xs">Вернуть на доработку</a>
            @endif  
            @if ($order->status != 2)         
                <form id="delform" method="post" class="d-inline-block"
                    action="{{ route('market.admin.orders.destroy', $item->id) }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-xs delete">Удалить</button>
                </form>
            @endif
        </h1>
    
    
    
    
    
        @component('market.admin.components.breadcrumbs');
            @slot('parent') Главная @endslot
            @slot('order') Список заказов @endslot
            @slot('active') Заказ №{{ $item->id }} @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <form method="post" action="{{ route('market.admin.orders.save', $item->id) }}">
                            @csrf
                            <table class="table table-hover table-bordered">
                                <tbody>
                                <tr>
                                    <td>Номер заказа</td>
                                    <td>{{ $item->id }}</td>
                                </tr>
                                <tr>
                                    <td>Дата заказа</td>
                                    <td>{{ $order->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>Дата изменения</td>
                                    <td>{{ $order->updated_at }}</td>
                                </tr>
                                <tr>
                                    <td>Кол-во позиций в заказе</td>
                                    <td>{{ count($order_products) }}</td>
                                </tr>
                                <tr>
                                    <td>Сумма</td>
                                    <td>{{ $order->sum . ' ' . $order->currency }}</td>
                                </tr>
                                <tr>
                                    <td>Имя заказчика</td>
                                    <td>{{ $order->name }}</td>
                                </tr>
                                <tr>
                                    <td>Статус</td>
                                    <td>
                                        @if ($order->status == 0)Новый @endif
                                        @if ($order->status == 1)Завершен @endif
                                        @if ($order->status == 2)
                                        <b style="color: red">Удален</b> @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Комментарий</td>
                                    <td>
                                        <textarea name="comment" rows="3"  cols="40" style="resize:none"
                                        placeholder="@if(!$order->note)Комментариев нет@endif"
                                        >{{ $order->note ?? ''}}</textarea>
                                        
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <input class="btn btn-warning" type="submit" name="submit" value="Сохранить" />
                            </form>
                        </div>
                    </div>
                </div>
                <h3>Детали заказа</h3>
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Кол-во</th>
                                    <th>Цена</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $qty = 0 @endphp
                                @foreach($order_products as $product)

                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->qty , $qty += $product->qty }}</td>
                                        <td>{{ $product->price }}</td>
                                    </tr>
                                @endforeach
                                    
                                    <tr class="active">
                                        <td colspan="2"><b>Итого</b></td>
                                        <td><b>{{ $qty }}</b></td>
                                        <td><b>{{ $order->sum . ' ' . $order->currency }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>
@endsection
