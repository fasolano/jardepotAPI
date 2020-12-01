$(document).ready(function() {  // <-- ensure form's HTML is ready

    // $('#div-formulario').show();
    // $('#div-send').hide();
     $('#data-seguimiento').hide();
     $('#seg-fedex').hide();

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
                    $('#track-information').html('');
                    $.each(result.data,function (index,value){
                        url=document.location.origin;
                        // url=document.location.origin+'/jardepotAPI/public';
                        switch(value.nombre){
                            case ('ODM Express'):
                                $('#track-information').append(
                                    ' <div class="p-2">                               ' +
                                    '   <img src="'+url+'/assets/images/otros/tracking/logo_odm.png" style="width: 150px" title="paquetería envío" alt="paquetería envío">' +
                                    '   <p class="mt-3" style="font-size: 18px">Guía: <strong>'+value.guia+'</strong></p>' +
                                    '   <a class="btn btn-primary" target="_blank" href="https://odmexpress.com.mx/rastreo-2/?rastreo_fall='+value.guia+'"> Ir a la página </a>' +
                                    '</div>');
                                break;
                            case ('Fedex'):
                                $('#track-information').append(
                                    ' <div class="p-2">                               ' +
                                    '   <img src="'+url+'/assets/images/otros/tracking/logo_fedex.png" style="width: 150px" title="paquetería envío" alt="paquetería envío">' +
                                    '   <p class="mt-3" style="font-size: 18px">Guía: <strong>'+value.guia+'</strong></p>' +
                                    '   <a class="btn btn-primary" target="_blank" href="https://www.fedex.com/es-mx/tracking.html"> Ir a la página </a>' +
                                    '</div>');
                                makeTable(value.table);
                                break;
                            case('Paquete Express'):
                                $('#track-information').append(
                                    ' <div class="p-2">                               ' +
                                    '   <img src="'+url+'/assets/images/otros/tracking/logo_paquete_express.png" style="width: 150px" title="paquetería envío" alt="paquetería envío">' +
                                    '   <p class="mt-3" style="font-size: 18px">Guía: <strong>'+value.guia+'</strong></p>' +
                                    '   <a class="btn btn-primary" target="_blank" href="https://www.paquetexpress.com.mx/rastreo-de-envios"> Ir a la página </a>' +
                                    '</div>');
                                break;
                            case('Estafeta'):
                                $('#track-information').append(
                                    ' <div class="p-2">                               ' +
                                    '   <img src="'+url+'/assets/images/otros/tracking/logo_estafeta.png" style="width: 150px" title="paquetería envío" alt="paquetería envío">' +
                                    '   <p class="mt-3" style="font-size: 18px">Guía: <strong>'+value.guia+'</strong></p>' +
                                    '   <a class="btn btn-primary" target="_blank" href="https://www.estafeta.com/Herramientas/Rastreo"> Ir a la página </a>' +
                                    '</div>');

                                break;
                            default:
                                $('#track-information').append(
                                    ' <div class="p-2" style="background-color: #3D3D3D;color: #fff;font-size: 20px;"><' +
                                    'img src="{{asset(\'img/logos/logoJardepot.png\')}}" style="width: 150px"><' +
                                    'p class="mt-3"> <strong>Ponte en contacto con nosotros para mayor información</strong></p>' +
                                    '<p><i class="material-icons">phone</i> 800 212 9225</p>' +
                                    '<p><i class="material-icons">phone</i> 55 5185 7805</p>' +
                                    '<h4 class="my-5">Horario de atención: 9am a 6pm</h4>' +
                                    '</div>');
                                break;
                        }
                    })

                    console.log(result)
                    // clearFormComentario();
                }else{
                    $('#track-information').html(
                        '<div class="p-2" style="height: 215px">'+
                        '<p class="mt-3" style="font-size: 20px">Atención:<br> <strong>La información ingresada es incorrecta o no ha sido encontrada </strong></p>'+
                        '</div>');
                }

            };
            ajaxCall(parameters);
        }
    });
});


function calltracking() {
    $.ajax({
        url:'prueba',
        type:'GET',
        datatype:'json',
        success: function (result) {
            makeTable(result);
        }
    });

}

function makeTable(result){
    res=JSON.parse(result);
    console.log(res);
    $('#seg-fedex').show();
    $('#data-seguimiento').show();
    if(res.Notification.Severity !=='ERROR') {
        var today1 = new Date(res.DatesOrTimes[0].DateOrTimestamp);
        var estimada = today1.getDate() + "-" + (today1.getMonth() + 1) + "-" + today1.getFullYear();

        $('#estimado').html('<span>' + estimada + '</span>');
        $('#status').html('<span>' + res.StatusDetail.Description + '</span>');
        $('#origen').html('<span>' + res.ShipperAddress.City + ' ' + res.ShipperAddress.CountryCode + '</span>');
        $('#destino').html('<span>' + res.DestinationAddress.City + ' ' + res.DestinationAddress.CountryCode + '</span>');
        $('#div-fedex').html('');

        var tl='<div class="table-responsive">'
        tl='<p class="title-ubication">'+res.TrackingNumber+'</p>'
        tl += '<table class="table">';
        $.each(res.Events, function (index, value) {
            var city = value.Address.City !== undefined ? value.Address.City : '';
            var code = value.Address.CountryCode !== undefined ? value.Address.CountryCode : '';

            var today = new Date(value.Timestamp);
            // console.log(today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate())
            var day = today.getDate() + "-" + (today.getMonth() + 1) + "-" + today.getFullYear();

            var h = today.getHours() < 10 ? '0' + today.getHours() : today.getHours();
            var m = today.getMinutes() < 10 ? '0' + today.getMinutes() : today.getMinutes();
            var s = today.getSeconds() < 10 ? '0' + today.getSeconds() : today.getSeconds();
            var hour = h + ':' + m + ':' + s;

            tl += ' <tr>' +
                '<td>' + day + '</td>' +
                '<td>' + hour + '</td>' +
                '<td>' + city + '</td>' +
                '<td>' + code + '</td>' +
                '<td>' + value.EventDescription + '</td>' +
                '</tr>';
        });
        tl += '<table></div>';
        $('#div-fedex').append(tl);
    }else{
        $('#data-seguimiento').hide();
        var tl='<div style="height: 180px">' +
                '   <p class="title-ubication">'+res.TrackingNumber+'</p>'+
                '   <p class="text-center text-danger" style="font-size: 24px;font-weight: 600">Ocurrió un error al realizar el seguimiento</p>' +
                '</div>';
        $('#div-fedex').append(tl);
    }
}


