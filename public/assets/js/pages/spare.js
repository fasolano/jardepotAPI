var mapWidth, imageBounds, imageHeight, imageWidth, mapHeight, minZoom, map, nombre, ipl, tabla = "", busy = false;
(function() {
    "use strict";

    $(document).ready(function () {
        /*$.ajax({
            url:'./carrito',
            dataType: 'json',
            type: 'post',
            data: {
                _token:$('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if(response.numero !== 0){

                    agregarCarrito(response.articulos, response.numero);
                    initInputsNumber();
                    $('#totalCesta').text(response.total);
                }
            },
            error: function (err) {
                console.log(err);
            }
        });*/

        $('.listIpl').slick({
            centerMode: true,
            slidesToShow: 5,
            infinite:true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: true,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: true,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 2
                    }
                }
            ],
            arrows : true,
            autoplay: false
        });


        $('.item').click(function () {
            $('div').removeClass('fondoActive');
            $(this).parent('div').addClass('fondoActive');
            nombre = $(this).attr('data-src');
            ipl = $(this).attr('data-ipl');
            $('#nombreParte').text($(this).find('span').text());

            var img = new Image();
            img.src = nombre;
            img.onload = function() {

                var html = $("#mapid").html();
                if (html != '') {
                    map.gestureHandling.disable();
                    map.remove();
                }

                var imageUrl = nombre;
                imageWidth = this.width;
                imageHeight = this.height;
                imageBounds = [[0, 0], [imageHeight, imageWidth]];

                mapWidth = $(".map-container").width();
                mapHeight = imageHeight / (imageWidth / mapWidth);
                $("#map").css("height", mapHeight);

                minZoom = (((mapWidth - imageWidth) * 2) / imageWidth);

                map = L.map('mapid', {
                    maxZoom: 1.3,
                    minZoom: -0.7,
                    center: [0, 0],
                    crs: L.CRS.Simple,
                    doubleClickZoom: false,
                    maxBounds: imageBounds,
                    maxBoundsViscosity: 0.1,
                    gestureHandling: true
                });

                L.imageOverlay(imageUrl, imageBounds).addTo(map);
                map.fitBounds([[0, 0], [imageHeight, imageWidth]]);
                map.zoomOut();

                $.ajax({
                    url:'./marcadores',
                    dataType:'json',
                    type:'get',
                    data:{
                        ipl:ipl,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        var piezas = "";
                        var numPieza = new Array();
                        $.each(response, function( index, refaccion ) {
                            if (numPieza[refaccion.pieza] != 1){
                                numPieza[refaccion.pieza] = 1;
                                piezas += '<li class="mt-list-item item-pieza" style="list-style: none; ' +
                                    'border-bottom: 2px solid; border-color: #e7ecf1; margin-bottom: 15px">' +
                                    '          <span class="numeroList">'+refaccion.indice_ipl+'</span>' +
                                    '          <p class="text-center"><b>'+refaccion.nombre+'</b></p>' +
                                    '          <p class="row"> <div class="col-md-6"><b>Código:</b><br> '+refaccion.codigo+'</div> ' +
                                    '          <div class="col-md-6"><b>Costo:</b><br> $'+refaccion.precio+' MXN</div></p>' +
                                    '          ' +
                                    '          <p>'+refaccion.comentario+'</p>' +
                                    // '          <p class="text-center">Cantidad: <input type="number" class="form-control cantidad"><button class="btn btn-primary addCarrito" data-pieza="'+refaccion.pieza+'">Agregar</button></p>'+
                                    '          <div class="btn-group col-md-12 col-sm-12 col-lg-6">' +
                                    '             <input type="number" class="form-control" value="1" min="1" style="min-width: 50px; max-width: 60px;">' +
                                    '                                        <span class="input-group-btn" style="float: left;">' +
                                    '                                            <button class="btn btn-primary addCarrito" type="button" data-pieza="'+refaccion.pieza+'">Agregar</button>' +
                                    '                                        </span>' +
                                    '                                    </div>'+
                                    '      </li>';
                            }


                            //añade marcador
                            L.marker([refaccion.latitud, refaccion.longitud], {
                                icon: new L.DivIcon({
                                    html: '<div class="map-marker mark-'+refaccion.indice_ipl+'">'+refaccion.indice_ipl+'</div>'
                                })
                            }).bindPopup(
                                '<b>'+refaccion.coment+'</b><br>' +
                                '<b>Código:</b> '+refaccion.codigo+'<br> ' +
                                '<b>Pieza:</b> '+refaccion.nombre+'<br> ' +
                                '<b>Costo:</b> $'+refaccion.precio+' <b>MXN</b><br> ' +
                                '<button class="btn btn-primary addCarrito" data-pieza="'+refaccion.pieza+'">Agregar</button>'
                            ).on('mouseover', function (e) {
                                this.openPopup();
                            }).addTo(map);

                        });
                        $('#listPiezas').html('');
                        $('#listPiezas').append(piezas);
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }
        });

        $('.active').trigger('click');

        $(document).on('click', '.item-pieza', function () {
            var num = $(this).find('.numeroList').text();
            $('.mark-'+num).trigger('click');
        });

        $(document).on('click', '.addCarrito', function () {
            var pieza = $(this).attr('data-pieza');
            var cant = $(this).parents('.input-group').find('input').val() == undefined ? 1:$(this).parents('.input-group').find('input').val();
            var modelo = $('#modelo').val();
            if(cant > 0){
                $.ajax({
                    url:'./agregar/refaccion',
                    dataType: 'json',
                    type:'post',
                    data:{
                        pieza:pieza,
                        cantidad:cant,
                        modelo:modelo,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if(response.numero > 0){
                            $.toast({
                                heading: 'Refacción agregada',
                                text: 'Para ver tu lista de refacciones dirígite a la cesta de refacciones',
                                showHideTransition: 'slide',
                                position: 'top-center',
                                icon: 'success'
                            });
                            agregarCarrito(response.articulo, response.numero);
                            initInputsNumber();
                            $('#totalCesta').text(response.total);
                        }else{
                            $.toast({
                                heading: 'Error al agregar',
                                text: 'La cantidad de productos debe ser 1 o mayor',
                                showHideTransition: 'slide',
                                position: 'top-center',
                                icon: 'error'
                            });
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }else{
                $.toast({
                    heading: 'Error al agregar',
                    text: 'La cantidad de productos debe ser 1 o mayor',
                    showHideTransition: 'slide',
                    position: 'top-center',
                    icon: 'error'
                });
            }
        });

        $(document).on('click', '.borrarRefaccion', function () {
            var row = $(this).closest('tr').data('__FooTableRow__');
            var pieza = $(this).attr('data-pieza');
            if (row instanceof FooTable.Row){
                $.ajax({
                    url:'./borrar/refaccion',
                    dataType: 'json',
                    type: 'post',
                    data:{
                        pieza:pieza,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if(response.status == 1){
                            $.toast({
                                heading: 'Refacción eliminada',
                                text: '',
                                showHideTransition: 'slide',
                                position: 'top-center',
                                icon: 'success'
                            });
                            $('#totalCesta').text(response.total);
                            if(response.numero > 0){
                                $('.cesta .badge').text(response.numero);
                                $('.cesta').css('display', 'block');
                            }else{
                                $('.cesta').css('display', 'none');
                            }
                            row.delete();
                        }else{
                            $.toast({
                                heading: 'Error al eliminar',
                                text: 'No se pudo encontrar la refacción a eliminar en la cesta',
                                showHideTransition: 'slide',
                                position: 'top-center',
                                icon: 'error'
                            });
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }
        });

        $('#siguiente').click(function () {
            $('#canastaContenedor').slideUp(function () {
                $('#formularioContenedor').slideDown();
                $('#atras').css('display','inline-block');
                $('#siguiente').css('display','none');
                $('#finalizar').css('display','inline-block');
            });
        });

        $('#atras').click(function () {
            $('#formularioContenedor').slideUp(function () {
                $('#canastaContenedor').slideDown();
                $('#atras').css('display','none');
                $('#finalizar').css('display','none');
                $('#siguiente').css('display','inline-block');
            });
        });

        $('#finalizar').click(function () {
            var nombre = $('#nombre').val();
            var telefono = $('#telefono').val();
            var mail = $('#mail').val();
            var comentarios = $('#comentarios').val();
            if(nombre.trim() !== "" && telefono.trim() !== ""){
                $.ajax({
                    url:'./enviar/refacciones',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        nombre:nombre,
                        telefono:telefono,
                        mail:mail,
                        comentarios:comentarios,
                        _token:$('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response === 1){
                            $('#formularioContenedor').slideUp(function () {
                                $('#agradecimientos').slideDown();
                                $('#cerrar').css('display', 'inline-block');
                                $('#finalizar').css('display','none');
                                $('#siguiente').css('display','none');
                                $('#atras').css('display','none');
                                $('#seguir').css('display','none');
                            });
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }

        });

    });

    function agregarCarrito(articulo, numero) {
        if (tabla !== "") {
            var ft = FooTable.get("#tableRefacciones");
            var fila;
            $.each(ft.rows.all, function(i, row){
                if(row.val().brand == articulo.brand && row.val().codigo == articulo.codigo){
                    fila = row;
                }
            });
            if (fila instanceof FooTable.Row){
                fila.val(articulo);
            } else {
                ft.rows.add(articulo);
            }

        }else{
            articulo = Array.isArray(articulo)?articulo:[articulo];
            tabla = $('#tableRefacciones').footable({
                "expandFirst": true,
                "columns": [
                    { "name": "codigo", "title": "Codigo" },
                    { "name": "nombre", "title": "Refaccion", "breakpoints": "sm, xs" },
                    { "name": "brand", "title": "Marca", "breakpoints": "sm, xs" },
                    { "name": "precio", "title": "Precio", "breakpoints": "sm, xs" },
                    { "name": "cantidad", "title": "Cantidad" },
                    { "name": "subtotal", "title": "Subtotal" },
                    { "name": "opcion", "title": ""}
                ],
                "rows":articulo
            });
        }

        $('.cesta .badge').text(numero);
        $('.cesta').css('display', 'block');
    }

    function initInputsNumber() {
        $('.quantity').each(function() {
            var spinner = $(this),
                input = spinner.find('input[type="number"]'),
                btnUp = spinner.find('.quantity-up'),
                btnDown = spinner.find('.quantity-down'),
                min = input.attr('min'),
                max = input.attr('max');

            btnUp.click(function () {
                var pieza = input.attr('data-pieza');
                var modelo = $('#modelo').val();
                if (busy === false){
                    busy = true;
                    $.ajax({
                        url:'./agregar/refaccion',
                        dataType: 'json',
                        type:'post',
                        data:{
                            pieza:pieza,
                            cantidad: '1',
                            modelo:modelo,
                            _token:$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if(response.numero > 0){
                                agregarCarrito(response.articulo, response.numero);
                                initInputsNumber();
                                $('#totalCesta').text(response.total);
                            }else{
                                $.toast({
                                    heading: 'Error al agregar',
                                    text: 'La cantidad de productos debe ser 1 o mayor',
                                    showHideTransition: 'slide',
                                    position: 'top-center',
                                    icon: 'error'
                                });
                            }
                            busy = false;
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                }
            });

            btnDown.click(function () {
                var oldValue = parseFloat(input.val());
                var pieza = input.attr('data-pieza');
                var modelo = $('#modelo').val();
                if (oldValue > min && busy === false) {
                    busy = true;
                    $.ajax({
                        url:'./agregar/refaccion',
                        dataType: 'json',
                        type:'post',
                        data:{
                            pieza:pieza,
                            cantidad: '-1',
                            modelo:modelo,
                            _token:$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if(response.numero > 0){
                                agregarCarrito(response.articulo, response.numero);
                                initInputsNumber();
                                $('#totalCesta').text(response.total);
                            }else{
                                $.toast({
                                    heading: 'Error al agregar',
                                    text: 'La cantidad de productos debe ser 1 o mayor',
                                    showHideTransition: 'slide',
                                    position: 'top-center',
                                    icon: 'error'
                                });
                            }
                            busy = false;
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                }

            });
        });
    }


})(jQuery);
