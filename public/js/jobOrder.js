$(document).on('click','.delete-job',function () {
    let id = this.id;
    $.ajax({
        'url'   : '/job-order-data',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : {"id":id},
        'cache' : false,
        success: function (result) {
            $('#job-order-id').val(result.id);
            $('.job-order-name').html('<strong>'+result.title+'</strong>');

        },error: function (result) {
            console.log(result.status);
        }
    });
});

$(document).on('submit','.delete-job-order-form',function (form) {
    form.preventDefault();
    let data = $('.delete-job-order-form').serialize();

    $.ajax({
        'url'   : '/job-order/delete',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : data,
        'cache' : false,
        success: function (result) {
            if(result.success == true)
            {
                location.reload();
            }

        },error: function (result) {
            console.log(result.status);
        }
    });
});

