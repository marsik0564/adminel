<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title">Базовое изображение</h3>
    </div>
    
    <div class="box-body text-center position-relative" id="image">
        @if (!empty($product->img))
            <img width="50%" height="50%" src="{{ asset("/uploads/single/$product->img") }}" id="preview_image" />
        @else
            <img width="50%" height="50%" src="{{ asset('/images/no_image.jpg') }}" id="preview_image" />
        @endif
        <i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" 
            style="position: absolute; left: 40%; top: 40%; display: none;">
        </i>
    </div>
    <p class="text-center">
        <a href="javascript:changeProfile()" style="text-decoration: none" data-name="single">
            <i class="fa fa-image"></i>Загрузить
        </a>
        <a href="javascript:removeFile()" style="color: red; text-decoration: none" class="ml-3 myimg"
            data-name="{{ $product->img ?? '' }}">
            <i class="fa fa-trash"></i>Удалить
        </a>
    </p>
    <input type="file" id="file" style="display: none" />
    <input type="hidden" name="img" id="file_name" value="{{ $product->img ?? '' }}"/>
    <p class="text-muted text-center"><small>Рекомендуемые размеры: 125х200</small></p>
</div>