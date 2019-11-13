function check_value()
{
    let i;
    for (i = 0; i < arguments.length; i++) {

        if($('#'+arguments[i]).val().length > 0){
            $('.'+arguments[i]).closest('div.'+arguments[i]).removeClass('has-error').find('.text-danger').remove();
        }
    }
}

$(document).on('click','.operation',function () {
    let value = this.value;

    $.ajax({
        'url'   : '/status-action',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : {'value' : value},
        'cache' : false,
        success: function (result) {
            console.log(result);
            if(result.success === true)
            {
                location.reload();
            }
        },error: function (result) {
            console.log(result.status);
        }
    });
});

$(document).on('submit','#create-task-form', function (form) {
    form.preventDefault();
    let data = $('#create-task-form').serialize();
    $.ajax({
        'url'   : '/create-task',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : data,
        'cache' : false,
        success: function (result) {
            console.log(result);

            if(result.success === true)
            {
                location.reload();
                /*setTimeout(function(){
                    $('#create-task-form').trigger('reset');
                    $('#create-task').modal('toggle');


                    setTimeout(function(){
                        location.reload();
                    },1500);
                });*/
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
});

$('.status-display').change(function() {

    let value = $('.status-display').val();
    let action = $('.action').val();
    $.ajax({
        'url'   : '/set-status',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : {
            'status' : value,
            'action' : action
        },
        'cache' : false,
        success: function (result) {
            console.log(result);
            location.reload();
        },error: function (result) {
            console.log(result.status);
        }
    });
});