function check_value()
{
    let i;
    for (i = 0; i < arguments.length; i++) {

        if($('#'+arguments[i]).val().length > 0){
            $('.'+arguments[i]).closest('div.'+arguments[i]).removeClass('has-error').find('.text-danger').remove();
        }
    }
}

$(document).on('click','.quick-view',function () {
    /*console.log(this.id);*/
    let id = this.id;
    $.ajax({
        'url'   : '/product-detail',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : {'id' : id},
        'cache' : false,
        success: function (result) {
            $('.simpleLens-big-image').attr('src',result.image)
            $('.aa-product-view-price').html('&#8369; '+result.price)
            $('.stock').text(result.quantity)
            $('.title').text(result.title)
            $('.description').text(result.description)
            $('.category-link').text(result.category).attr('href',result.permalinkUrl)
            $('.qty_input').attr('max',result.quantity);
            $('#product').val('product-'+result.productId);

        },error: function (result) {
            console.log(result.status);
        }
    });
});

$(document).on('click','.edit-btn',function (link) {
    link.preventDefault();
    let id = this.id;

    $.ajax({
        'url'   : '/category-data-display',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : {'id' : id},
        'cache' : false,
        success: function (result) {
            $('#category-id').val(result.id);
            $('#category_name').val(result.name);
            $('#permalink').val(result.permalink);

        },error: function (result) {
            console.log(result.status);
        }
    });
});

$(document).on('submit','#edit-category-form',function (form) {
    form.preventDefault();

    let data = $('#edit-category-form').serialize();

    $.ajax({
        'url'   : '/category-edit-save',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : data,
        'cache' : false,
        success: function (result) {

            if(result.success == true)
            {
                location.reload();
            }
            $.each(result, function (key, value) {
                var element = $('#'+key);

                element.closest('div.'+key)
                    .addClass(value.length > 0 ? 'has-error' : 'has-success')
                    .find('.text-danger')
                    .remove();
                element.after('<p class="text-danger">'+value+'</p>');
            });
            return false;

        },error: function (result) {
            console.log(result.status);
        }
    });
    check_value('category_name','permalink')
});