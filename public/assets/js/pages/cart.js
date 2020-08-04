$(document).ready(function (){
    getCartProducts();
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
function addProduct(product,quantity){
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

function getCartProducts(){
    $.ajax({
        url:'cart/products/get',
        type:'GET',
        dataType:'json',
        success:function (result){
            console.log(result);
        },error:function (err){

        }
    });
}
