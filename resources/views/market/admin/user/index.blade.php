@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('market.admin.components.breadcrumbs');
            @slot('title') Список пользователей @endslot
            @slot('parent') Главная @endslot
            @slot('active') Список пользователей @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Логин</th>
                                    <th>Email</th>
                                    <th>Имя</th>
                                    <th>Роль</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($paginator as $user)
                                <tr class="
                                    @if($user->role=='admin')table-success
                                    @elseif($user->role=='disabled')table-danger
                                    @endif">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->name) }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('market.admin.users.edit', $user->id) }}" 
                                            title="Просмотреть пользователя" class="btn btn-success">
                                            Просмотреть
                                        </a>
                                        <form action="{{ route('market.admin.users.destroy', $user->id) }}"
                                        method="post" class="d-inline-block ml-2">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger btn-xs delete" type="submit">
                                                Удалить
                                            </button>
                                        </form> 
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7"><h2>Пользователей нет</h2></td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                        <p>{{ count($paginator) }} пользователя(ей) из {{ $countUsers }}</p>
                            @if ($paginator->total() > $paginator->count())
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                        {{ $paginator->links()}}   
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
