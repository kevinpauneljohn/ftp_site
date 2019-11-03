function check_value()
{
    let i;
    for (i = 0; i < arguments.length; i++) {

        if($('#'+arguments[i]).val().length > 0){
            $('.'+arguments[i]).closest('div.'+arguments[i]).removeClass('has-error').find('.text-danger').remove();
        }
    }
}

$(document).on('submit','.aa-login-form',function (form) {
    form.preventDefault();
    let data = $('.aa-login-form').serialize();

    $.ajax({
        'url'   : '/ajax-login',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : data,
        'cache' : false,
        success: function (result) {
            if(result.success == true)
            {
                setTimeout(function(){
                    $('.aa-login-form').trigger('reset');
                    $('#login-modal').modal('toggle');

                    setTimeout(function(){
                        location.reload();
                    },1500);
                });
            }else if(result.error === "invalid credential")
            {
                setTimeout(function(){
                    $('#status').html('<div class="alert alert-warning error-message">'+result.error+'</div>');


                    setTimeout(function(){
                        $('.error-message').remove();
                    },3000);
                });
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
    check_value('accessAccount','password');
    return false;
});