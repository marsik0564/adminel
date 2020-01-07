@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('market.admin.components.breadcrumbs');
            @slot('title')Редактирование пользователя {{ $item->name }} @endslot
            @slot('parent')Главная @endslot
            @slot('user')Список пользователей @endslot
            @slot('active')Редактирование пользователя №{{ $item->id }} @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('market.admin.users.update', $item->id) }}" 
                        method="post" data-toggle="validator">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="name">Логин</label>    
                                <input type="text" name="name" class="form-control" id="name"
                                    required value="{{ old('name', $item->name) }}" 
                                />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label>Пароль</label>
                                <input type="password" name="password" 
                                    class="form-control" 
                                    placeholder="Введите пароль, если хотите его изменить" 
                                />
                            </div>
                            <div class="form-group">
                                <label>Подтверждение пароля</label>
                                <input type="password" name="password_confirmation" 
                                    class="form-control" 
                                    placeholder="Подтверждение пароля" 
                                />
                            </div>
                            <div class="form-group">
                                <label>Имя <small class="text-muted">меняется аватоматически</small> </label>
                                <input type="text" class="form-control" disabled
                                    value="{{ ucfirst($item->name) }}" 
                                />
                            </div>
                            <div class="form-group has-feedback">
                                <label for="email">Email</label>    
                                <input type="email" name="email" class="form-control" id="email" required 
                                    value="{{ old('email', $item->email) }}" 
                                />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="role">Роль</label>
                                <select  name="role" id="role" class="form-control">
                                    <option value="2" {{ $role->name == 'user' ? 'selected' : '' }}>
                                        Пользователь 
                                    </option>
                                    <option value="3" {{ $role->name == 'admin' ? 'selected' : '' }}>
                                        Администратор
                                    </option>
                                    <option value="1" {{ $role->name == 'disabled' ? 'selected' : ''}}>
                                        Disabled
                                    </option>
                                </select>
                            </div>
                            <div class="box-footer">
                                <input type="hidden" name="id" value="{{ $item->id }}" />
                                <button type="submit" class="btn btn-success">Редактировать</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h3>Заказы пользователя</h3>
                <div class="box">
                    <div class="box-body">
                        @if($count)
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                <tr class="
                                    @if($order->status==1)table-success
                                    @elseif($order->status==2)table-danger
                                    @endif">
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        @if ($order->status == 0)Новый 
                                        @elseif ($order->status == 1)Завершен 
                                        @else <b style="color: red">Удален</b> @endif
                                    </td>
                                    <td>{{ $order->sum .' '. $order->currency }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->updated_at }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('market.admin.orders.edit', $order->id) }}" 
                                            title="Редактировать заказ" >
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <p class="text-danger">Пользователь пока ничего не заказывал</p>
                        @endif                        
                    </div>
                </div>
                <div class="text-center">
                    <p>{{ $orders->count() }} Заказа(ов) из {{ $count }}</p>
                    @if ($orders->total() > $orders->count())
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                {{ $orders->links()}}   
                            </div>
                        </div >
                    @endif
                </div >
            </div>
        </div>  
    </section>
@endsection
