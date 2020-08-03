var show = 8;
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('.number-items').click(function () {
        show = $(this).data('val');
        var products = $('.product-item').length;
        var numberPages = products / show;
        $('.number-page').addClass('d-none');
        $('.number-page').each(function (i,e) {
            if(i < numberPages){
                $(e).removeClass('d-none');
            }
        });
        $('.current-number-items').text(show);
        $('.page-item').removeClass('active');
        $('.page-link[data-val="1"]').parent('.page-item').addClass('active');
        $('.pagination .active').click();
    });

    $('.page-item').click(function () {
        $('.product-item').removeClass('d-none').addClass('d-none');
        switch ($(this).find('a').data('val')) {
            case '--':
                var currentValue = $('.pagination .active').find('a').data('val');
                currentValue = currentValue - 1;
                var max = currentValue * show;
                var start = max - show;
                $('.page-item').removeClass('active');
                $('.page-link[data-val="'+(currentValue)+'"]').parent('.page-item').addClass('active');
                $('.product-item').each(function (i,e) {
                    if(i >= start && i < max){
                        $(e).removeClass('d-none');
                    }
                });
                break;

            case '++':
                var currentValue = $('.pagination .active').find('a').data('val');
                currentValue = currentValue + 1;
                var max = currentValue * show;
                var start = max - show;
                $('.page-item').removeClass('active');
                $('.page-link[data-val="'+(currentValue)+'"]').parent('.page-item').addClass('active');
                $('.product-item').each(function (i,e) {
                    if(i >= start && i < max){
                        $(e).removeClass('d-none');
                    }
                });
                break;

            default:
                var currentValue = $(this).find('a').data('val');
                var max = currentValue * show;
                var start = max - show;
                $('.page-item').removeClass('active');
                $(this).addClass('active');
                $('.product-item').each(function (i,e) {
                    if(i >= start && i < max){
                        $(e).removeClass('d-none');
                    }
                });
                break;
        }
        if($('.page-link[data-val="'+(currentValue+1)+'"]').length === 0){
                $('.next-page').addClass('disabled');
        }else{
            if($('.page-link[data-val="'+(currentValue+1)+'"]').parent('.page-item').hasClass('d-none')){
                $('.next-page').addClass('disabled');
            }else{
                $('.next-page').removeClass('disabled');
            }
        }
        if($('.page-link[data-val="'+(currentValue-1)+'"]').length === 0){
            $('.previous-page').addClass('disabled');
        }else{
            $('.previous-page').removeClass('disabled');
        }
    });

});
