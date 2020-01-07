@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('market.admin.components.breadcrumbs');
            @slot('title') Добавление валюты @endslot
            @slot('parent') Главная @endslot
            @slot('currency') Список валют @endslot
            @slot('active') Добавление валюты @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('market.admin.currencies.store') }}" method="post" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование валюты</label>    
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Наименование валюты" required 
                                    value="{{ old('title') }}" 
                                />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="code">Код валюты</label>    
                                <input type="text" name="code" class="form-control" id="code"
                                    placeholder="Код валюты" required 
                                    value="{{ old('code') }}" 
                                />
                            </div>
                            <div class="form-group">
                                <label for="symbol_left">Символ слева</label>    
                                <input type="text" name="symbol_left" class="form-control" id="symbol_left"
                                    value="{{ old('symbol_left') }}" 
                                />
                            </div>
                            <div class="form-group">
                                <label for="symbol_right">Символ справа</label>    
                                <input type="text" name="symbol_right" class="form-control" id="symbol_right"
                                    value="{{ old('symbol_right') }}" 
                                />
                            </div>
                            <div class="form-group has-feedback">
                                <label for="value">Значение курса</label>    
                                <input type="text" name="value" class="form-control" id="value"
                                    placeholder="Значение курса к базовой валюте" required pattern="^[0-9]+\.?[0-9]*$"
                                    value="{{ old('value') }}" data-error="Допускаются цифры и одна десятичная точка"
                                />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="base" />
                                    Базовая валюта
                                </label>
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
