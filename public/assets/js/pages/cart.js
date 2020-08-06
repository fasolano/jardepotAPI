$(document).ready(function (){
    getCartProductsView();

    $(document).on('click','.remove-product', function () {
        var current = $(this).parent('.product-controls').find('.cart-count').text();
        var price = $(this).parents('tr').find('.price-product').val();
        current = current - 1;
        var total = current * price;
        $(this).parent('.product-controls').find('.cart-count').text(current);
        $(this).parents('tr').find('.total-row').text(formatterDolar.format(total));
    });

    $(document).on('click','.add-product', function () {
        var current = $(this).parent('.product-controls').find('.cart-count').text();
        var price = $(this).parents('tr').find('.price-product').val();
        current = (current * 1) + 1;
        var total = current * price;
        $(this).parent('.product-controls').find('.cart-count').text(current);
        $(this).parents('tr').find('.total-row').text(formatterDolar.format(total));
        $(this).parents('tr').find('.total-row-input').val(total);
    });
});

function calculateTotal() {
    var total = 0;
    $('.total-row-input').each(function () {
        total += $(this).val();
    });
}

function getCartProductsView(){
    var session = Cookies.get('session');
    if(session !== undefined && session !==''){
        var parameters = [];
        parameters['url'] = "api/cart/products";
        parameters['type'] = "get";
        parameters['dataType'] = "json";
        parameters['data'] = {
            sessionCookie: session
        };
        parameters['success'] = function (response) {
            response = JSON.parse(response);

            $.each(response.cart, function (i, e) {
                var item = '<tr>' +
                    '<td><img style="width: 80px;height: 80px;"' +
                    '                     src="'+e.images[0].medium+'">' +
                    '</td>' +
                    '<td data-title="Nombre"><a style="font-weight: 500;color: #000000" ' +
                    'href="catalogo/'+e.brand.toLowerCase()+'/'+e.productType.toLowerCase()+'-'+e.brand.toLowerCase()+'-'+e.mpn.toLowerCase()+'">'+e.name+'</a></td>' +
                    '<td data-title="Precio"> '+formatterDolar.format(e.newPrice)+' <input class="price-product" type="hidden" value="'+e.newPrice+'"></td>' +
                    '<td data-title="Cantidad">' +
                    '    <div class="product-controls">' +
                    '        <input type="hidden" class="inventory" value="'+e.inventory+'">' +
                    '        <button class="btn remove-product" ' +
                    'onclick="decreaseCartProduct(\''+e.productType+'\', \''+e.brand+'\', \''+e.mpn+'\', -1)"><i class="material-icons">remove</i></button>' +
                    '        <span class="cart-count">'+e.cartCount+'</span>' +
                    '        <button class="btn add-product" ' +
                    'onclick="addCartProduct(\''+e.productType+'\', \''+e.brand+'\', \''+e.mpn+'\', 1)"><i class="material-icons">add</i></button>' +
                    '    </div>' +
                    '</td>' +
                    '<td data-title="Total" class="total-row">'+formatterDolar.format((e.cartCount * e.newPrice))+' <input class="total-row-input" type="hidden" value="'+(e.cartCount * e.newPrice)+'"></td>' +
                    '<td data-title="          " class="text-center">' +
                    '    <button title="Borrar" class="btn btn-secondary btn-circle"' +
                    'onclick="removeCartProduct(\''+e.name+'\')">X</button>' +
                    '</td>' +
                    '</tr>';
                $('#table-body').append(item);
            });
        };
        ajaxCall(parameters);
    }
}
