// JavaScript Validación
$(document).ready(function() {  // <-- ensure form's HTML is ready

    $('#div-formulario').show();
    $('#div-send').hide();

    $("#formularioDudas").submit(function(e) {
        e.preventDefault();
    }).validate({
        rules: {
            "nombre": {  // <-- this is the name attribute, NOT id
                required: true,
                minlength: 3,
                maxlength: 60
            },
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
            "whatsapp": {
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            "comentario": {
                minlength: 3,
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
            "whatsapp": {
                digits: "Introduce un número válido.",
                maxlength: "Debe contener 10 dígitos.",
                minlength: "Debe contener 10 dígitos."
            },
            "email":{
                required: "Introduce tu correo.",
                email: "Introduce un correo válido."
            },
            "comentario": {
                maxlength: "Debe contener máximo de 100.",
                minlength: "Debe contener un mínimo de 3."
            }
        },
        submitHandler : function() {
            var formdata = $("#formularioDudas").serializeArray();
            var data = {};
            $(formdata).each(function(index, obj){
                data[obj.name] = obj.value;
            });
            console.log(data);
            $.ajax({
                url: '../../product/sendSearch',
                type: 'POST',
            //    contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                data: {
                    'textoBuscado': '',
                    'forms': JSON.stringify(data)
                },
                success: function (result) {
                    console.log(result);
                    if (result.resultado === true) {
                        $('#div-formulario').hide();
                        $('#div-send').show();
                    }
                    $("#formularioDudas").reset();
                }, error: function () {
                    console.log('error petición')
                    $('#div-formulario').show();
                    $('#div-send').hide();
                }
            });
        }
    });
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function changeImg(medium,big,name){
    $('#drift-trigger').replaceWith(' <img style="max-width: 100%" id="drift-trigger" src="'+medium+'" data-zoom="'+big+'"  title="'+name+'" alt="'+name+'">');
    new Drift(document.getElementById('drift-trigger'), {
        paneContainer: document.querySelector('.detail'),
        inlinePane: 900,
        inlineOffsetY: -85,
        containInline: true,
        hoverBoundingBox: true,
    });
}

