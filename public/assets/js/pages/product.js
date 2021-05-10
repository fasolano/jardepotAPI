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

$("#enviarComentario").on('click', async function(evento){
    evento.preventDefault();
    const nombrePersona = document.querySelector("#nombrePersona").value
    const comentarioProducto = document.querySelector("#comentarioProducto").value
    const correoPersona = document.querySelector("#correoPersona").value
    const rate = document.querySelector("#customer_rate").value
    const telefonoPersona = document.querySelector("#telefonoPersona").value
    const producto = document.querySelector("#producto").value
    const token = document.querySelector("#commentToken").value
    const testUrl = /(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/
    const testEmail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/
    const testNumbers = /[0-9]+$/
    if(testUrl.test(nombrePersona)){
        openSnackbar('error','El campo Nombre no debe de contener links')
        return false
    } else {
        if(testEmail.test(nombrePersona) && $.trim(nombrePersona).length != 0){
            openSnackbar('error','EL campo Nombre no puede contener esos caracteres. Tiene que ser un nombre')
            return false
        } else {
            if($.trim(nombrePersona).length == 0){
                openSnackbar('error','EL campo Nombre no puede estar vacío')
                return false
            }
        }
    }
    if(testUrl.test(comentarioProducto)){
        openSnackbar('error','El campo Comentario no debe de contener links')
        return false
    } else {
        if(testEmail.test(comentarioProducto) && $.trim(comentarioProducto).length != 0){
            openSnackbar('error','EL campo Comentario no puede contener esos caracteres. Tiene que ser un nombre')
            return false
        } else {
            if($.trim(comentarioProducto).length == 0){
                openSnackbar('error','EL campo Comentario no puede estar vacío')
                return false
            }
        }
    }
    if(rate == 0){
        openSnackbar('error','Tiene que proporcionar una calificación')
        return false
    }

    if(!testEmail.test(correoPersona) && $.trim(nombrePersona).length != 0){
        openSnackbar('error','EL campo Correo tiene que ser un correo electrónico')
        return false
    } else {
        if($.trim(correoPersona).length == 0){
            openSnackbar('error','EL campo Correo no puede estar vacío')
            return false
        }
    }

    if(!testNumbers.test(telefonoPersona) && $.trim(telefonoPersona).length != 0){
        openSnackbar('error','EL campo Teléfono tiene tener solo números')
        return false
    } else {
        if($.trim(telefonoPersona).length != 10){
            openSnackbar('error','El campo Teléfono debe tener 10 números')
            return false
        }
    }
    const rateData = {
        correoPersona,
        nombrePersona,
        telefonoPersona,
        rate,
        comentarioProducto,
        producto
    }
    let rate_request = await fetch('/product/rate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify(rateData)
    }).then((response) => {
        response.json().then((data) =>{
            if(data.status == 'success'){
                document.querySelector("#nombrePersona").value = ""
                document.querySelector("#comentarioProducto").value = ""
                document.querySelector("#correoPersona").value = ""
                document.querySelector("#customer_rate").value = 0
                document.querySelector("#telefonoPersona").value = ""
                openSnackbar('success', '¡Gracias por su comentario!, pronto nos pondrmeos en contacto con usted')
            } else {
                openSnackbar('error', 'Ha ocurrido un error al enviar el comentario, intente de nuevo más tarde')
            }

        }).catch(() => openSnackbar('Error en el servidor, intente de nuevo más tarde'))
    })
})

$(document).on('click', '.star', function(ev){
    const rate = this.dataset.rate
    $.each($(".star"), function(index, star){
        const star_rate = star.dataset.rate
        const current_star = $(star).find('span')[0]
        if(star_rate <= rate){
            $(current_star).css('color', "#FFD700")
        } else {
            $(current_star).css('color', "#dddddd")
        }
    })
    $("#customer_rate").val(rate)
})
