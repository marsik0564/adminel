@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('blog.admin.components.breadcrumbs');
            @slot('title') Панель управления @endslot
            @slot('parent') Главная @endslot
            @slot('active') Список заказов @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Покупатель</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($paginator as $order)
                                @php $class = $order->status ? 'success' : '' @endphp
                                <tr class="{{ $class }}">
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>
                                        @if ($order->status == 0)Новый @endif
                                        @if ($order->status == 1)Завершен @endif
                                        @if ($order->status == 2)<b style="color: red">Удален</b> @endif
                                    </td>
                                    <td>{{ $order->sum .' '. $order->currency }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->updated_at ?? $order->created_at}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('blog.admin.orders.edit', $order->id) }}" 
                                            title="Редактировать заказ" >
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                        <a href="{{ route('blog.admin.orders.edit', $order->id) }}" 
                                            title="Удалить из БД" >
                                            <i class="fa fa-fw fa-close text-danger deletebd"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="3"><h2>Заказов нет</h2></td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <p>{{ count($paginator) }} Заказа(ов) из {{ $countOrders }}</p>
                            @if ($paginator->total() > $paginator->count())
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                        {{ $paginator->links()}}   
                                </div>
                            </div >
                            @endif
                        </div >
                    </div>
                </div>
            </div>
        </div>
  
    </section>
@endsection
