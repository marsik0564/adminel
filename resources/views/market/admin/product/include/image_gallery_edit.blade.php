<div class="box box-info box-solid file-upload">
    <div class="box-header">
        <h3 class="box-title">Картинки галереи</h3>
    </div>
    <div class="box-body" id="galleryjs">
        <div id="multi" class="btn btn-success" 
            data-url="{{ url('/admin/products/gallery') }}" data-name="multi" title="">
            Загрузить
        </div>
        <div class="multi">
            @if (!empty($images))
                <p class="text-muted">
                    <small>Для удаления нажмите на картинку</small>
                </p>
                @foreach($images as $image)
                    <img src="{{ asset("/uploads/gallery/$image") }}" alt="gallery_img" data-id="{{ $product->id}}"
                        data-src="{{ $image }}" class="del-items m-1" style="max-height: 150px;" />
                @endforeach
            @endif
            <p class="text-muted my-2">
                <small>Рекомендуемые размеры: 700х1000</small>
            </p>
        </div>
    </div>
    <div class="overlay" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>
