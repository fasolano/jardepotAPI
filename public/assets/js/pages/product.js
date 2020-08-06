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
            var parameters = [];
            parameters['url'] = "../../product/sendSearch";
            parameters['type'] = "POST";
            parameters['dataType'] = "json";
            parameters['data'] =  {
                'textoBuscado': '',
                'forms': JSON.stringify(data)
            };
            parameters['success'] = function (result) {
                if (result.resultado === true) {
                    $('#div-formulario').hide();
                    $('#div-send').show();
                }else{
                    $('#div-formulario').show();
                    $('#div-send').hide();
                }
            };
            ajaxCall(parameters);
        }
    });
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

function addNumProduct(){
    var cant = $('#cantidadProducto').val();
    $('#cantidadProducto').val( parseInt(cant)+1);
}
function resNumProduct(){
    var cant = $('#cantidadProducto').val();
    if(cant > 1){
        $('#cantidadProducto').val(parseInt(cant)-1);
    }
}
function agregarProductoCarrito(productType,brand,mpn){
    var cantidad = $('#cantidadProducto').val();
    if(cantidad >= 1){
        addCartProduct(productType,brand,mpn,cantidad);
    }
}
