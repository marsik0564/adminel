<script>
    $(function(){
        if ($('#galleryjs').length > 0) {
            var buttonMulti = $('#multi'),
                file;
            var _token = $('input#_token').val();
            
            var form_data2 = new FormData();
            var overlay = buttonMulti.closest('.file-upload').find('.overlay');
            
            form_data2.append('_token', _token);
            
            if (buttonMulti) {
                new AjaxUpload(buttonMulti, {
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    action : buttonMulti.data('url') + "?upload=1",
                    data : {
                        name : buttonMulti.data('name'),
                        _token : _token
                    },
                    name : buttonMulti.data('name'),
                    onSubmit : function (file, ext) {
                        if (!(ext && /^(jpg|png|jpeg|gif|webp|bmp)$/i.test(ext))) {
                            alert('Ошибка! Разрешены только картинки');
                            return false;
                        }
                        overlay.show(); 
                    },
                    onComplete : function (file, response) {
                        setTimeout(function () {
                           overlay.hide();
                           response = response.slice(0, response.indexOf('}')+1);
                           response = JSON.parse(response);
                           $('.multi').append('<img src="{{ asset('/uploads/gallery') }}/' 
                               + response.file 
                               + '" style="max-height: 150px;" '
                               + 'class="m-1">');
                        }, 1000);
                    }
                });
            }
            
            /*Для удаления картинок*/
            $('.multi').on('click', '.del-items', function(){
                var res = confirm('Подтвердите удаление');
                if (!res) return false;
                var $this = $(this);
                id = $this.data(id);
                src = $this.data(src);
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : '{{ url('/admin/products/delete-gallery') }}',
                    data : {
                        id : id,
                        src : src,
                        _token : _token
                    },
                    type : 'POST',
                    beforeSend : function() {
                        overlay.show();
                    },
                    success : function() {
                        setTimeout(function() {
                            overlay.hide();
                            if (res == 1) $this.fadeOut();
                        }, 1000);
                    }
                });
            });
        } 
    });
</script>