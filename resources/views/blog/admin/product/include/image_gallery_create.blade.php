<div class="box box-info box-solid file-upload">
    <div class="box-header">
        <h3 class="box-title">Картинки галереи</h3>
    </div>
    <div class="box-body" id="galleryjs">
        <div id="multi" class="btn btn-success" data-url="{{ url('/admin/products/gallery') }}" data-name="multi">
            Загрузить
        </div>
        <div class="multi"></div>
        <p class="text-muted my-2">
            <small>Вы можете загружать по очереди любое кол-во</small>
            <br />
            <small>Рекомендуемые размеры: 700х1000</small>
        </p>
    </div>
    <div class="overlay" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>
