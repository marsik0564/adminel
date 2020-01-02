@extends('layouts.app_admin')

@section('content')

    <section class="content-header">
        @component('blog.admin.components.breadcrumbs');
            @slot('title') Добавить фильтр @endslot
            @slot('parent') Главная @endslot
            @slot('attr_filter') Фильтры @endslot
            @slot('active') Новый фильтр @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ url('/admin/filter/value-filter-add') }}" method="post" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="value">Наименование атрибута</label>    
                                <input type="text" name="value" class="form-control" id="value"
                                    placeholder="Наименование атрибута группы" required 
                                    value="{{ old('value') }}" 
                                />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="attr_group_id">Наименование группы</label>  
                                <select name="attr_group_id" id="attr_group_id" class="form-control" required>
                                    <option disabled>-- выберите группу --</option>
                                    @foreach ($group as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('attr_group_id') == $item->id) selected @endif
                                            >
                                            {{ $item->title }}
                                        </option>
                                    @endforeach
                                </select>
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
