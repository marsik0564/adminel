@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('market.admin.components.breadcrumbs');
            @slot('title') Редактирование товара {{ $product->title }} @endslot
            @slot('parent') Главная @endslot
            @slot('product') Список товаров @endslot           
            @slot('active') Редактирование товара @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('market.admin.products.update', $product->id) }}" 
                        method="post" data-toggle="validator" id="add">
                        @method('PATCH')
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование товара</label>    
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Наименование товара" required 
                                    value="{{ $product->title }}" 
                                />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Категория товара</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option disabled>-- Выберите категорию --</option>
                                    @include('market.admin.product.include.product_categories_all_list', 
                                    ['categories' => $categories])
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keywords">Ключевые слова</label>
                                <input type="text" name="keywords" id="keywords" 
                                    class="form-control" 
                                    placeholder="Ключевые слова" 
                                    value="{{ $product->keywords }}" 
                                />
                            </div>
                            <div class="form-group">
                                <label for="description">Описание</label>
                                <input type="text" name="description" id="description" 
                                    class="form-control" 
                                    placeholder="Описание" 
                                    value="{{ $product->description }}" 
                                />
                            </div>
                            <div class="form-group has-feedback">
                                <label for="price">Цена</label>    
                                <input type="text" name="price" class="form-control" id="price"
                                    placeholder="Цена" required pattern="^[0-9]+\.?[0-9]*$"
                                    value="{{ $product->price }}" 
                                    data-error="Допускаются цифры и одна десятичная точка"
                                />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="old_price">Старая цена</label>    
                                <input type="text" name="old_price" class="form-control" id="old_price"
                                    placeholder="Старая цена" pattern="^[0-9]+\.?[0-9]*$"
                                    value="{{ $product->old_price }}" 
                                    data-error="Допускаются цифры и одна десятичная точка"
                                />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="editor1">Контент</label>
                                <textarea name="content" id="editor1" class="form-control"  style="resize: none"
                                    cols="80" rows="10">{{ $product->content }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="status" {{ $product->status ? 'checked' : '' }} />
                                    Статус
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="hit" {{ $product->hit ? 'checked' : '' }}/> 
                                    Хит
                                </label>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="related">Связанные товары</label>
                                <p class="text-muted">
                                    <small>Начните вводить наименование товара...</small> 
                                </p>
                                <select name="related[]" class="w-100 select2 form-control" id="related" multiple>
                                    @if (!empty($related_products))
                                        @foreach($related_products as $related_product)
                                            <option value="{{ $related_product->related_id }}" selected>
                                                {{ $related_product->title }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Фильтры продукта</label>
                                {{ Widget::run('filter',['tpl' => 'widgets.filter', 'filter' => $filter,]) }}
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    @include('market.admin.product.include.image_single_edit')
                                </div>
                                <div class="col-md-8">
                                    @include('market.admin.product.include.image_gallery_edit')
                                </div>
                            </div>
                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" id="product_id" value="{{ $product->id }}" />
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </section>
@endsection
