$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
const ruta = '/jardepotAPI/public/';
// const ruta = '/';

$(document).ready(function (){
    $('[data-toggle="tooltip"]').tooltip();
    getCartProducts();
});

function verifyCookie(){
    if(Cookies.get('session') === undefined || Cookies.get('session') === ''){
        $.ajax({
            url: ruta+"api/session",
            type: "GET",
            dataType: "json",
            success: function (result) {
                Cookies.set('session', result, { expires: 7 })
            },
            error: function (err) {
                console.log(err);
            }
        });
    }
}

$('#search-form').on('keypress',function(e) {
    if(e.which == 13) {
        $('#search-form').submit();
    }
});

$('#search-form').submit(function (e) {
    e.preventDefault();
    var search = $('#inputSearch').val();
    window.location = ruta+"busqueda/"+search;
})

var bussy = false;

function ajaxCall(parameters){
    if(! bussy){
        $('#overlay-bussy').addClass('active');
        parameters["data"]._token = $('meta[name="csrf-token"]').attr('content');
        bussy = true;
        parameters["dataType"] = (typeof parameters["dataType"] == "undefined" || parameters["dataType"] == null)?"text":parameters["dataType"];
        $.ajax({
            url: parameters["url"],
            type: parameters["type"],
            dataType: parameters["dataType"],
            data: parameters["data"],
            success: parameters["success"],
            error: function (err) {
                $('#overlay-bussy').removeClass('active');
                console.log(err);
                alert("Ocurrio un error "+parameters["url"], "Error");
            },
            complete: function(){
                $('#overlay-bussy').removeClass('active');
                if(!typeof parameters["complete"] === "undefined" && !parameters["complete"] == null){
                    parameters["complete"]();
                }
                bussy = false;
            }
        });
    }else{
        setTimeout(function(){
            ajaxCall(parameters);
        }, 500);
    }

}

function releaseAjaxQueue(){
    bussy = false;
}

function blockAjaxQueue(){
    bussy = true;
}

function executeAfterAjaxRelease(functionToExecute){
    if(! bussy){
        functionToExecute();
    }else{
        setTimeout(function(){
            executeAfterAjaxRelease(functionToExecute);
        }, 500);
    }
}

function getCookie(name) {
    let documento = (typeof document !== "undefined") ? document : null;
    if(documento){
        let ca = documento.cookie.split(';');
        let caLen = ca.length;
        let cookieName = `${name}=`;
        let c;

        for (let i = 0; i < caLen; i += 1) {
            c = ca[i].replace(/^\s+/g, '');
            if (c.indexOf(cookieName) == 0) {
                return c.substring(cookieName.length, c.length);
            }
        }
        return '';
    }
    return '';
}

function deleteCookie(name) {
    this.setCookie(name, '', -1);
}

function setCookie(name, value, expireDays, path = '') {
    let documento = (typeof document !== "undefined") ? document : null;
    if(documento){
        let d = new Date();
        d.setTime(d.getTime() + expireDays * 24 * 60 * 60 * 1000);
        let expires = `expires=${d.toUTCString()}`;
        let cpath = path ? `; path=${path}` : '';
        documento.cookie = `${name}=${value}; ${expires}${cpath}`;
    }

}

function verifyAddCartProduct(productType,brand,mpn,quantity){
    if(Cookies.get('session') === undefined || Cookies.get('session') === ''){
        $.ajax({
            url: ruta+"api/session",
            type: "GET",
            dataType: "json",
            success: function (result) {
                Cookies.set('session', result, { expires: 7 })
                // setTimeout(function(){
                    addCartProduct(productType,brand,mpn,quantity)
                // }, 500);
            },
            error: function (err) {
                console.log(err);
            }
        });
    }else{
        addCartProduct(productType,brand,mpn,quantity)
    }
}

function addCartProduct(productType,brand,mpn,quantity){
    var product = {'productType':productType,'brand':brand,'mpn':mpn};
    $('#overlay-bussy').addClass('active');
    $.ajax({
        url: ruta+"api/cart/addProduct",
        type: "POST",
        dataType: "json",
        data:{
            'product': JSON.stringify(product),
            'quantity':quantity,
            'sessionCookie': Cookies.get('session')
        },
        success: function (result) {
            if(result.data === 'successful'){
                getCartProducts();
                openSnackbar('success','Agregaste '+quantity+' '+productType+' '+brand+' '+mpn);
            }
        },
        error: function (err) {
            $('#overlay-bussy').removeClass('active');
            console.log(err);
            alert("Ocurrio un error "+parameters["url"], "Error");
        }
    });
}

function decreaseCartProduct(productType,brand,mpn,quantity){
    var product = {'productType':productType,'brand':brand,'mpn':mpn};
    verifyCookie();
    var parameters = [];
    parameters['url'] = ruta+"api/cart/addProduct";
    parameters['type'] = "POST";
    parameters['dataType'] = "json";
    parameters['data'] = {
        'product': JSON.stringify(product),
        'quantity':quantity,
        'sessionCookie': Cookies.get('session')
    };
    parameters['success'] = function (result) {
        if(result.data === 'successful'){
            getCartProducts();
            quantity = quantity * -1;
            openSnackbar('danger','Quitaste '+quantity+' '+productType+' '+brand+' '+mpn);
        }
    };
    ajaxCall(parameters);
}

function removeCartProduct(product){
    if(Cookies.get('session') !== undefined && Cookies.get('session') !== '' ) {
        $('#overlay-bussy').addClass('active');
        $.ajax({
            url: ruta + "api/cart/removeProduct",
            type: "DELETE",
            dataType: "json",
            data:{
                'product': product,
                'sessionCookie': Cookies.get('session')
            },
            success: function (result) {
                if (result.data === 'successful') {
                    getCartProducts();
                    openSnackbar('danger', 'Eliminaste ' + product);
                }
                $('#overlay-bussy').removeClass('active');
            },
            error: function (err) {
                $('#overlay-bussy').removeClass('active');
            }
        });
    }
}

function getCartProducts(){
    $('#option-dropdown-cart1').hide();
    $('#option-dropdown-cart2').hide();
    if(Cookies.get('session') !== undefined && Cookies.get('session') !== '' ) {
        $.ajax({
            url: ruta+"api/cart/products",
            type: "GET",
            dataType: "json",
            data:{'sessionCookie': Cookies.get('session')},
            success: function (result) {
                var resultJson = JSON.parse(result);
                makeDropdownCart(resultJson.cart, resultJson.total,resultJson.quantityProducts);
                $('#overlay-bussy').removeClass('active');
            },
            error: function (err) {
                $('#overlay-bussy').removeClass('active');
            }
        });
    }else{
        $('#option-dropdown-cart1').hide();
        $('#option-dropdown-cart2').hide();
        $('#items-count-nav1').html('0');
        $('#products-coun-nav1').html('0 Productos');
        $('#items-count-nav2').html('0');
        $('#products-coun-nav2').html('0 Productos');
        var divs =
            '<div class="dropdown-item">' +
            '   <div class="text-muted mt-1">' +
            '       <span style="white-space: pre-line"><b>No tienes ningún producto en tu carrito.</b></span>' +
            '   </div>' +
            '</div>' ;
        $('#items-card-nav1').html(divs);
        $('#items-card-nav2').html(divs);

        $('#overlay-bussy').removeClass('active');
    }
}

function makeDropdownCart(products,total,quantityProducts){
    if (quantityProducts > 0) {
        $('#option-dropdown-cart1').show();
        $('#option-dropdown-cart2').show();
        $('#items-count-nav1').html(quantityProducts);
        $('#products-coun-nav1').html(quantityProducts + ' Productos');
        $('#items-count-nav2').html(quantityProducts);
        $('#products-coun-nav2').html(quantityProducts + ' Productos');
        var divs = '';
        $.each(products, function (key, value) {
            divs += ' <div class="dropdown-item">' +
                '     <div class="row">' +
                '         <div class="col-10">' +
                '              <p class="text-muted mat-line" data-toggle="tooltip" title="' + value.name + '">' + value.name + '</p>' +
                '              <p class="text-muted mat-line">' + value.cartCount + ' x ' + formatterDolar.format(value.newPrice) + '</p>' +
                '         </div>' +
                '         <div class="col-2">' +
                '             <button class="btn" type="button" data-toggle="tooltip"  title="Eliminar"' +
                '                   onclick="removeCartProduct(\'' + value.name + '\')"><i class="material-icons">close</i></button>' +
                '         </div>' +
                '     </div>' +
                '  </div>';
        });
        divs += '   <div class="dropdown-divider"></div>' +
            '<div class="dropdown-item">' +
            '   <div class="text-muted mt-1"><b>TOTAL: '+formatterDolar.format(total)+'</b></div>' +
            '</div>' +
            '<div class="dropdown-divider"></div>';
        $('#items-card-nav1').html(divs);
        $('#items-card-nav2').html(divs);
    } else {
        $('#option-dropdown-cart1').hide();
        $('#option-dropdown-cart2').hide();
        $('#items-count-nav1').html('0');
        $('#products-coun-nav1').html('0 Productos');
        $('#items-count-nav2').html('0');
        $('#products-coun-nav2').html('0 Productos');
        var divs =
            '<div class="dropdown-item">' +
            '   <div class="text-muted mt-1">' +
            '       <span style="white-space: pre-line"><b>No tienes ningún producto en tu carrito.</b></span>' +
            '   </div>' +
            '</div>' ;
        $('#items-card-nav1').html(divs);
        $('#items-card-nav2').html(divs);
    }
}

const formatterDolar = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD'
})

function openSnackbar(status,message) {
    var color;
    switch (status) {
        case 'success':
            color = '#218838';
            break;
        case 'warning':
            color='#f68600';
            break;
        case 'danger':
            color='#dc3545';
            break;
        case 'info':
            color='#17a2b8';
            break;
        case 'primary':
            color='#0069d9';
            break;
        default:
            color='#333';
    }
    var x = document.getElementById("snackbar");
    $("#snackbar").css("background-color",color)
    $('#snackbar').html('<p>'+message+'</p>')
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

function removeAllProducts(){
    if(Cookies.get('session') !== undefined && Cookies.get('session') !== '' ||  Cookies.get('session') !== 'undefined' ) {
        $.ajax({
            url: ruta + "api/cart/removeAllProducts",
            type: "DELETE",
            dataType: "json",
            data: {'sessionCookie': Cookies.get('session')},
            success: function (result) {
                if (result.data === 'successful') {
                    getCartProducts();
                    openSnackbar('success', 'Se limpió el carrito');
                }
                $('#overlay-bussy').removeClass('active');
            },
            error: function (err) {
                $('#overlay-bussy').removeClass('active');
            }
        });
    }
}
