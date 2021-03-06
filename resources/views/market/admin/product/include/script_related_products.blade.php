<script>
    $(function(){
        $('.select2').select2({
            placeholder : 'Начните вводить наименование товара',
            cache       : true,
            ajax        : {
                url            : "{{ url('/admin/products/related') }}",
                delay          : 500,
                dataType       : 'json',
                data           : function (params) {
                    return {
                        q       : params.term,
                        page    : params.page,
                        this_id : $('#product_id').val()
                    };
                },
                processResults : function (data, params) {
                    return {
                        results : data.items 
                    };
                }
            }
        });
    });
</script>