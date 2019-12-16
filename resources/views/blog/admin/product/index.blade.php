@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('blog.admin.components.breadcrumbs');
            @slot('title')Список товаров @endslot
            @slot('parent')Главная @endslot
            @slot('active')Список товаров @endslot
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
                                    <th>Категория</th>
                                    <th>Наименование</th>
                                    <th>Цена</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($products as $product)
                                <tr style="
                                    @if($product->status == 0)font-weight: bold;
                                    @endif ">
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->cat }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->status ? 'On' : 'Off' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('blog.admin.products.edit', $product->id) }}" 
                                            title="Редактировать товар" >
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                        @if ($product->status == 0)
                                        <a title="Перевести статус = On" class="delete ml-2"
                                        href="{{ route('blog.admin.products.destroy', $product->id) }}" 
                                        >
                                            <i class="fa fa-fw fa-refresh"></i>
                                        </a>
                                        @else
                                        <a title="Перевести статус = Off" class="delete ml-2"
                                        href="{{ route('blog.admin.products.destroy', $product->id) }}" 
                                        >
                                            <i class="fa fa-fw fa-close"></i>
                                        </a>
                                        @endif
                                        
                                        <a title="Удалить из БД" class="deletebd ml-2"
                                        href="{{ route('blog.admin.orders.destroy', $product->id) }}"
                                        >
                                            <i class="fa fa-fw fa-close text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7"><h2>Продуктов нет</h2></td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                        <p>{{ count($products) }} Заказа(ов) из {{ $products->total() }}</p>
                            @if ($products->total() > $products->count())
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                        {{ $products->links()}}   
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