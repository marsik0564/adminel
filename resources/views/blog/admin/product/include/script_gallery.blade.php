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
                        setTimeOut(function () {
                           overlay.hide();
                           response = JSON.parse(response);
                           $('.' + buttonMulti.data('name')).append('<img src="
                               {{ asset('/uploads/gallery') }}/' + responce.file + 
                               '" style="max-height: 150px;">');
                        }, 1000);
                    }
                });
            }
            
            /*Для удаления картинок*/
        } 
    });
</script>