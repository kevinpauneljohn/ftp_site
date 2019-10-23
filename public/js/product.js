$(document).on('click','.quick-view',function () {
    /*console.log(this.id);*/
    let id = this.id;

    /*console.log($('meta[name="csrf-token"]').attr('content'));*/
    $.ajax({
        'url'   : '/product-detail',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : {'id' : id},
        'cache' : false,
        success: function (result) {
            console.log(result);
        },error: function (result) {
            console.log(result.status);
        }
    });
});