@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('blog.admin.components.breadcrumbs');
            @slot('title') Добавление нового товара @endslot
            @slot('parent') Главная @endslot
            @slot('product') Список товаров @endslot           
            @slot('active') Новый товар @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('blog.admin.products.store') }}" 
                        method="post" data-toggle="validator" id="add">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование товара</label>    
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Наименование товара" required 
                                    value="{{ old('title') }}" 
                                />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Категория товара</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option disabled>-- Выберите категорию --</option>
                                    @include('blog.admin.category.include.edit_categories_all_list', 
                                    ['categories' => $categories, 'noLoop' => false])
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keywords">Ключевые слова</label>
                                <input type="text" name="keywords" id="keywords" 
                                    class="form-control" 
                                    placeholder="Ключевые слова" 
                                    value="{{ old('keywords') }}" 
                                />
                            </div>
                            <div class="form-group">
                                <label for="description">Описание</label>
                                <input type="text" name="description" id="description" 
                                    class="form-control" 
                                    placeholder="Описание" 
                                    value="{{ old('description') }}" 
                                />
                            </div>
                            <div class="form-group has-feedback">
                                <label for="price">Цена</label>    
                                <input type="text" name="price" class="form-control" id="price"
                                    placeholder="Цена" required pattern="^[0-9]+.?[0-9]*$"
                                    value="{{ old('price') }}" data-error="Допускаются цифры и одна десятичная точка"
                                />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="old_price">Старая цена</label>    
                                <input type="text" name="old_price" class="form-control" id="old_price"
                                    placeholder="Старая цена" required pattern="^[0-9]+.?[0-9]*$"
                                    value="{{ old('price') }}" data-error="Допускаются цифры и одна десятичная точка"
                                />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="editor1">Контент</label>
                                <textarea name="content" id="editor1" class="form-control"  style="resize: none"
                                    cols="80" rows="10">{{ old('content') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="status" checked /> Статус
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="hit" /> Хит
                                </label>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="related">Связанные товары</label>
                                <p class="text-muted">
                                    <small>Начните вводить наименование товара...</small> 
                                </p>
                                <select name="related[]" class="w-100 select2 form-control" id="related" multiple>  
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Фильтры продукта</label>
                                {{ Widget::run('filter',['tpl' => 'widgets.filter', 'filter' => null,]) }}
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    @include('blog.admin.product.include.image_single_create')
                                </div>
                                <div class="col-md-8">
                                    @include('blog.admin.product.include.image_gallery_create')
                                </div>
                            </div>
                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </section>
@endsection
