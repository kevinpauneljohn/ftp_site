$(document).on('click','.aa-add-card-btn',function () {
    let id = this.id;
    let data = {"value" : id}

    addToCart("/add-to-cart" , data)
});

$(document).on('submit','.quick-view-modal-form',function (form) {
    form.preventDefault();
    let id = this.id;
    let data = $('.quick-view-modal-form').serialize();

    console.log(data);

    addToCart("/add-to-cart" , data)
});

function addToCart(url, data)
{
    /*/update-cart*/
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
                alert(result.message);
            }
        },error: function (result) {
            console.log(result.status);
        }
    });
}