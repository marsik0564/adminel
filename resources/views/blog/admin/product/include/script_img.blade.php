<script>
    function changeProfile() {
       $('#file').click();
    }
   
    $('#file').change(function() {
        if ($(this).val() != '') {
            upload(this);  
        }
    });
   
    function upload(img) {
        var form_data = new FormData();
        form_data.append('file', img.files[0]);
        form_data.append('_token', '{{ csrf_token() }}');
        $('#loading').show();
        $.ajax({
            url : "{{ url('adimn/products/ajax-image-upload') }}",
            data : form_data,
            type : 'POST',
            contentType : false,
            processData : false,
            success : function (data) {
                if (data.fail) {
                    $('#preview_image').attr('src', "{{ asset('images/no_image.jpg') }}");
                    alert(data.errors['file']);
                } else {
                    $('#file_name').val(data);
                    $('#preview_image').attr('src', "{{ asset('uploads/single') }}/" + data);
                };

            },
            error : function (xhr, status, error) {
                alert(xhr.responseText);
                $('#preview_image').attr('src', "{{ asset('images/no_image.jpg') }}");
            }
        });
        $('#loading').hide();
    }
    
    function removeFile() {
        if ($(this).val() != '') {
            if (confirm('Вы точно хотите удалить эту картинку')) {
                $('#loading').show();
                var form_data = new FormData();
                form_data.append('_method', 'DELETE');
                form_data.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url : "{{ url('adimn/products/ajax-image-remove') }}" + '/' +  $('#file_name').val(),
                    data : form_data,
                    type : 'POST',
                    contentType : false,
                    processData : false,
                    success : function (data) {
                        $('#preview_image').attr('src', "{{ asset('images/no_image.jpg') }}");
                        $('#file_name').val('');
                    },
                    error : function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
                $('#loading').hide();
            }
        }
    }
</script>