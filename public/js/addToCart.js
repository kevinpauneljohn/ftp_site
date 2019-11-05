function check_value()
{
    let i;
    for (i = 0; i < arguments.length; i++) {

        if($('#'+arguments[i]).val().length > 0){
            $('.'+arguments[i]).closest('div.'+arguments[i]).removeClass('has-error').find('.text-danger').remove();
        }
    }
}
$(document).on('click','.aa-add-card-btn',function () {
    let id = this.id;
    let data = {
        "value" : id,
        "action" : "click",
    };

    addToCart("/add-to-cart" , data)
});

$(document).on('submit','.quick-view-modal-form',function (form) {
    form.preventDefault();
    let id = this.id;
    let data = $('.quick-view-modal-form').serialize();

    addToCart("/add-to-cart" , data)
    check_value('orderQuantity');
    return false;
});

function addToCart(url, data)
{
    $.ajax({
        'url'   : url,
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : data,
        'cache' : false,
        success: function (result) {
            console.log(result);
            if(result.success === true)
            {
                $('.aa-cart-notify').text(result.quantity);
            }else if(result.success !== null)
            {
                //alert(result.message);
            }

            $.each(result, function (key, value) {
                var element = $('#'+key);

                element.closest('div.'+key)
                    .addClass(value.length > 0 ? 'has-error' : 'has-success')
                    .find('.text-danger')
                    .remove();
                element.after('<p class="text-danger">'+value+'</p>');
            });
        },error: function (result) {
            console.log(result.status);
        }
    });
}