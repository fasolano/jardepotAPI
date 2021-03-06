var show = 16, order = "default";
$(document).ready(function () {
    // $('[data-toggle="tooltip"]').tooltip();

    $('.number-items').click(function () {
        show = $(this).data('val');
        var products = $('.product-item').length;
        var numberPages = products / show;
        $('.number-page').addClass('d-none');
        $('.pagination-container').each(function (index, element) {
            $(element).find('.number-page').each(function (i,e) {
                if(i < numberPages){
                    $(e).removeClass('d-none');
                }
            });
        });
        $('.current-number-items').text(show);
        $('.page-item').removeClass('active');
        $('.page-link[data-val="1"]').parent('.page-item').addClass('active');
        $('.pagination .active').click();
    });

    $('.page-item').click(function () {
        if(!$(this).hasClass('disabled')){
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
                    $('.page-link[data-val="'+(currentValue)+'"]').parent('.page-item').addClass('active');
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
        }
    });

    $('#orderBy').change(function () {
        order = $(this).val();
        reloadProducts();
    });

    $('#form-failed').on('keypress',function (e) {
        if(e.which == 13) {
            $('#search-form').submit();
        }
    });

    $('#btn-form').click(function () {
        $("#form-failed").submit();
    });

    $("#form-failed").submit(function(e) {
        e.preventDefault();
    }).validate({
        rules: {
            "nombre": {  // <-- this is the name attribute, NOT id
                required: true,
                minlength: 3,
                maxlength: 60
            },
            "telefono": {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            "comentario": {
                maxlength: 100
            }
        },
        messages: {
            "nombre": {
                required: "Introduce tu nombre.",
                maxlength: "Debe contener máximo 60.",
                minlength: "Debe contener mínimo 3 letras."
            },
            "telefono": {
                required: "Introduce tu teléfono.",
                digits: "Introduce un número válido.",
                maxlength: "Debe contener 10 dígitos.",
                minlength: "Debe contener 10 dígitos."
            },
            "comentario": {
                maxlength: "Debe contener máximo de 100."
            }
        },
        submitHandler : function() {
            var name = $('#name').val();
            var phone = $('#phone').val();
            var coments = $('#coments').val();
            var search = $('#word-search').val();
            var parameters = [];
            parameters['url'] = ruta+"products/searchFailed";
            parameters['type'] = "POST";
            parameters['dataType'] = "json";
            parameters['data'] = {
                name: name,
                phone: phone,
                search: search,
                coments: coments
            };
            parameters['success'] = function (result) {
                // console.log(result);
                if (result.resultado === true) {
                    $('#container-form').removeClass('d-flex').addClass('d-none');
                    $('#container-form-sent').removeClass('d-none').addClass('d-flex');
                }
            };
            ajaxCall(parameters);
        }
    });

});

function reloadProducts() {
    var search = window.location.href.split('/');
    search = search[search.length - 2] === 'busqueda' || search[search.length - 1] === 'ofertas';
    var parameters = [];
    if(!search){
        parameters['url'] = ruta+"products/getProductsFiltered";
        parameters['data'] = {'order':order, 'filters':filters, 'level1': $('#level1').val(), 'level2': $('#level2').val() };
    }else{
        parameters['url'] = ruta+"products/getProductsOrdered";
        parameters['data'] = {'order':order, 'word': $('#word-search').val() };
    }
    parameters['dataType'] = "json";
    parameters['type'] = "get";
    parameters['success'] = function (response) {
        if(!search){
            $('#cards-sections').html('');
        }else{
            $('#cards-sections-search').html('');
        }
        $.each(response, function (i,e) {
            var discount = "";
            if(e.hasOwnProperty('discount')){
                 // discount = '<div class="ribbon ribbon-top-right" style="display: block"><span>Oferta</span></div>';
                discount=  '<img src="'+ruta+'assets/images/ofertas/oferta-0.png" title="Pestaña-Oferta" alt="Pestaña-Oferta" style="width: 80px;position: absolute;top: 0;left: 0;">';
            }
            var dNone = "";
            if(i>7){
                dNone = "d-none";
            }
            var title = e.productType.replace(" ", "-")+'-'+e.brand.replace(" ", "-")+'-'+e.mpn;
            var item = '<div class="card shadow-sm product-item col-sm-6 col-md-4 col-lg-3 p-0 mt-2 '+dNone+'" style="border-radius: 5px;overflow: hidden;">' +
                '                                <a href="'+ruta+'catalogo/'+e.brand.toLowerCase().replace(" ", "-")+'/'+e.productType.toLowerCase()+'-'+e.brand.toLowerCase().replace(" ", "-")+'-'+e.mpn.toLowerCase()+'">' +
                '                                    ' + discount +
                '                                    <div class="product-image" style="height: 205px">' +
                '                                        <img style="max-width: 80%; max-height: 100%;"' +
                '                                             src="'+ruta+e.images[0].medium+'"' +
                '                                             title="'+title+'" alt="'+e.name+'">' +
                '                                    </div>';
            if (e.newPriceFloat > 3000) {
                item += '                                    <img class="free-delivery-prods" src="'+ruta+'assets/images/otros/gratis.png"' +
                '                                         title="Envío-gratis-Jardepot" alt="Envío gratis Jardepot">';
            }
            item += '                                </a>' +
                '                                <div class="d-flex align-items-center flex-column" style="height: 277px;">' +
                '                                    <p class="text-muted text-center"' +
                '                                       style="font-weight: 500; font-size: 18px;">'+e.name+'</p>';
            if (e.stock){
                item += '                                    <p class="old-price" style="height: 21px;">' +
                    '                                        ' +(e.hasOwnProperty('oldPrice')?e.oldPrice:"")+
                    '                                    </p>' +
                    '                                    <p class="new-price">'+e.newPrice+'</p>' +
                    '                                    <p class="little-letters">Precio aplica en pagos mediante depósito o transferencia bancaria.</p>' +
                    '                                    <button class="btn btn-buy d-flex justify-content-center align-items-center"' +
                    '                                       onclick="buyProduct(\''+ e.productType +'\',\''+e.brand+'\',\''+e.mpn+'\')">' +
                    '                                        <i class="material-icons" style="font-size: 16px;">shopping_cart</i> Comprar' +
                    '                                    </button>' +
                    '' +
                    '                                    <p class="envio-volada d-flex justify-content-center align-items-center my-2"' +
                    '                                       style="height: 24px; max-height: 24px;">' +
                    '                                        '+ (e.inventory > 0?'<i class="material-icons" style="font-size: 16px;">flash_on</i>Envio de volada': '') +
                    '                                    </p>' +
                    '                                    <p class="little-letters">*Envio gratis a partir de $3,000 de compra</p>' +
                    '                                    <p class="little-letters">*Consulte condiciones.</p>' +
                    '                                    <p class="product-description p-2 text-center text-truncate" data-toggle="tooltip"' +
                    '                                       data-placement="bottom"' +
                    '                                       style="min-height: 74px; max-height: 74px; white-space: normal;"' +
                    '                                       title="'+e.description+'">' +
                    '                                        '+e.description +
                    '                                    </p>';

            }else{
                item += '<p class="little-letters">*Envio gratis a partir de $3,000 de compra</p>' +
                    '       <p class="little-letters">*Consulte condiciones.</p>' +
                    '       <p class="product-description p-2 text-center text-truncate" data-toggle="tooltip"' +
                    '           data-placement="bottom"' +
                    '           style="min-height: 74px; max-height: 74px; white-space: normal;"' +
                    '           title="'+e.description+'">' +
                    '               '+e.description.substring(0,70)+
                    '       </p>' +
                    '       <p class="text-center mt-3" style="color: rgba(0,0,0,.54)!important; font-weight: 900; font-size: 15px; ">Consulta precio y existencia Llámanos al teléfono</p>' +
                    '       <p style="font-weight: 900; font-size: 18px; color: #de1f21;">800 212 9225</p>';
            }

            item += '                            </div>' +
                '                                <hr>' +
                '                                <div class="d-flex align-items-center flex-column">' +

                '                                   <div style="height: 36px">';
            if (e.stock) {
                item += '                                <button type="button" onclick="verifyAddCartProduct(\'' + e.productType + '\',\'' + e.brand + '\',\'' + e.mpn + '\',' + 1 + ')"' +
                    '                                            class="btn-add-cart d-flex justify-content-center align-items-center"' +
                    '                                            style="font-size: 14px;">' +
                    '                                        <i class="material-icons fn-color-jd">shopping_cart</i>' +
                    '                                        <span class="text-muted" style="font-size: 14px; font-weight: 500;">Agregar al carrito</span>' +
                    '                                    </button>';
            }

            item += '                               </div>'+
                '                                    <p class="little-letters text-center">*Sujeto a existencias.</p>' +
                '                                    <p class="little-letters text-center">*Precios sujetos a cambio sin previo' +
                '                                        aviso.</p>' +
                '                                </div>' +
                '                            </div>';

            if(!search){
                $('#cards-sections').append(item);
            }else{
                $('#cards-sections-search').append(item);
            }

        });
        $('.page-item').removeClass('active');
        $('.page-link[data-val="1"]').parent('.page-item').addClass('active');
        $('#eight-products').click();
    };
    ajaxCall(parameters);
}
