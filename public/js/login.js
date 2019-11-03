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
    console.log(data);

    $.ajax({
        'url'   : '/ajax-login',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : data,
        'cache' : false,
        success: function (result) {
            console.log(result);
            if(result.success == true)
            {
                setTimeout(function(){
                    // $('#add-call-center').trigger('reset');
                    // $('#callCenterModal').modal('toggle');

                    setTimeout(function(){
                        location.reload();
                    },1500);
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