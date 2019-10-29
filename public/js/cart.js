$(document).on('click','.update',function () {
    let id = this.id;
    let qty = $('#qty-'+this.value).val();

    $.ajax({
        'url'   : '/update-cart',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : {
            'id'    : id,
            'qty'   : qty
        },
        'cache' : false,
        success: function (result) {
          if(result.success === true)
          {
              location.reload();
          }else{
              setTimeout(function(){

                  $('.status').html('<div class="alert alert-warning stock-availability">Quantity cannot be greater than the available stock</div>');

                  setTimeout(function(){
                      $('.stock-availability').remove();
                  },3000);
              });
          }
        },error: function (result) {
            console.log(result.status);
        }
    });
});