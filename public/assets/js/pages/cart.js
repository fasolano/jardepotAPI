$(document).ready(function (){
    getCartProductsView();
});

function addProductQuantity(product){
    quantity = $('#quantity').val();
    $.ajax({
        url:'cart/addProduct',
        type:'POST',
        data:{
            product:product,
            quantity:quantity
        },success:function (result){

        },error:function (err){

        }

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
                    '<td data-title="Precio"> '+formatterDolar.format(e.newPrice)+'</td>' +
                    '<td data-title="Cantidad">' +
                    '    <div class="product-controls">' +
                    '       <input type="hidden" class="inventory" value="'+e.inventory+'">' +
                    '        <button class="btn remove-product"><i class="material-icons">remove</i></button>' +
                    '        <span>'+e.cartCount+'</span>' +
                    '        <button class="btn add-product" ' +
                    'onclick="addCartProduct(\''+e.productType+'\', \''+e.brand+'\', \''+e.mpn+'\')"><i class="material-icons">add</i></button>' +
                    '    </div>' +
                    '</td>' +
                    '<td data-title="Total">'+formatterDolar.format((e.cartCount * e.newPrice))+'</td>' +
                    '<td data-title="          " class="text-center">' +
                    '    <button title="Borrar" class="btn btn-secondary btn-circle">X</button>' +
                    '</td>' +
                    '</tr>';
                $('#table-body').append(item);
            });
        };
        ajaxCall(parameters);
    }
}
