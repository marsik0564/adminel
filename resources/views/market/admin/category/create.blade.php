@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('market.admin.components.breadcrumbs');
            @slot('title') Создание новой категории @endslot
            @slot('parent') Главная @endslot
            @slot('category') Список категорий @endslot
            @slot('active') Создание новой категории @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('market.admin.categories.store') }}" 
                        method="post" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование категории</label>    
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Наименование категории" required 
                                    value="{{ old('title') }}" 
                                />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <select name="parent_id" id="parent_id" class="form-control" required>
                                    <option value="0">-- самостоятельная категория --</option>
                                    @include('market.admin.category.include.edit_categories_all_list', 
                                    ['categories' => $categories, 'noLoop' => false])
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keywords">Ключевые слова</label>
                                <input type="text" name="keywords" id="keywords" 
                                    class="form-control" required
                                    placeholder="Ключевые слова" 
                                    value="{{ old('keywords') }}" 
                                />
                            </div>
                            <div class="form-group">
                                <label for="description">Описание</label>
                                <input type="text" name="description" id="description" 
                                    class="form-control" required
                                    placeholder="Описание" 
                                    value="{{ old('description') }}" 
                                />
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">Добавить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </section>
@endsection
