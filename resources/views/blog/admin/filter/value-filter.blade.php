@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('blog.admin.components.breadcrumbs');
            @slot('title') Фильтры @endslot
            @slot('parent') Главная @endslot
            @slot('active') Фильтры @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ url('admin/filter/value-filter-add') }}" class="btn btn-primary my-2">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить атрибут
                            </a>
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Группа</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($values as $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->value }}</td>
                                    <td>{{ $value->title }}</td>
                                    <td>
                                        <a href="{{ url('admin/filter/value-filter-edit', $value->id) }}" 
                                            title="Редактировать" >
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </a>
                                        <a href="{{ url('admin/filter/value-filter-delete', $value->id) }}" 
                                            class="ml-2"
                                            title="Удалить" >
                                            <i class="fa fa-fw fa-close text-danger delete"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7"><h2>Атрибутов нет</h2></td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                        <p>{{ $values->count() }} Атрибута(ов) из {{ $count }}</p>
                            @if ($values->total() > $values->count())
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                        {{ $values->links()}}   
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
