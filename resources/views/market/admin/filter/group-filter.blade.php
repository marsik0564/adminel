@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('market.admin.components.breadcrumbs');
            @slot('title') Группы фильтров @endslot
            @slot('parent') Главная @endslot
            @slot('active') Группы фильтров @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ url('admin/filter/group-filter-add') }}" class="btn btn-primary my-2">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить группу
                            </a>
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Наименование</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($filter_groups as $filter_group)
                                <tr>
                                    <td>{{ $filter_group->id . ' ' . $filter_group->title }}</td>
                                    <td>
                                        <a href="{{ url('admin/filter/group-filter-edit', $filter_group->id) }}" 
                                            title="Редактировать" >
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </a>
                                        <a href="{{ url('admin/filter/group-filter-delete', $filter_group->id) }}" 
                                            class="ml-2"
                                            title="Удалить" >
                                            <i class="fa fa-fw fa-close text-danger delete"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7"><h2>Групп нет</h2></td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
