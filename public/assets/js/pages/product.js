// JavaScript Validación
$(document).ready(function() {  // <-- ensure form's HTML is ready

    $('#div-formulario').show();
    $('#div-send').hide();

    $(document).on('submit', '.formularioDudas', async function(e) {
        e.preventDefault();
        const emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/
        const numberReg = /^[0-9]+$/
        const nombre = $.trim($(this).find("input[name='nombre']")[0].value)
        const email = $.trim($(this).find("input[name='email']")[0].value)
        const telefono = $.trim($(this).find("input[name='telefono']")[0].value)
        const whatsapp = $.trim($(this).find("input[name='whatsapp']")[0].value)
        const comentario = $.trim($(this).find("textarea[name='comentario']").val())
        const token = $(this).find("input[name='_token']")[0].value
        const producto = $(this).find("input[name='producto']")[0].value
        if(nombre.length == 0 || nombre.length < 3 || nombre.length > 60){
            openSnackbar('error','El campo Nombre no es correcto')
            return false
        }
        if(email.length == 0 || !emailReg.test(email)){
            openSnackbar('error','El campo Correo no es correcto')
            return false
        }
        if((telefono.length != 0 && telefono.length != 10) || !numberReg.test(telefono)){
            openSnackbar('error','El campo Telefono no es correcto y debe ser de 10 digitos')
            return false
        }
        if((whatsapp.length != 0 && whatsapp.length != 10) || !numberReg.test(whatsapp)){
            openSnackbar('error','El campo Whatsapp no es correcto y debe ser de 10 digitos')
            return false
        }
        if(comentario.length != 0 ){
            if(comentario.length < 3 || comentario.length > 60){
                openSnackbar('error','El campo Comentario no es correcto')
                return false
            }
        }
        const data = {
            forms:{
                nombre,
                email,
                telefono,
                whatsapp,
                comentario,
                producto
            },
            textoBuscado: ''
        }
        let request = await fetch("../../product/sendSearch", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        }).then((response) => {
            response.json().then((respuesta) => {
                if (respuesta.resultado === true) {
                    clearFormComentario();
                    openSnackbar('success','Gracias por compartir con nosotros, en breve nos comunicamos contigo.')
                    $('#div-formulario').hide();
                    $('#div-send').show();
                } else{
                    openSnackbar('warning','Ocurrió un error al enviar.')
                    $('#div-formulario').show();
                    $('#div-send').hide();
                }
            })
        })

    })
    $('#video-product').hide();
});


function changeImg(medium,big,name,li){
    showImages();
    $('#list-images li').each(function(indice, elemento) {
        if(elemento === li){
            indexImg=indice;
        }else{
        }
    });
    $('#drift-trigger').replaceWith(' <img style="width: 85%" id="drift-trigger" src="'+medium+'" data-zoom="'+big+'"  title="'+name+'" alt="'+name+'">');
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
        verifyAddCartProduct(productType,brand,mpn,1);
    }
}

function clearFormComentario(){
    $('#nombre').val('');
    $('#email').val('');
    $('#telefono').val('');
    $('#whatsapp').val('');
    $('#comentario').val('');
}

var indexImg=0;
function nextImg(){
    showImages();
    if($('#list-images li')[indexImg+1]){
        indexImg++;
        $('#list-images li')[indexImg].click();
    }else{
        indexImg=0;
        $('#list-images li')[indexImg].click();
    }
}

function beforeImg(){
    showImages();
    if($('#list-images li')[indexImg-1]){
        indexImg--;
        $('#list-images li')[indexImg].click();
    }else{
        indexImg=0;
        $('#list-images li')[indexImg].click();
    }
}

function showVideo(link){
    $('#video-product').html('<iframe id="frame-video" width="95%" height="500" src="https://www.youtube.com/embed/'+link+'?rel=0" frameborder="0" allowfullscreen></iframe>');
    $('#image-product').hide();
    $('#video-product').show();
}

function showImages(){
    var test = $('#image-product').is(":visible");
    if (test === false){
        $('#image-product').show();
        $('#frame-video').click();
        $('#video-product').hide();
        $('#video-product').html('');
    }
}
