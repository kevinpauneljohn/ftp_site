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