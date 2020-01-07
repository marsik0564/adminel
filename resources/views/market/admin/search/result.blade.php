@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('market.admin.components.breadcrumbs');
            @slot('title') Поиск по запросу "{{ $query }}"@endslot
            @slot('parent') Главная @endslot
            @slot('active') Поиск @endslot
        @endcomponent
    </section>
    <div class="prdt">
        <div class="container">
            <div class="prdt-top">
                <div class="prdt-left">
                    @if (!empty($products))
                    <div class="product-one row">
                        @foreach ($products as $product)
                        <div class="col-md-4 product-left p-left">
                            <div class="product-main simleCart_shelfItem">
                                <a href="#" class="mask">
                                    @if (empty($product->img))
                                        <img class="image-responsive zoom-img" 
                                            src="{{ asset('/images/no_image.jpg') }}"
                                            alt="no_image" />
                                    @else
                                        <img class="image-responsive zoom-img" 
                                            src="{{ asset("/uploads/single/$product->img") }}"
                                            alt="image" />
                                    @endif
                                </a>
                                <div class="product-bottom">
                                    <a href="#" class="mask"><h3>{{ $product->title }}</h3></a>
                                    <p>Explore Now</p>
                                    <h4>
                                        <a data-id="{{ $product->id }}" class="add-to-cart-link" href="#">
                                            <i></i>
                                        </a>
                                        <span class="item_price" >
                                            {{ $currency->symbol_left }} 
                                            {{ $product->price * $currency->value }}
                                            {{ $currency->symbol_right }}
                                        </span>
                                        @if (!empty($product->old_price))
                                        <small><del>
                                            {{ $currency->symbol_left }} 
                                            {{ $product->old_price * $currency->value }}
                                            {{ $currency->symbol_right }}
                                        </del></small>
                                        @endif
                                    </h4>
                                </div>
                                <div class="srch srch1">
                                    <span>{{ $product->description }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection
