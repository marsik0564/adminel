@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('market.admin.components.breadcrumbs');
            @slot('title') Список валют @endslot
            @slot('parent') Главная @endslot
            @slot('active') Список валют @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ route('market.admin.currencies.create') }}" class="btn btn-primary my-2">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить валюту
                            </a>
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Код</th>
                                    <th>Значение</th>
                                    <th>Базовая</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($currencies as $currency)
                                <tr>
                                    <td>{{ $currency->id }}</td>
                                    <td>{{ $currency->title }}</td>
                                    <td>{{ $currency->code }}</td>
                                    <td>{{ $currency->value }}</td>
                                    <td>@if ($currency->base == 1) Да @else Нет @endif</td>
                                    <td>
                                        <a href="{{ route('market.admin.currencies.edit', $currency->id) }}" 
                                            title="Редактировать" >
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                        <a href="{{ route('market.admin.currencies.delete-currency', $currency->id) }}" 
                                            class="ml-2"
                                            title="Удалить" >
                                            <i class="fa fa-fw fa-close text-danger delete"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7"><h2>Валют нет</h2></td>
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
