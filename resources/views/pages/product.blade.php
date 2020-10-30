@extends('pages')


@section('metaData')
    <title>{{ ucfirst($product['metaTitle'])}}</title>
    <meta title="{{ ucfirst($product['metaTitle'])}}"/>
    <meta name="description" content="{{$product['metaDescription']}}">
    <meta name="keywords" content="{{$product['keywords']}}">

    <meta property="og:title" content="{{ $product['metaTitle'] }}" />
    <meta property="og:description" content="{{ $product['metaDescription'] }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.jardepot.com/" />
    <meta property="og:image" content="{{asset('img/logos/logoOG.jpg')}}" />
    <meta property="og:image:url" content="{{asset('img/logos/logoOG.jpg')}}" />
    <meta property="og:image:secure_url" content="{{asset('img/logos/logoOG.jpg')}}" />
@endsection

@section('specificCSS')
    <link rel="stylesheet" href="{{asset('assets/css/components/sidebar.min.css')}}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/jquery.mCustomScrollbar.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pages/product.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/swiper.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/drift-basic.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pages/cart.min.css')}}">
    <link rel="canonical" href="https://www.jardepot.com">
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
@endsection

@section('content')
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
            <div class="card d-none d-lg-block col-lg-3 mr-3" style="max-width: 23%">
                @component('components.sidebar')
                    @slot('id', 'Desktop')
                    @slot('sections', $sidebar)
                @endcomponent
            </div>

            <div class="col-lg-7 col-md-12">
                <h1 class="title-product">{{$product['name']}}</h1>
                <div class="row">
                    <div class="col-md-5 mt-2">
                        <div class="card shadow-sm" style="overflow: hidden;">
                            @if($product['discount'] == 'Oferta')
                                <div class="ribbon ribbon-top-right" style="display: block;z-index: 6"><span>Oferta</span></div>
                            @endif

                            <div class="product-image" id="div-img-product">
                                <img style="max-width: 100%" id="drift-trigger"
                                     src="{{asset($product['images'][0]['medium'])}}" data-zoom="{{asset($product['images'][0]['big'])}}"
                                     title="{{$product['name']}}" alt="{{$product['name']}}">
                            </div>
                            @if($product['newPriceFloat'] > 3000)
                                <img class="free-delivery" src="{{asset('assets/images/otros/gratis.png')}}"
                                     title="Envío gratis Jardepot" alt="Envío gratis Jardepot">
                            @endif
                        </div>
                        <!-- Swiper -->
            {{--            <div class="swiper-container p-1">
                            <div class="swiper-wrapper">
                                @foreach($product['images'] as $image )
                                    <div class="swiper-slide">
                                        <div class="card shadow-sm product-item" style="border-radius: 5px;overflow: hidden;">
                                            <div class="product-image2">
                                                <img style="max-width: 80%" onclick="changeImg('{{asset($image['medium'])}}','{{asset($image['big'])}}','{{$product['name']}}')"
                                                     src="{{asset($image['small'])}}"
                                                     title="{{$product['name']}}" alt="{{$product['name']}}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add Pagination -->
                            <div class="mt-3"></div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
--}}
                        <div class="col-12" style="width: 100%;">
                            <div onclick="beforeImg()">
                                <i class="material-icons navigate-products" style="left:-10px;">navigate_before</i></div>
                            <div>
                                <ul class="swiper-product2" id="list-images">
                                    @foreach($product['images'] as $image )
                                        <li onclick="changeImg('{{asset($image['medium'])}}','{{asset($image['big'])}}','{{$product['name']}}',this)">
                                            <div class="card shadow-sm product-item" style="border-radius: 5px;overflow: hidden;min-height: 100%;">
                                                <img class="img-products" src="{{asset($image['small'])}}"
                                                     title="{{$product['name']}}" alt="{{$product['name']}}">
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div onclick="nextImg()">
                                <i class="material-icons navigate-products" style="left:auto;right:-15px;">navigate_next</i></div>
                        </div>
                    </div>
                    <div class="col-md-7 mt-2 p-3">
                        <h2 class="py-1 description-product">{{$product['description']}}</h2>
                        @if($product['stock'])
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    @if( ($product['oldPrice']) && $product['stock'])
                                        <h3 class="old-price text-muted">{{$product['oldPrice'] }}</h3>
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
                                    @if(($product['inventory'] > 0) && $product['stock'])
                                    <a onclick="verifyAddCartProduct('{{$product['productType']}}','{{$product['brand']}}','{{$product['mpn']}}', 1, 'mercado')" class="btn btn-block btn-modal-mercado" href="javascript: void(0)"
                                       style="background-color: #c7c7c7">¡Compra con Mensualidades!
                                        <img src="{{asset("assets/images/bancos/mercadopago.png")}}" title="Pagar MergadoPago" alt="Pagar MercadoPago">
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
                                <a class="btn btn-secondary my-2 justify-content-center" target="_blank"
                                   href="{{route('spare', $linkSpare)}}">
                                    <span class="material-icons" style="font-size: 19px"> settings </span>
                                    Guía de refacciones
                                </a>
                            @endif
                        </div>
                        <div style="width: 400px !important;">
                            <div class="detail"></div>{{--Muestra el zoom--}}
                        </div>
                    </div>
                </div>

                <div class="row card shadow">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link text-muted active" data-toggle="tab" href="#fichTecnica">Ficha técnica</a>
                        </li>
                        {{--                        <li class="nav-item">--}}
                        {{--                            <a class="nav-link text-muted" data-toggle="tab" href="#formDudas">Dudas y comentarios</a>--}}
                        {{--                        </li>--}}
                    </ul>
                    <div class="tab-content">
                        <div id="fichTecnica" class="container tab-pane active">
                            <div class="m-2">
                                {!! $product['dataSheet'] !!}
                            </div>
                        </div>
                        {{--    <div id="formDudas" class="container tab-pane fade"><br>
                                <div id="div-formulario">
                                <h5>Dejanos tus datos para que un asesor te contacte.</h5>
                                <div class="divider mb-2"></div>
                                <form id="formularioDudas" action="javascript:void(0)">
                                    {{ csrf_field() }}
                                    <div class="row p-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="nombre">Nombre completo*:</label>
                                                <input type="text" class="form-control" name="nombre" placeholder="Nombre completo*" id="nombre" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="email">Email*:</label>
                                                <input type="text" class="form-control" placeholder="Email*" id="email" name="email" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="telefono">Teléfono (10 digitos)*:</label>
                                                <input type="text" class="form-control" placeholder="Teléfono (10 digitos)*" id="telefono" name="telefono">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="whatsapp">Whatsapp:</label>
                                                <input type="text" class="form-control" placeholder="Whatsapp" id="whatsapp"  name="whatsapp">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="sr-only form-control-label" for="comentario">Comentarios</label>
                                                <textarea class="form-control" id="comentario" name="comentario" placeholder="Comentario" cols="2" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" id="producto" name="producto" value="{{$product['name']}}">
                                        <div class="col-md-2 offset-md-5 ">
                                            <button id="btnSubmit" type="submit" class="btn btn-warning btn-block">Enviar</button>
                                        </div>
                                    </div>
                                </form>
                                </div>
                                <div id="div-send">
                                    <div class="alert alert-success" role="alert">
                                        Gracias por compartir con nosotros, en breve nos comunicamos contigo.
                                    </div>
                                </div>
                            </div>--}}
                    </div>
                </div>
                @if(count($productsRelated))
                <div class="row mt-4">
                    <h3>Productos recomendados</h3>
                    <div class="divider"></div>
                    <!-- Swiper -->
                    <div class="swiper-container p-1">
                        <div class="swiper-wrapper">
                            @foreach($productsRelated as $related)
                                <div class="swiper-slide">
                                    <div class="card shadow-sm product-item" style="border-radius: 5px;overflow: hidden;">
                                        <a href="{{url($related['href'])}}">
                                            @if($related['discount'] == 'Oferta')
                                                <div class="ribbon ribbon-top-right" style="display: block;position: relative;z-index: 6"><span>Oferta</span></div>
                                            @endif
                                            <div class="product-image img-container" style="height: 145px;">
                                                <img style="max-width: 80%;max-height: 80%"
                                                     src="{{asset($related['images'][0]['small'])}}"
                                                     title="{{$related['name']}}" alt="{{$related['name']}}">
                                            </div>
                                            @if($related['newPriceFloat'] > 3000)
                                                <img class="free-delivery-recom" src="{{asset('assets/images/otros/gratis.png')}}"
                                                     title="Envío gratis Jardepot" alt="Envío gratis Jardepot">
                                            @endif
                                        </a>
                                        <a class="title text-truncate" data-toggle="tooltip" title="{{$related['name']}}">{{$related['name']}}</a>
                                        <div style="height: 18px">
                                            @if( ($related['oldPrice']) && $related['stock'])
                                                <h3 class="old-price-recom text-muted">{{$related['oldPrice'] }}</h3>
                                            @endif
                                        </div>
                                        <div style="height: 19px">
                                            @if($related['stock'])
                                                <h2 class="new-price-recom">{{$related['newPrice']}}</h2>
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
                <br>
                @include('components.infoCompra')
                @include('components.caruselCanales')
            </div>
            <div class="card shadow-lg col-lg-2 col-md-12" style="height: 500px;">
                <br>
                <div class="pl-1">
                    <a class="h4" href="tel:8002129225" style="color: #1b1e21">
                        <i class="material-icons iconMod">local_phone</i>800 212 9225
                    </a>
                    <p class="h6">Llame ó llene con su información para que un asesor le contacte.</p>
                    <div class="divider mb-2"></div>
                    <form id="formularioDudas" action="javascript:void(0)">
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
    <script type="text/javascript" src="{{asset('assets/js/pages/product.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/pages/cart.min.js')}}"></script>

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
                    slidesPerView: 5,
                    spaceBetween: 20,
                    slidesPerGroup: 5,
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
                "price": {{isset($product['price'])?$product['price']:null}},
                "priceCurrency": "MXN"
            },
        }
    </script>
@endsection
