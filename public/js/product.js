$(document).on('click','.quick-view',function () {
    /*console.log(this.id);*/
    let id = this.id;
    $.ajax({
        'url'   : '/product-detail',
        'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        'type'  : 'POST',
        'data'  : {'id' : id},
        'cache' : false,
        success: function (result) {
            $('.simpleLens-big-image').attr('src',result.image)
            $('.aa-product-view-price').html('&#8369; '+result.price)
            $('.stock').text(result.quantity)
            $('.title').text(result.title)
            $('.description').text(result.description)
            $('.category-link').text(result.category).attr('href',result.permalinkUrl)
            $('.qty_input').val(+result.quantity)
        },error: function (result) {
            console.log(result.status);
        }
    });
});