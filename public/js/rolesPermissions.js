$(document).on('submit','.permission-form',function (form) {
    form.preventDefault();

    let data = $('.permission-form').serialize();

    $.ajax({
        'url'   : '/permission',
        'type'  : 'POST',
        'data'  : data,
        'cache' : false,
        success: function (result) {
        console.log(result);
        },error: function (result) {
            console.log(result.status);
        }
    });
});