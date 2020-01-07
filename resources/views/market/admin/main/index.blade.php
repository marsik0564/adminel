@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('market.admin.components.breadcrumbs');
            @slot('title') Панель управления @endslot
            @slot('parent') Главная @endslot
            @slot('active') Панель управления @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-6 col-xl-3">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h4>Кол-во заказов: {{ $countOrders ?? 0 }}</h4>
                        <p>New orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('market.admin.orders.index') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        <div class="col-lg-6 col-xl-3">
            <div class="small-box bg-green">
                <div class="inner">
                    <h4>Кол-во продуктов: {{ $countProducts ?? 0 }}</h4>
                    <p>New products</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('market.admin.products.index') }}" class="small-box-footer">
                    More info
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
            <div class="col-lg-6 col-xl-3">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h4>Кол-во юзеров: {{ $countUsers ?? 0}}</h4>
                        <p>Users Regisrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('market.admin.users.index') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h4>Кол-во категорий: {{ $countCategories ?? 0}}</h4>
                        <p>Categories</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('market.admin.categories.index') }}" class="small-box-footer">
                        More info
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                @include('market.admin.main.include.orders')
            </div>
            <div class="col-md-6">
                @include('market.admin.main.include.recently')
            </div>
        </div>
  
    </section>
@endsection
