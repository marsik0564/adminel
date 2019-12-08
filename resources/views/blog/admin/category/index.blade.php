@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('blog.admin.components.breadcrumbs');
            @slot('title') Список меню категорий @endslot
            @slot('parent') Главная @endslot
            @slot('active') Список меню категорий @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="w-100">
                            <small class="ml-5"> 
                                Для редактирования - нажмите на категорию.
                            </small>
                            <small class="ml-5"> 
                                Невозможно удалить категорию, имеющую наследника или товары.
                            </small>
                        </div>
                        @if (isset($menu))
                            <div class="list-group list-group-root well mt-2">
                                @include('blog.admin.category.menu.customMenuItems', 
                                    ['items' => $menu->roots()])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>  
    </section>
@endsection
