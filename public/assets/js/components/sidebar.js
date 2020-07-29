$(document).ready(function () {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });

    $('.head-collapse').click(function () {
        if($(this).find('i').css('transform') == "matrix(1, 0, 0, 1, 0, 0)" || $(this).find('i').css('transform') == "none"){
            $(this).find('i').css({'transform' : 'rotate('+ 180 +'deg)'});
        }else{
            $(this).find('i').css({'transform' : 'rotate('+ 0 +'deg)'});
        }
    });

    $('.btn-filter').click(function () {
        if($(this).hasClass('active-filter')){
            $(this).removeClass('active-filter').removeClass('bg-color-jd');
        }else{
            $(this).addClass('active-filter').addClass('bg-color-jd');
        }
    });

});

