$(document).ready(function() {  // <-- ensure form's HTML is ready

    // $('#div-formulario').show();
    // $('#div-send').hide();

    $("#formTracking").submit(function(e) {
        e.preventDefault();
    }).validate({
        rules: {

            "email": {
                required: true,
                email: true
            },
            "telefono": {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            "pedido": {
                required: true,
                digits: true,
            }
        },
        messages: {

            "telefono": {
                required: "Introduce tu teléfono.",
                digits: "Introduce un número válido.",
                maxlength: "Debe contener 10 dígitos.",
                minlength: "Debe contener 10 dígitos."
            },
            "pedido": {
                required: "Introduce tu número de pedido.",
                digits: "Introduce un número válido.",
            },
            "email":{
                required: "Introduce tu correo.",
                email: "Introduce un correo válido."
            }
        },
        submitHandler : function() {
            var formdata = $("#formTracking").serializeArray();
            var data = {};
            $(formdata).each(function(index, obj){
                data[obj.name] = obj.value;
            });
            var parameters = [];
            parameters['url'] = "tracking/getGuia";
            parameters['type'] = "POST";
            parameters['dataType'] = "json";
            parameters['data'] =  {
                'form': JSON.stringify(data)
            };
            parameters['success'] = function (result) {
                if (result.status === 'success') {
                    $('#prueba').html('');
                    $.each(result.data,function (index,value){
                        url=document.location.origin+'/jardepotAPI/public';
                        switch(value.nombre){
                            case ('ODM Express'):
                                $('#prueba').append(
                                    ' <div class="p-2">                               ' +
                                    '   <img src="'+url+'/assets/images/otros/tracking/logo_odm.png" style="width: 150px" title="paquetería envío" alt="paquetería envío">' +
                                    '   <p class="mt-3" style="font-size: 18px">Guía: <strong>'+value.guia+'</strong></p>' +
                                    '   <a class="btn btn-primary" target="_blank" href="https://odmexpress.com.mx/rastreo-2/?rastreo_fall='+value.guia+'"> Ir a la página </a>' +
                                    '</div>');
                                break;
                            case ('Fedex'):
                                $('#prueba').append(
                                    ' <div class="p-2">                               ' +
                                    '   <img src="'+url+'/assets/images/otros/tracking/logo_fedex.png" style="width: 150px" title="paquetería envío" alt="paquetería envío">' +
                                    '   <p class="mt-3" style="font-size: 18px">Guía: <strong>'+value.guia+'</strong></p>' +
                                    '   <a class="btn btn-primary" target="_blank" href="https://odmexpress.com.mx/rastreo-2/?rastreo_fall='+value.guia+'"> Ir a la página </a>' +
                                    '</div>');
                                break;
                            case('Paquete Express'):
                                $('#prueba').append(
                                    ' <div class="p-2">                               ' +
                                    '   <img src="'+url+'/assets/images/otros/tracking/logo_paquete_express.png" style="width: 150px" title="paquetería envío" alt="paquetería envío">' +
                                    '   <p class="mt-3" style="font-size: 18px">Guía: <strong>'+value.guia+'</strong></p>' +
                                    '   <a class="btn btn-primary" target="_blank" href="https://www.paquetexpress.com.mx/rastreo-de-envios"> Ir a la página </a>' +
                                    '</div>');
                                break;
                            case('Estafeta'):
                                $('#prueba').append(
                                    ' <div class="p-2">                               ' +
                                    '   <img src="'+url+'/assets/images/otros/tracking/logo_estafeta.png" style="width: 150px" title="paquetería envío" alt="paquetería envío">' +
                                    '   <p class="mt-3" style="font-size: 18px">Guía: <strong>'+value.guia+'</strong></p>' +
                                    '   <a class="btn btn-primary" target="_blank" href="https://www.estafeta.com/Herramientas/Rastreo"> Ir a la página </a>' +
                                    '</div>');

                                break;
                            default:

                                break;
                        }
                    })

                    console.log(result)
                    // clearFormComentario();
                    // openSnackbar('success','Gracias por compartir con nosotros, en breve nos comunicamos contigo.')
                    // $('#div-formulario').hide();
                    // $('#div-send').show();
                }else{
                    $('#prueba').html(
                        '<div class="p-2" style="height: 215px">'+
                        '<p class="mt-3" style="font-size: 20px">Atención:<br> <strong>La información ingresada es incorrecta o no ha sido encontrada </strong></p>'+
                        '</div>');
                    //openSnackbar('warning','Ocurrió un error al enviar.')
                    // $('#div-formulario').show();
                    // $('#div-send').hide();
                }
            };
            ajaxCall(parameters);
        }
    });
});
