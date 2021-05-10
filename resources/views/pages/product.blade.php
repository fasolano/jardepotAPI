@extends('pages')


@section('metaData')
    <title>{{ ucfirst($product['metaTitle'])}}</title>
    <meta title="{{ ucfirst($product['metaTitle'])}}"/>
    <meta name="description" content="{{isset( $product['metaDescription'])? $product['metaDescription']:'Jardepot'}}" >
    <meta id="robotG" name="googlebot" content="index,follow" />
    <meta id="robotB" name="robots" content="index,follow">
{{--    <meta name="keywords" content="{{$product['keywords']}}">--}}

    <meta property="og:title" content="{{isset( $product['metaTitle'])? $product['metaTitle']:'Jardepot'}}" />
    <meta property="og:description" content="{{isset( $product['metaDescription'])? $product['metaDescription']:'Jardepot'}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{isset($canonical)?$canonical:'https://www.jardepot.com/'}}" />
    <meta property="og:image" content="{{asset('img/logos/logoOG.jpg')}}" />
    <meta property="og:image:url" content="{{asset('img/logos/logoOG.jpg')}}" />
    <meta property="og:image:secure_url" content="{{asset('img/logos/logoOG.jpg')}}" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
@endsection

@section('specificCSS')
    <style>
        .btn-side-cart{
            display: block;
        }
        /* The flip card container - set the width and height to whatever you want. We have added the border property to demonstrate that the flip itself goes out of the box on hover (remove perspective if you don't want the 3D effect */
        .flip-card {
            background-color: transparent;
            perspective: 1000px; /* Remove this if you don't want the 3D effect */
        }

        /* This container is needed to position the front and back side */
        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }

        /* Do an horizontal flip when you move the mouse over the flip box container */
        .flip-card .fliped-card-inner {
            transform: rotateY(180deg);
        }

        /* Position the front and back side */
        .flip-card-back {
            display: none;
            width: 100%;
            -webkit-backface-visibility: hidden; /* Safari */
            backface-visibility: hidden;
        }

        /* Style the front side (fallback if image is missing) */

        /* Style the back side */
        .flip-card-back {
            background-color: dodgerblue;
            color: white;
            transform: rotateY(180deg);
        }
    </style>
    <link rel="stylesheet" href="{{asset('assets/css/components/sidebar.min.css')}}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/jquery.mCustomScrollbar.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pages/product.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/swiper.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/drift-basic.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pages/cart.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/slick-theme.css')}}">
    {{--<link rel="stylesheet" href="{{asset('assets/css/components/leaflet.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/leaflet-gesture-handling.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset('assets/css/pages/spare.css')}}">
    <link rel="canonical" href="{{$canonical}}">
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
@endsection

@section('content')
    <input type="hidden" id="current-product" data-producttype="{{$product['productType']}}" data-brand="{{$product['brand']}}" data-mpn="{{$product['mpn']}}">
    @component('components.breadcrumb')
        @slot('level1', 'Marcas')
        @slot('level2', $product['brand'])
        @slot('level3', $product['name'])
    @endcomponent
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="material-icons fn-color-jd mr-2">close</i>
            </div>
            @component('components.sidebar')
                @slot('id', 'Movil')
                @slot('sections', $sidebar)
            @endcomponent
        </nav>
        <!-- Page Content  -->
        <div id="content" class="row">
{{--            <div class="card d-none d-lg-block col-lg-3 mr-3" style="max-width: 23%">--}}
            <div class="d-none d-lg-block col-lg-3 p-0" >
                <div class="border shadow bg-white rounded d-none d-lg-block p-0" style="width: 90%;height: 100%;">
                @component('components.sidebar')
                    @slot('id', 'Desktop')
                    @slot('sections', $sidebar)
                @endcomponent
                </div>
            </div>

{{--            <div class="flip-card col-lg-9 col-md-12">--}}
            <div class="flip-card col-lg-9 col-md-12">
                <div class="flip-card-inner">
                    <div class="flip-card-front row">
                        <div class="col-lg-8 col-md-12">
                            <h1 class="title-product">{{$product['name']}}</h1>
                            <div class="row">
                                <div class="col-md-10 mt-2" style="padding-right: 0">
                                    <div class="card shadow-sm" style="overflow: hidden;" id="image-product">
{{--                                        @if($product['discount'] == 'Oferta')--}}
{{--                                            <div class="ribbon ribbon-top-right" style="display: block;z-index: 6"><span>Oferta</span></div>--}}
{{--                                        @endif--}}
                                        @if($product['discount'] == 'Oferta')
                                            <img src="{{ asset('assets/images/ofertas/oferta-0.png') }}" style="width: 100px;position: absolute;top: 0;left: 0;z-index: 3" title="Pestaña-Oferta" alt="Pestaña Oferta">
                                        @endif
                                        <div class="product-image" id="div-img-product" style="width: 100%;">
                                            <img style="width: 85%" id="drift-trigger"
                                                 src="{{asset($product['images'][0]['medium'])}}" data-zoom="{{asset($product['images'][0]['big'])}}"
                                                 title="{{$product['productType'].'-'.str_replace(" ", "-",$product['brand']).'-'.$product['mpn']}}"
                                                 alt="{{$product['productType'].' '.$product['brand'].' '.$product['mpn']}}">
                                        </div>
                                        @if($product['newPriceFloat'] > 3000)
                                            <img class="free-delivery" src="{{asset('assets/images/otros/gratis.png')}}"
                                                 title="Envío-gratis-Jardepot" alt="Envío gratis Jardepot">
                                        @endif
                                    </div>
                                    <div id="video-product"> </div>
                                    <div class="col-row d-block d-sm-block d-lg-none" style="width: 100%;">{{--movil--}}
                                        <div class="col-2">
                                            @if($product['video'])
                                                <a onclick="showVideo('{{$product['video']}}')">
                                                    <img width="60" height="60" src="https://img.youtube.com/vi/{{$product['video']}}/hqdefault.jpg" class="ui-pdp-image" srcset="https://img.youtube.com/vi/{{$product['video']}}/hqdefault.jpg 2x">
                                                    <img width="40" height="40" src="{{asset('assets/images/icons/youtube_icon.png')}}" title="YT"
                                                         alt="YT" style="position:absolute;top:10px;left:25px;border:none;">
                                                </a>
                                            @endif
                                            <br>
                                        </div>
                                        <div class="col-8">
                                            <div onclick="beforeImg()">
                                                <i class="material-icons navigate-products" style="left:-10px;">navigate_before</i>
                                            </div>
                                            <div>
                                                <ul class="swiper-product2" id="list-images">
                                                    @foreach($product['images'] as $image )
                                                        <li onclick="changeImg('{{asset($image['medium'])}}','{{asset($image['big'])}}','{{$product['name']}}',this)">
                                                            <div class="card shadow-sm product-item" style="border-radius: 5px;overflow: hidden;min-height: 100%;">
                                                                <img class="img-products" src="{{asset($image['small'])}}"
                                                                     title="{{$product['productType'].'-'.str_replace(" ", "-",$product['brand']).'-'.$product['mpn']}}"
                                                                     alt="{{$product['productType'].' '.$product['brand'].' '.$product['mpn']}}">
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div onclick="nextImg()">
                                                <i class="material-icons navigate-products" style="left:auto;right:-15px;">navigate_next</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 d-none d-md-none d-lg-block"> {{--Escritorio--}}
                                    <div class="col-12 text-center" style="width: 100%;">
                                        @if($product['video'])
                                            <a onclick="showVideo('{{$product['video']}}')">
                                                <img width="60" height="60" src="https://img.youtube.com/vi/{{$product['video']}}/hqdefault.jpg" class="ui-pdp-image" srcset="https://img.youtube.com/vi/{{$product['video']}}/hqdefault.jpg 2x">
                                                <img width="40" height="40" src="{{asset('assets/images/icons/youtube_icon.png')}}" title="YT"
                                                     alt="YT" style="position:absolute;top:10px;left:25px;border:none;">
                                            </a>
                                        @endif
                                        <br>
                                        <div onclick="beforeImg()">
                                            <i class="material-icons" style="font-size:35px;color:#f68600;cursor: pointer;">keyboard_arrow_up</i>
                                        </div>
                                        <div>
                                            <ul class="swiper-product3" id="list-images">
                                                @foreach($product['images'] as $image )
                                                    <li onclick="changeImg('{{asset($image['medium'])}}','{{asset($image['big'])}}','{{$product['name']}}',this)">
                                                        <div class="card shadow-sm product-item" style="border-radius: 5px;overflow: hidden;min-height: 100%;">
                                                            <img class="img-products" src="{{asset($image['small'])}}"
                                                                 title="{{$product['productType'].'-'.str_replace(" ", "-",$product['brand']).'-'.$product['mpn']}}"
                                                                 alt="{{$product['productType'].' '.$product['brand'].' '.$product['mpn']}}">
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div onclick="nextImg()">
                                            <i class="material-icons" style="font-size:35px;color:#f68600;cursor: pointer;">keyboard_arrow_down</i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-2 p-3 d-block d-sm-block d-lg-none">{{--               VISTA DE MOVIL                 --}}
                                    <div class="">
                                        @if($product['stock'])
                                            <div class="row">
                                                <div class="col-md-4 col-sm-6">
                                                    @if( ($product['oldPrice']) && $product['stock'])
                                                        <p class="old-price text-muted">{{$product['oldPrice'] }}</p>
                                                    @endif
                                                    <p class="new-price">
                                                        <span class="precio" style="color: #de1f21;font-weight:500;">{{$product['newPrice']}}</span>
                                                    </p>
                                                </div>
                                                <div class="col-md-8 col-sm-6">
                                                    <p class="text-bold-tiny">
                                                        @if($product['productType'] =='Aspersora' || $product['productType'] =='Motosierra' || $product['productType'] ==' Motobomba'
                                                            || $product['productType'] =='Parihuela' || $product['productType'] =='Termonebulizadora' || $product['productType'] =='Nebulizadora')
                                                            Producto para uso agrícola precio con IVA tasa 0%
                                                        @else
                                                            IVA incluido
                                                        @endif
                                                    </p>
                                                    <p class="text-bold-tiny">Precio aplica en pagos mediante depósito o transferencia bancaria.</p>
                                                    <p class="conditons">
                                                        *Sujeto a existencias. <br> *Precios sujetos a cambio sin previo aviso.
                                                    </p>
                                                </div>
                                            </div>
                                            {{--                            @if($product['discount'] == 'Oferta')--}}
                                            {{--                                <p style="color: #de1f21;font-weight:500;">Precio por aniversario, válido hasta el 23 de octubre 2020</p>--}}
                                            {{--                            @endif--}}
                                            <div class="row text-muted p-1"
                                                 style="flex-flow: row wrap; box-sizing: border-box;place-content: flex-start; align-items: flex-start;">
                                                {{--<div class="col-md-6">
                                                    <span>Cantidad:</span>
                                                    <br>
                                                    <button onclick="resNumProduct()" class="btn"> <i class="material-icons">remove</i> </button>
                                                    <span><input type="number" style="width: 40px" disabled id="cantidadProducto" name="cantidadProducto" value="1"></span>
                                                    <button onclick="addNumProduct()" class="btn"><i class="material-icons">add</i> </button>
                                                </div>--}}
                                                <div class="col-md-12 mt-2">
                                                    <a onclick="verifyAddCartProduct('{{$product['productType']}}','{{$product['brand']}}','{{$product['mpn']}}', 1, 'cart')" class="btn btn-block btn-danger my-2 text-white">¡Compra Ahora!</a>
                                                    {{--@if(($product['inventory'] > 0) && $product['stock'])
                                                        <a onclick="verifyAddCartProduct('{{$product['productType']}}','{{$product['brand']}}','{{$product['mpn']}}', 1, 'mercado')" class="btn btn-block btn-modal-mercado" href="javascript: void(0)"
                                                           style="background-color: #c7c7c7">¡Compra con Mensualidades!
                                                            <img src="{{asset("assets/images/bancos/mercadopago.png")}}" title="Pagar MergadoPago" alt="Pagar MercadoPago">
                                                        </a>
                                                    @endif--}}
                                                </div>
                                            </div>
                                            <div class="row text-muted p-1" style="flex-flow: row wrap; box-sizing: border-box;place-content: flex-start; align-items: flex-start;">
                                                {{--                                <button class="btn btn-primary">Meses</button>--}}
                                            </div>
                                            @if(($product['inventory'] > 0) && $product['stock'])
                                                <div class="py-1"><p class="fn-color-inStock">
                                                        <i class="material-icons">flash_on</i>&nbsp;Envío de volada </p>
                                                </div>
                                            @endif
                                            <h2 class="py-1 description-product">{{$product['description']}}</h2>
                                        @else
                                            <div class="row text-muted p-4">
                                                <p class="text-muted" style="font-weight: 900; font-size: 15px;">
                                                    Consulta precio y existencia. Llámanos a nuestros teléfonos
                                                </p>
                                            </div>
                                        @endif
                                        <div class="divider"></div>
                                        <div style="font-weight: bold !important;">
                                            @if( $product['stock'])
                                                <p class="conditons"><i class="material-icons" style="color: #f68600;font-size: 18px">local_shipping</i>
                                                    Envio gratis a partir de $3,000 de compra.
                                                    <a href="javascript: void(0)" data-toggle="modal" data-target="#modalCondicionEnvio"
                                                       style="color: rgba(0, 0, 0, 0.87);">*Condiciones</a>
                                                </p>
                                            @endif
                                            <p class="conditons"><i class="material-icons" style="color: #f68600;font-size: 18px">perm_phone_msg</i>
                                                Soporte y asesoria </p>
                                            <p class="conditons">
                                                <i class="material-icons" style="color: #f68600;font-size: 18px">build</i> Garantía de Fabrica
                                            </p>
                                        </div>
                                        <br>
                                        <div class="">
                                            <a class="btn btn-success" style="background: #35B73A;color: #fff" target="_blank"
                                               href="https://wa.me/527226481040?text=Hola,%20me%20gustar&iacute;a%20saber%20sobre%20las%20refacciones%20del%20producto%20{{$product['name']}}"
                                               tabindex="0" aria-disabled="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     aria-hidden="true" focusable="false" width="20px" height="20px"
                                                     style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                                                     preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path
                                                        d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01z"
                                                        fill="#fff"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)"/>
                                                </svg> Pregunta por refacciones
                                            </a>
                                            @if($ipl > 0)
{{--                                                <a class="btn btn-secondary my-2 justify-content-center" target="_blank" href="{{route('spare', $linkSpare)}}">--}}
                                                <a class="buttonFlip btn btn-secondary my-2 justify-content-center" href="javascript:;">
                                                    <span class="material-icons" style="font-size: 19px"> settings </span>
                                                    Guía de refacciones
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row card shadow mt-3">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link text-muted active" data-toggle="tab" href="#fichTecnica">Ficha técnica</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="fichTecnica" class="container tab-pane active">
                                        <div class="m-2">
                                            {!! $product['dataSheet'] !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row card shadow mt-3">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link text-muted active" data-toggle="tab" href="#comentariosProducto">Preguntas y respuestas</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3">
                                    <div id="comentariosProducto" class="container tab-pane active">
                                        <div class="m-2">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Su nombre completo" id="nombrePersona" name="nomre_cliente" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Su Correo Electrónico" id="correoPersona" name="correo_persona" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Su Número de teléfono (10 dígitos)" id="telefonoPersona" name="telefono_persona" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <span>Su calificación</span> --}}
                                                    <input type="hidden" id="customer_rate" value="0" />
                                                    <input type="hidden" id="commentToken" value="{{ csrf_token() }}"/>
                                                    {{-- <div class="stars">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                        <div class="star" data-rate="{{ $i }}" style="display: inline-block; cursor:pointer;">
                                                            <span class="material-icons" style="color:#dddddd;">
                                                                star_rate
                                                            </span>
                                                        </div>
                                                        @endfor
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control" placeholder="" rows="3" id="comentarioProducto" name="comentario"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5>Comprobemos que eres humano</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>¿Cuánto es ?</label>
                                                        <input class="form-control" type="text" readonly id="captchaQuestion" />
                                                        <input type="hidden" id="b"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Su respuesta</label>
                                                        <input type="text" class="form-control" id="captchaAnswere" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary" id="enviarComentario">Enviar Pregunta</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @foreach ($comentarios as $comentario)
                                            <hr />
                                            <div class="nombreComentario">
                                                <strong>{{ $comentario->nombre }}</strong><br/>
                                            </div>
                                            {{-- <div class="puntuacion">
                                                @foreach (range(1,5) as $estrella)
                                                    <div class="user-star" style="display: inline-block;">
                                                        @if($estrella <= $comentario->calificacion)
                                                            <span class="material-icons" style="color:#FFD700;">
                                                        @else
                                                            <span class="material-icons" style="color:#dddddd;">
                                                        @endif
                                                            star_rate
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div> --}}
                                            <div class="mensajeComentario" style="text-align: justify;">
                                                {!! $comentario->mensaje !!}
                                                @if($comentario->respuesta != "")
                                                    <div class="mx-5 my-2">
                                                        <hr/>
                                                        <strong>Respuesta de Administración:</strong><br/>
                                                        {{ $comentario->respuesta }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="fechaComentario" style="float: right; font-size:small;">
                                                {{ date('d/m/Y h:i A', strtotime($comentario->fecha)) }}
                                            </div>
                                            <br/>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @if(count($productsRelated))
                                <div class="row mt-4">
                                    <h5>Productos recomendados</h5>
                                    <div class="divider"></div>
                                    <!-- Swiper -->
                                    <div class="swiper-container p-1">
                                        <div class="swiper-wrapper">
                                            @foreach($productsRelated as $related)
                                                <div class="swiper-slide">
                                                    <div class="card shadow-sm product-item" style="border-radius: 5px;overflow: hidden;">
                                                        <a href="{{url($related['href'])}}">
{{--                                                            @if($related['discount'] == 'Oferta')--}}
{{--                                                                <div class="ribbon ribbon-top-right" style="display: block;position: relative;z-index: 6"><span>Oferta</span></div>--}}
{{--                                                            @endif--}}
                                                            @if($related['discount'] == 'Oferta')
                                                                <img src="{{ asset('assets/images/ofertas/oferta-0.png') }}" style="width: 75px;position: absolute;top: 0;left: 0;z-index: 3" title="Pestaña-Oferta" alt="Pestaña Oferta">
                                                            @endif
                                                            <div class="product-image img-container" style="height: 145px;">
                                                                <img style="max-width: 80%;max-height: 80%"
                                                                     src="{{asset($related['images'][0]['small'])}}"
                                                                     title="{{$related['productType'].'-'.str_replace(" ", "-",$related['brand']).'-'.$related['mpn']}}"
                                                                     alt="{{$related['productType'].' '.$related['brand'].' '.$related['mpn']}}">
                                                            </div>
                                                            @if($related['newPriceFloat'] > 3000)
                                                                <img class="free-delivery-recom" src="{{asset('assets/images/otros/gratis.png')}}"
                                                                     title="Envío-gratis-Jardepot" alt="Envío gratis Jardepot">
                                                            @endif
                                                        </a>
                                                        <a class="title text-truncate" data-toggle="tooltip" title="{{$related['name']}}">{{$related['name']}}</a>
                                                        <div style="height: 18px">
                                                            @if( ($related['oldPrice']) && $related['stock'])
                                                                <p class="old-price-recom text-muted">{{$related['oldPrice'] }}</p>
                                                            @endif
                                                        </div>
                                                        <div style="height: 19px">
                                                            @if($related['stock'])
                                                                <p class="new-price-recom">{{$related['newPrice']}}</p>
                                                            @endif
                                                        </div>
                                                        <div style="height: 47px">
                                                            @if($related['stock'])
                                                                <div class="divider"></div>
                                                                <button type="button" class="btn" onclick="verifyAddCartProduct('{{$related['productType']}}','{{$related['brand']}}','{{$related['mpn']}}',1)">
                                                                    <span style="font-size: 14px"><i class="material-icons fn-color-jd">shopping_cart</i>Agregar al carrito</span>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!-- Add Pagination -->
                                        <div class="mt-3"></div>
                                        <div class="swiper-pagination" style="margin-bottom: -5px"></div>
                                        <!-- Add Arrows -->
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                            @endif
{{--                            mustra formulario mobil--}}
                            <div class="card shadow-lg pl-1 mt-2 d-block d-sm-block d-lg-none">
                                <div style="margin: 5px">
                                    <a class="h4" href="tel:8002129225" style="color: #1b1e21">
                                        <i class="material-icons iconMod">local_phone</i>800 212 9225
                                    </a>
                                    <p class="h6">Llame ó llene con su información para que un asesor le contacte.</p>
                                    <div class="divider mb-2"></div>
                                    <form class="formularioDudas">
                                        {{ csrf_field() }}
                                        <div class="">
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="nombre">Nombre completo*:</label>
                                                <input type="text" class="form-control" name="nombre" placeholder="Nombre completo*" id="nombre" >
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="email">Email*:</label>
                                                <input type="text" class="form-control" placeholder="Email*" id="email" name="email" >
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="telefono">Teléfono (10 digitos)*:</label>
                                                <input type="text" class="form-control" placeholder="Teléfono (10 digitos)*" id="telefono" name="telefono">
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="whatsapp">Whatsapp:</label>
                                                <input type="text" class="form-control" placeholder="Whatsapp" id="whatsapp"  name="whatsapp">
                                            </div>

                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="comentario">Comentarios</label>
                                                <textarea class="form-control" id="comentario" name="comentario" placeholder="Comentario"  rows="3"></textarea>
                                            </div>

                                            <input type="hidden" id="producto" name="producto" value="{{$product['name']}}">
                                            <button id="btnSubmit" type="submit" class="btn btn-warning btn-block">Enviar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            @include('components.infoCompra')
                            {{-- @include('components.caruselCanales') --}}
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="position-absolute"  style="max-width: 97%;z-index: 999;pointer-events: none; ">
                                <div style="height: 500px;" class="position-relative">
                                    <div style="width: 400px !important;">
                                        <div class="detail"></div> {{--Muestra el zoom--}}
                                    </div>
                                </div>
                            </div>
                            <div class="d-none d-md-none d-lg-block">{{--  VISTA DE ESCRITORIO--}}
                                @if(isset($product['imgBrand']))
                                    <div class="text-center">
                                        <img src="{{asset($product['imgBrand'])}}" style="width: 160px" alt="{{'Logo '.$product['brand']}}" title="{{'Logo-'.$product['brand']}}" >
                                    </div>
                                @endif
                                <h2 class="py-1 description-product">{{$product['description']}}</h2>
                                <br>
                                @if($product['stock'])
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            @if( ($product['oldPrice']) && $product['stock'])
                                                <p class="old-price text-muted">{{$product['oldPrice'] }}</p>
                                            @endif
                                            <p class="new-price">
                                                <span class="precio" style="color: #de1f21;font-weight:500;">{{$product['newPrice']}}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <p class="text-bold-tiny">
                                                @if($product['productType'] =='Aspersora' || $product['productType'] =='Motosierra' || $product['productType'] ==' Motobomba'
                                                    || $product['productType'] =='Parihuela' || $product['productType'] =='Termonebulizadora' || $product['productType'] =='Nebulizadora')
                                                    Producto para uso agrícola precio con IVA tasa 0%
                                                @else
                                                    IVA incluido
                                                @endif
                                            </p>
                                            <p class="text-bold-tiny">Precio aplica en pagos mediante depósito o transferencia bancaria.</p>
                                            <p class="conditons">
                                                *Sujeto a existencias. <br> *Precios sujetos a cambio sin previo aviso.
                                            </p>
                                        </div>
                                    </div>
                                    {{--                            @if($product['discount'] == 'Oferta')--}}
                                    {{--                                <p style="color: #de1f21;font-weight:500;">Precio por aniversario, válido hasta el 23 de octubre 2020</p>--}}
                                    {{--                            @endif--}}
                                    <div class="row text-muted p-1"
                                         style="flex-flow: row wrap; box-sizing: border-box;place-content: flex-start; align-items: flex-start;">
                                        {{--<div class="col-md-6">
                                            <span>Cantidad:</span>
                                            <br>
                                            <button onclick="resNumProduct()" class="btn"> <i class="material-icons">remove</i> </button>
                                            <span><input type="number" style="width: 40px" disabled id="cantidadProducto" name="cantidadProducto" value="1"></span>
                                            <button onclick="addNumProduct()" class="btn"><i class="material-icons">add</i> </button>
                                        </div>--}}
                                        <div class="col-md-12 mt-2">
                                            <a onclick="verifyAddCartProduct('{{$product['productType']}}','{{$product['brand']}}','{{$product['mpn']}}', 1, 'cart')" class="btn btn-block btn-danger my-2 text-white">¡Compra Ahora!</a>
                                            @if(($product['inventory'] > 0) && $product['stock'])
                                                <a onclick="verifyAddCartProduct('{{$product['productType']}}','{{$product['brand']}}','{{$product['mpn']}}', 1, 'mercado')" class="btn btn-block btn-modal-mercado" href="javascript: void(0)"
                                                   style="background-color: #c7c7c7">¡Compra con Mensualidades!
                                                    <img src="{{asset("assets/images/bancos/mercadopago.png")}}" title="Pagar-MergadoPago" alt="Pagar MercadoPago">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row text-muted p-1" style="flex-flow: row wrap; box-sizing: border-box;place-content: flex-start; align-items: flex-start;">
                                        {{--                                <button class="btn btn-primary">Meses</button>--}}
                                    </div>
                                    @if(($product['inventory'] > 0) && $product['stock'])
                                        <div class="py-1"><p class="fn-color-inStock">
                                                <i class="material-icons">flash_on</i>&nbsp;Envío de volada </p>
                                        </div>
                                    @endif
                                @else
                                    <div class="row text-muted p-4">
                                        <p class="text-muted" style="font-weight: 900; font-size: 15px;">
                                            Consulta precio y existencia. Llámanos a nuestros teléfonos
                                        </p>
                                    </div>
                                @endif
                                <div class="divider"></div>
                                <div style="font-weight: bold !important;">
                                    @if($product['stock'])
                                        <p class="conditons"><i class="material-icons" style="color: #f68600;font-size: 18px">local_shipping</i>
                                            Envio gratis a partir de $3,000 de compra.
                                            <a href="javascript: void(0)" data-toggle="modal" data-target="#modalCondicionEnvio"
                                               style="color: rgba(0, 0, 0, 0.87);">*Condiciones</a>
                                        </p>
                                    @endif
                                    <p class="conditons"><i class="material-icons" style="color: #f68600;font-size: 18px">perm_phone_msg</i>
                                        Soporte y asesoria </p>
                                    <p class="conditons">
                                        <i class="material-icons" style="color: #f68600;font-size: 18px">build</i> Garantía de Fabrica
                                    </p>
                                </div>
                                <br>
                                <a class="btn btn-success" style="background: #35B73A;color: #fff" target="_blank"
                                   href="https://wa.me/527226481040?text=Hola,%20me%20gustar&iacute;a%20saber%20sobre%20las%20refacciones%20del%20producto%20{{$product['name']}}"
                                   tabindex="0" aria-disabled="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         aria-hidden="true" focusable="false" width="20px" height="20px"
                                         style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                                         preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path
                                            d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01z"
                                            fill="#fff"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)"/>
                                    </svg> Pregunta por refacciones
                                </a>
                                @if($ipl > 0)
                                    <a class="buttonFlip btn btn-secondary my-2 justify-content-center" href="javascript:;">
                                        <span class="material-icons" style="font-size: 19px"> settings </span>
                                        Guía de refacciones
                                    </a>
                                @endif
                            </div>
                            <br>
{{--                            muestra formulario escritorio--}}
                            <div class="card shadow-lg pl-1 mt-2  d-none d-sm-none d-md-block">
                                <div style="margin: 5px">
                                    <a class="h4" href="tel:8002129225" style="color: #1b1e21">
                                        <i class="material-icons iconMod">local_phone</i>800 212 9225
                                    </a>
                                    <p class="h6">Llame ó llene con su información para que un asesor le contacte.</p>
                                    <div class="divider mb-2"></div>
                                    <form class="formularioDudas">
                                        {{ csrf_field() }}
                                        <div class="">
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="nombre">Nombre completo*:</label>
                                                <input type="text" class="form-control" name="nombre" placeholder="Nombre completo*" id="nombre" >
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="email">Email*:</label>
                                                <input type="text" class="form-control" placeholder="Email*" id="email" name="email" >
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="telefono">Teléfono (10 digitos)*:</label>
                                                <input type="text" class="form-control" placeholder="Teléfono (10 digitos)*" id="telefono" name="telefono">
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="whatsapp">Whatsapp:</label>
                                                <input type="text" class="form-control" placeholder="Whatsapp" id="whatsapp"  name="whatsapp">
                                            </div>

                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="comentario">Comentarios</label>
                                                <textarea class="form-control" id="comentario" name="comentario" placeholder="Comentario"  rows="3"></textarea>
                                            </div>

                                            <input type="hidden" id="producto" name="producto" value="{{$product['name']}}">
                                            <button id="btnSubmit" type="submit" class="btn btn-warning btn-block">Enviar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

{{--                    Crep parte IPL--}}
                    <div class="flip-card-back">
                        @if($ipl > 0)
                        <div class="col-lg-12 col-md-12 card shadow" >
                            <h4 class="title-product">{{ucwords($product['productType'])}} {{ucwords($product['brand'])}} - <span style="text-transform: uppercase;">{{$product['mpn']}}</h4>
                            <h4 style="color: #000; text-align: center;">Comunícate al <br> <i class="fa fa-phone"></i> <strong> 800 212 9225</strong> ó <strong>722 648 1040</strong></h4>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="mt-element-list">
                                        <div class="mt-list-container list-news ext-1">
                                            <div class="listIpl" style="max-height: 250px;">
                                                @foreach ($ipls as $ipl)
                                                    <div class="item @if ($loop->first) active @endif"
                                                         data-src="{{asset("assets/images/ipl/".$producto."/".$ipl->imagen)}}"
                                                         data-ipl="{{ $ipl->id_ipl }}" style="text-align: center">
                                                        <img src="{{asset("assets/images/ipl/".$producto."/".$ipl->imagen)}}">
                                                        <span>{{ $ipl->nombre }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 40px;">

                                        </div>
                                    </div>

                                    <div class="row" id="bloqueIPLS">
                                        <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-0"
                                             style="margin-bottom: 20px;">
                                            <div class="mt-element-list">
                                                <div class="mt-list-head list-news ext-1 font-white bg-green-sharp"
                                                     style="background-color: #424242; padding-top: 1px; border-radius: 10px 10px 0px 0px; color: #fff; padding-bottom: 1px;">
                                                    <div class="list-head-title-container">
                                                        <h4 class="list-title text-center">Lista de refacciones</h4>
                                                    </div>
                                                </div>
                                                <div class="mt-list-container list-news ext-1"
                                                     style="max-height: 1000px; overflow-y: scroll; overflow-x: hidden;">
                                                    <ul id="listPiezas" style="padding: 10px;">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-8 col-lg-offset-1">
                                            <div class="mt-list-head list-news ext-1 font-white bg-green-sharp"
                                                 style="background-color: #424242; padding-top: 1px; border-radius: 10px 10px 0px 0px; color: #fff; padding-bottom: 1px; width: 100%; align-items: center">
                                                <div class="list-head-title-container">
                                                    <h4 class="list-title text-center" id="nombreParte"> nombre de la parte</h4>
                                                </div>
                                            </div>
                                            <div id="mapid"
                                                 class=" map-container map leaflet-container leaflet-touch leaflet-fade-anim leaflet-touch-zoom leaflet-grab leaflet-touch-drag"
                                                 tabindex="0"
                                                 data-gesture-handling-touch-content="Para mover el mapa, utiliza dos dedos"
                                                 data-gesture-handling-scroll-content="Mantén pulsada la tecla Ctrl mientras te desplazas para acercar o alejar el mapa"
                                                 style="width: 100%; height: 1000px; z-index: 1;position: relative;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            @include('components.infoCompra')
                            {{-- @include('components.caruselCanales') --}}
                        </div>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- Modal MercadoPago-->
    <div class="modal fade" id="modalMercadoPago" tabindex="-1" role="dialog" aria-labelledby="modalMercadoPago"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pagar con MercadoPago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="carrito" class="row mb-2" style="font-size: 14px;">
                        <div id="no-more-tables" style="width: 100%;">
                            <table class="table col-sm-12 table-condensed cf">
                                <thead class="cf">
                                <tr>
                                    <th>Producto</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th class="text-center">
                                        <button class="btn btn-secondary" id="remove-all-products">Borrar todo</button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-2" style="font-size: 14px;">
                        <div class="col-12">
                            {{--                            <p style="font-size: 18px;font-weight: 500;">*Se agregará una comisión del 4% por forma de pago</p>--}}
                            <p style="font-size: 18px;font-weight: 500;">*Se agregará al precio la comisión de MercadoPago correspondiente al plazo de mensualidades seleccionado.</p>
                            <br>
                            <label style="font-size: 18px;font-weight: 500;"><input type="checkbox" name="terminosPayPal" id="terminosMP">
                                Acepto terminos y condiciones</label>
                            <a href="javascript: void(0)" data-toggle="modal" data-target="#modalCondicionEnvio"
                               style="color: rgba(0, 0, 0, 0.87);">*Consultalos aquí</a>
                            <br>
                        </div>
                    </div>
                    <form id="form-mp">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="name-mp" name="name" placeholder="Nombre(s)*">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="lastname-mp" name="lastName" placeholder="Apellidos*">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="email-mp" name="email" placeholder="Email*">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="phone-mp" name="phone" maxlength="10" placeholder="Teléfono (10 dígitos)*"></div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="state-mp" name="state" placeholder="Estado*">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="city-mp" name="city" placeholder="Ciudad*">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="zip-mp" name="zipCode" placeholder="Código postal*"></div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="suburb-mp" name="suburb" placeholder="Colonia*">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group"><input class="form-control" id="address-mp" name="address" placeholder="Direccion*">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row" style="font-size: 14px;">
                        <div id="form-incomplete-mp" class="col-12">
                            <p id="text-input-mp" class="text-muted">Por favor rellena todos los campos</p>
                            <p id="text-terms-mp" class="text-muted">Acepta los terminos y condiciones</p>
                        </div>
                        <div id="form-complete-mp" class="col-12 text-right">
                            <button class="btn btn-warning" type="button" disabled="" id="btn-mercado-pago">Siguiente</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('specificJS')
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <script src="{{asset('assets/js/components/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/sidebar.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/swiper.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/drift.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/pages/product.js')}}?v={{ time() }}"></script>
    <script type="text/javascript" src="{{asset('assets/js/pages/cart.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/slick.js')}}"></script>
    {{--<script type="text/javascript" src="{{asset('assets/js/components/leaflet.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/leaflet-gesture-handling.min.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('assets/js/pages/spare.js')}}"></script>
    <script>
        $('.buttonFlip').click(function () {
            $('.flip-card-inner').addClass('fliped-card-inner');
            $('.flip-card-front').css('display','none');
            $('.flip-card-back').css('display','block');
        });
    </script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 5,
            spaceBetween: 20,
            slidesPerGroup: 5,
            loop: true,
            loopFillGroupWithBlank: true,
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 320px
                300: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                    slidesPerGroup: 2,
                },
                320: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                    slidesPerGroup: 2,
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                    slidesPerGroup: 2,
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                    slidesPerGroup: 4,
                }
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            dragSize:true,
            preloadImages:true,
        });
        // new Drift(document.querySelector('.drift-demo-trigger'), {
        new Drift(document.getElementById('drift-trigger'), {
            paneContainer: document.querySelector('.detail'),
            inlinePane: 900,
            inlineOffsetY: -85,
            // inlineOffsetX: -85,
            containInline: true,
            hoverBoundingBox: true,
        });
    </script>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Product",
            "name": "{{$product['name']}}",
            "mpn": "{{$product['mpn']}}",
            "brand": "{{$product['brand']}}",
            "image": "{{asset($product['images'][0]['medium'])}}",
            "description": "{{$product['description']}}",
            "offers": {
                "@type": "Offer",
                "price": {{isset($product['newPriceFloat'])?str_replace(",","",$product['newPriceFloat']):null}},
                "priceCurrency": "MXN"
            },
        }
    </script>
@endsection
