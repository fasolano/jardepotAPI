var dataFactura = {};
var dataEnvio = {};
var dataCliente = {};
var costoEnvio = 300;
var envioGratis = 3000;
var needBilling = false;
var total;

$(document).ready(function () {
    $('#div-factura').hide();

    $('#costo-entrega').html(formatterDolar.format(costoEnvio));
    $('#minima-compra').html(formatterDolar.format(envioGratis));
     createFormCliente();
     createFormEnvio();

     $('.no-passed').click(function (e) {
         if($(this).hasClass('no-passed')){
             e.stopPropagation();
         }
     });

});

function checkFactura(){
    if( $('#facturar').is(':checked') ) {
        createFormFactura();
        needBilling = true;
        $('#div-factura').show();

        $('#btn-pay-form').show();
        $('#btn-pay-div').hide();
    }else{
        $('#div-factura').hide();

        $('#btn-pay-form').hide();
        $('#btn-pay-div').show();
        needBilling = false;

    }
}

function createFormCliente(){

    $("#form-create-cliente").submit(function (e) {
        e.preventDefault();
    }).validate({
        rules: {
            "firstName": {
                required: true,
                minlength: 3,
                maxlength: 60
            },
            "lastName": {
                required: true,
                minlength: 3,
                maxlength: 60
            },
            "email": {
                required: true,
                email: true
            },
            "phone": {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            "state": {
                required: true,
                minlength: 5,
                maxlength: 50
            },
            "city": {
                required: true,
                minlength: 5,
                maxlength: 50
            },
            "zip": {
                required: true,
                digits: true,
                minlength: 5,
                maxlength: 5
            },
            "suburb": {
                required: true,
                minlength: 5,
                maxlength: 50
            },
            "address": {
                required: true,
                minlength: 5,
                maxlength: 100
            },
        },
        messages: {
            "firstName": {
                required: "Introduce tu nombre.",
                maxlength: "Debe contener máximo 60 letras.",
                minlength: "Debe contener mínimo 3 letras."
            },
            "lastName": {
                required: "Introduce tus apellidos.",
                maxlength: "Debe contener máximo 60 letras.",
                minlength: "Debe contener mínimo 3 letras."
            },
            "email": {
                required: "Introduce tu correo.",
                email: "Introduce un correo válido."
            },
            "phone": {
                required: "Introduce tu teléfono.",
                digits: "Introduce un número válido.",
                maxlength: "Debe contener 10 dígitos.",
                minlength: "Debe contener 10 dígitos."
            },
            "state": {
                required: "Introduce tu estado.",
                maxlength: "Debe contener máximo 50 letras.",
                minlength: "Debe contener mínimo 5 letras."
            },
            "city": {
                required: "Introduce tu municipio.",
                maxlength: "Debe contener máximo 50.",
                minlength: "Debe contener mínimo 5 letras."
            },
            "zip": {
                required: "Introduce tu código postal.",
                digits: "Introduce un número válido.",
                maxlength: "Debe contener 5 dígitos.",
                minlength: "Debe contener 5 dígitos."
            },
            "suburb": {
                required: "Introduce tu colonia.",
                maxlength: "Debe contener máximo de 100 letras.",
                minlength: "Debe contener un mínimo de 5 letras."
            },
            "address": {
                required: "Introduce tu dirección.",
                maxlength: "Debe contener máximo de 100 letras.",
                minlength: "Debe contener un mínimo de 5 letras."
            }
        },
        submitHandler: function () {

            var formCliente = $("#form-create-cliente").serializeArray();

            $(formCliente).each(function (index, obj) {
                dataCliente[obj.name] = obj.value;
            });
            validTadEnvio();
        }
    });
}

function createFormEnvio() {
    $("#form-create-envio").submit(function (e) {
        e.preventDefault();
    }).validate({
        rules: {
            "delivery": {  // <-- this is the name attribute, NOT id
                required: true,
            },
        },
        messages: {
            "delivery": {
                required: "Debes seleccionar un método de entrega.",
            },
        },
        submitHandler: function () {
            var formEnvio = $("#form-create-envio").serializeArray();

            $(formEnvio).each(function (index, obj) {
                dataEnvio[obj.name] = obj.value;
            });

            if ($("#form-create-cliente").valid() && $("#form-create-envio").valid()){
                tabOrden();
                datosVistaPrevia();
            }

        }
    });
}

function createFormFactura(){
    $("#form-create-factura").submit(function (e) {
        e.preventDefault();
    }).validate({
        rules: {
            "tipoPersona": {
                required: true,
            },
            "usoCFDI": {
                required: true,
            },
            "formaPago": {
                required: true,
            },
            "razonSocial": {
                required: true,
                minlength: 5,
                maxlength: 50
            },
            "rfc": {
                required: true,
                minlength: 13,
                maxlength: 13
            },
            "correoFac": {
                required: true,
                email: true
            },
            "estadoFac": {
                required: true,
                minlength: 5,
                maxlength: 50
            },
            "municipioFac": {
                required: true,
                minlength: 5,
                maxlength: 50
            },
            "cpFac": {
                required: true,
                digits: true,
                minlength: 5,
                maxlength: 5
            },
            "direccionFac": {
                required: true,
                minlength: 5,
                maxlength: 100
            },
        },
        messages: {
            "tipoPersona": {
                required: "Selecciona el tipo de persona.",
            },
            "usoCFDI": {
                required: "Selecciona el uso de CFDI.",
            },
            "formaPago": {
                required: "Selecciona tu forma de pago.",
            },
            "razonSocial": {
                required: "Introduce tu razón social.",
                maxlength: "Debe contener máximo 50 letras.",
                minlength: "Debe contener mínimo 5 letras."
            },
            "rfc": {
                required: "Introduce tu RFC.",
                maxlength: "Debe contener máximo 13 letras.",
                minlength: "Debe contener mínimo 13 letras."
            },
            "correoFac": {
                required: "Introduce tu correo.",
                email: "Introduce un correo válido."
            },
            "estadoFac": {
                required: "Introduce tu estado.",
                maxlength: "Debe contener máximo 50 letras.",
                minlength: "Debe contener mínimo 5 letras."
            },
            "municipioFac": {
                required: "Introduce tu municipio.",
                maxlength: "Debe contener máximo 50 letras.",
                minlength: "Debe contener mínimo 5 letras."
            },
            "cpFac": {
                required: "Introduce tu código postal.",
                digits: "Introduce un número válido.",
                maxlength: "Debe contener 5 dígitos.",
                minlength: "Debe contener 5 dígitos."
            },
            "direccionFac": {
                required: "Introduce tu dirección.",
                maxlength: "Debe contener máximo de 100 letras.",
                minlength: "Debe contener un mínimo de 5 letras."
            }
        },
        submitHandler: function () {
            var formOrden = $("#form-create-factura").serializeArray();
            var dataConver={};
            $(formOrden).each(function (index, obj) {
                dataConver[obj.name] = obj.value;
            });
            dataFactura = {
                socialReason: dataConver.razonSocial,
                typePerson: dataConver.tipoPersona,
                rfc: dataConver.rfc,
                address: dataConver.direccionFac,
                city: dataConver.municipioFac,
                state: dataConver.estadoFac,
                email: dataConver.correoFac,
                zip: dataConver.cpFac,
                usoCFDI: dataConver.usoCFDI
            };
            createOrder();
        }
    });
}

function datosVistaPrevia(){
    var resultJson;
    $.ajax({
        url: ruta+"api/cart/products",
        type: "GET",
        dataType: "json",
        data:{'sessionCookie': Cookies.get('session')},
        success: function (result) {
            resultJson  = JSON.parse(result);
            var tr='';
            $.each(resultJson.cart, function (key, value) {
                console.log(value);
                tr +=
                    '<tr>'+
                    '    <td scope="row">'+
                    '    <img style="width: 60px;height: 60px;" alt="'+value.name+'" src="'+ value.images[0].small +'">'+
                    '    </td>'+
                    '    <td>'+value.name+'</td>'+
                    '    <td class="text-center">'+formatterDolar.format(value.newPrice)+'</td>'+
                    '    <td class="text-center"><span>'+value.cartCount+'</span></td>'+
                    '    <td>'+formatterDolar.format(value.newPrice * value.cartCount)+'</td>'+
                    '</tr>';
            });

            total=parseFloat(resultJson.total);
            var mensajeEnvio='';
            if(dataEnvio.delivery === 'domicilio' ){
                mensajeEnvio+='<p >Envio a domicilio <span class="text-muted">'+formatterDolar.format(costoEnvio)+' MXN / Entrega de 2 a 6 días hábiles *Compras mayores a $3,000.00 gratis y en área de cobertura</span> </p>';

                if (total > envioGratis){
                    costoEnvio = 0;
                }
                total = total + costoEnvio;
                tr +=
                    '<tr>'+
                    '    <td scope="row">'+
                    '    <img style="width: 60px;height: 60px;" alt="Paqueteria" src="assets/images/productos/--.png">'+
                    '    </td>'+
                    '    <td>Manejo de Mercancía Envío paquetería</td>'+
                    '    <td class="text-center">'+formatterDolar.format(costoEnvio)+'</td>'+
                    '    <td class="text-center"><span>1</span></td>'+
                    '    <td>'+formatterDolar.format(costoEnvio)+'</td>'+
                    '</tr>';
            }else{
                mensajeEnvio +='<p style="font-size: 14px">Entrega en sucursal Cuernavaca <span class="text-muted"> GRATIS / Entrega de 1 a 2 días hábiles *En algunos casos la entrega puede extenderse hasta 7 días hábiles en cuyo caso se lo haremos saber de inmediato.</span></p>';
            }
            $('#body-tr').html(tr);
            $('#metodoEnvio').html(mensajeEnvio);
            $('#totalCheck').html(formatterDolar.format(total));
            $('#nombreCheck').html(dataCliente.firstName+' '+dataCliente.lastName);
            $('#correoCheck').html(dataCliente.email);
            $('#telefonoCheck').html(dataCliente.phone);
            $('#estadoCheck').html(dataCliente.state);
            $('#ciudadCheck').html(dataCliente.city);
            $('#cpCheck').html(dataCliente.zip);
            $('#coloniaCheck').html(dataCliente.suburb);
            $('#direccionCheck').html(dataCliente.address);
        },
        error: function (err) {
        }
    });
}

function createOrder(){
    $('#overlay-bussy').addClass('active');
    var json = {
        'payment': JSON.stringify({ value:'Transferencia' }),
        'billing' : JSON.stringify(dataCliente),
        'billMandatory': JSON.stringify(dataFactura),
        'needBilling': JSON.stringify(needBilling),
        'delivery': JSON.stringify({ deliveryMethod : { value:dataEnvio.delivery, min: envioGratis, cost:costoEnvio}}),
    }
    $.ajax({
        url: ruta + "api/checkout/createOrder",
        type: "POST",
        dataType: "json",
        data:{
            'forms': JSON.stringify(json),
            'sessionCookie': Cookies.get('session')
        },
        success: function (result) {
            if(result.data === 'success'){
                Cookies.remove('session');
                $('#totalConfirm').html(formatterDolar.format(total))
                tabConfirmation();
                getCartProducts();
            }
            $('#overlay-bussy').removeClass('active');
        },
        error: function (err) {
            $('#overlay-bussy').removeClass('active');
        }
    });
}


function tabCliente(){
    $('#nav-envio-tab').addClass('no-passed');
    $('#nav-client-tab').click();
}

function tabEnvio(){
    if($('#nav-envio-tab').hasClass('no-passed')){
        $('#nav-envio-tab').removeClass('no-passed').click();
    }else{
        $('#nav-orden-tab').addClass('no-passed');
        $('#nav-envio-tab').click();
    }
}
function validTadEnvio(){
    if($("#form-create-cliente").valid()){
        tabEnvio();
    }else{
        openSnackbar('warning','Te falta validar un campo en Datos de envio')
    }
}

function tabOrden(){
    $('#nav-orden-tab').removeClass('no-passed').click();
}

function tabConfirmation(){
    $('#nav-confirmation-tab').removeClass('no-passed').click();
}
