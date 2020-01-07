@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('market.admin.components.breadcrumbs');
            @slot('title') Добавление пользователя @endslot
            @slot('parent') Главная @endslot
            @slot('user') Список пользователей @endslot           
            @slot('active') Добавление пользователя @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('market.admin.users.store') }}" 
                        method="post" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="name">Имя</label>    
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Введите имя" required 
                                    value="{{ old('name', '') }}" 
                                />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label>Пароль</label>
                                <input type="password" name="password" 
                                    class="form-control" required
                                    placeholder="Введите пароль" 
                                />
                            </div>
                            <div class="form-group">
                                <label>Подтверждение пароля</label>
                                <input type="password" name="password_confirmation" 
                                    class="form-control" required
                                    placeholder="Повторите пароль" 
                                />
                            </div>
                            <div class="form-group has-feedback">
                                <label for="email">Email</label>    
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Введите адрес электронной почты" required 
                                    value="{{ old('email', '') }}" 
                                />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="role">Роль</label>
                                <select  name="role" id="role" class="form-control">
                                    <option value="2" selected>Пользователь</option>
                                    <option value="3">Администратор</option>
                                    <option value="1">Disabled</option>
                                </select>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </section>
@endsection
