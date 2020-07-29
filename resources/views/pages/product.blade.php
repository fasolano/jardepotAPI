@extends('pages')


@section('metaData')
    <title>Products</title>
    {{--<meta title="{{ ucfirst($titleweb)}}"/>
    <meta name="description" content="{{$metadesc}}">
    <meta name="keywords" content="{{$keywords}}">--}}
@endsection

@section('specificCSS')
    <link rel="stylesheet" href="{{asset('assets/css/components/sidebar.css')}}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/jquery.mCustomScrollbar.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/product.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/swiper.css')}}">

@endsection

@section('content')
    @component('components.breadcrumb')
    @endcomponent
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="material-icons fn-color-jd mr-2">close</i>
            </div>
            @component('components.sidebar')
                @slot('id', 'Movil')
            @endcomponent
        </nav>
        <!-- Page Content  -->
        <div id="content" class="row">
            <div class="card d-none d-lg-block col-lg-3 mr-3" style="max-width: 23%">
                @component('components.sidebar')
                    @slot('id', 'Desktop')
                @endcomponent
            </div>

            <div class="col-lg-9 col-md-12">
                <h1 class="title-product">Desbrozadora Kawashima DKM43K</h1>
                <div class="row">
                    <div class="col-md-5 mt-2">
                        <div class="card shadow-sm" style="overflow: hidden;">
                            <div class="ribbon ribbon-top-right" style="display: block"><span>Oferta</span></div>
                            <div class="product-image">
                                <img style="max-width: 100%"
                                     src="{{asset('assets/images/productos/desbrozadora-kawashima-dkm43k.jpg')}}"
                                     title="" alt="">
                            </div>
                            <img class="free-delivery" src="{{asset('assets/images/otros/gratis.png')}}"
                                 title="Envío gratis Jardepot" alt="Envío gratis Jardepot">
                        </div>
                    </div>
                    <div class="col-md-7 mt-2 p-3">
                        <h2 class="py-1 description-product"> Esta desbrozadora Kawashima Montana
                            43cc le entrega potencia con un consumo eficiente de combustible para mantener sus
                            áreas verdes en óptimas condiciones. Este equipo cuenta con garantía y refacciones
                            disponibles.</h2>
                        <h3 class="old-price text-muted">$39,450.00</h3>
                        <h1 class="new-price"><span class="precio" style="color: #de1f21;"> $34,450.00 </span><span
                                class="text-bold-tiny"> IVA incluido</span></h1>
                        <div class="py-1 lh"><p class="fn-color-inStock "><i class="material-icons">flash_on</i>&nbsp;Envío
                                de volada </p></div>

                        <div class="row text-muted p-1"
                             style="flex-flow: row wrap; box-sizing: border-box; display: flex; place-content: flex-start; align-items: flex-start;">
                            <!---->
                            <div class="col-md-6">
                                <span>Cantidad:</span>
                                <br>
                                <button class="btn">
                                    <i class="material-icons">remove</i>
                                </button>
                                <span> 1 </span>
                                <button class="btn">
                                    <i class="material-icons">add</i>
                                </button>
                            </div>
                            <div class="col-md-6 mt-2">
                                <button class="btn btn-danger">
                                    Agregar al carrito
                                </button>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div style="font-weight: bold !important;">
                            <p class="conditons"><i class="material-icons" style="color: #f68600;font-size: 18px">local_shipping</i>
                                Envio gratis a partir de $3,000 de compra. <a href="javascript: void(0)"
                                                                              style="color: rgba(0, 0, 0, 0.87);">*Condiciones</a>
                            </p>
                            <p class="conditons"><i class="material-icons" style="color: #f68600;font-size: 18px">perm_phone_msg</i>
                                Soporte y asesoria </p>
                            <p class="conditons">
                                <i class="material-icons" style="color: #f68600;font-size: 18px">build</i> Garantía de Fabrica
                            </p>
                            <p class="conditons">
                                *Sujeto a existencias. <br> *Precios sujetos a cambio sin previo aviso.
                            </p>
                        </div>
                        <br>
                        <div class="">
                            <a class="btn btn-success" style="background: #35B73A;color: #fff" target="_blank"
                               href="https://wa.me/527226481040?text=Hola,%20me%20gustaría%20saber%20sobre%20las%20refacciones%20del%20producto%20Triturador BCS BIO-80"
                               tabindex="0" aria-disabled="false">
                                <span>
                                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                           aria-hidden="true" focusable="false" width="20px" height="20px"
                                           style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                                           preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path
                                              d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01z"
                                              fill="#fff"/><rect x="0" y="0" width="24" height="24"
                                                                 fill="rgba(0, 0, 0, 0)"/>
                                      </svg> Pregunta por refacciones
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row card shadow">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link text-muted active" data-toggle="tab" href="#fichTecnica">Ficha técnica</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted" data-toggle="tab" href="#formDudas">Dudas y comentarios</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="fichTecnica" class="container tab-pane active"><br>
                            {{--                            esto se quita--}}
                            <div>
                                <p style="color: black !important;">
                                <p><span style="font-weight: bold;">Especificaciones de la desbrozadora Kawashima&nbsp; DKM43A.</span>
                                </p>
                                <p class="MsoNormal">Motor: 43 cc
                                    <o:p></o:p>
                                </p>
                                <p class="MsoNormal">Tipo: 2 tiempos
                                    <o:p></o:p>
                                </p>
                                <p class="MsoNormal">Tanque: 850 ml.
                                    <o:p></o:p>
                                </p>
                                <p class="MsoNormal">Tubo: Recto
                                    <o:p></o:p>
                                </p>
                                <p class="MsoNormal">Velocidad mantenida: 3100 ± 400 (r/min)
                                    <o:p></o:p>
                                </p>
                                <p class="MsoNormal">Maneral: Tipo “D”
                                    <o:p></o:p>
                                </p>
                                <p class="MsoNormal">Tubo: 28 mm.
                                    <o:p></o:p>
                                </p>
                                <p>
                                </p>
                                <p class="MsoNormal">Incluye arnés y cabezal automático de Nylon cuchilla tipo 2
                                    puntas, guarda protectora, bote de mezclado.
                                    <o:p></o:p>
                                </p>
                                </p>
                            </div>
                            {{--                            fin esto se quita--}}
                        </div>
                        <div id="formDudas" class="container tab-pane fade"><br>
                            <h5>Dejanos tus datos para que un asesor te contacte.</h5>
                            <div class="divider mb-2"></div>
                            <form class="needs-validation" novalidate>
                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="sr-only" for="nombre">Nombre completo*:</label>
                                            <input type="text" class="form-control" placeholder="Nombre completo*" id="nombre">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="sr-only" for="email">Email*:</label>
                                            <input type="email" class="form-control" placeholder="Email*" id="email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="sr-only" for="telefono">Teléfono (10 digitos)*:</label>
                                            <input type="text" class="form-control" placeholder="Teléfono (10 digitos)*" id="telefono" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="sr-only" for="whatsapp">Whatsapp:</label>
                                            <input type="text" class="form-control" placeholder="Whatsapp" id="whatsapp">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="sr-only" for="comentarios">Comentarios</label>
                                            <textarea class="form-control" id="comentarios" placeholder="Comentarios" cols="2" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-2 offset-md-5 ">
                                        <button type="submit" class="btn btn-warning btn-block">Enviar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <h3>Productos recomendados</h3>
                    <div class="divider"></div>
                    <!-- Swiper -->
                    <div class="swiper-container p-1">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="card shadow-sm product-item" style="border-radius: 5px;overflow: hidden;">
                                    <a href="">
                                        <div class="ribbon ribbon-top-right" style="display: block"><span>Oferta</span></div>
                                        <div class="product-image" style="height: 205px">
                                            <img style="max-width: 80%"
                                                 src="{{asset('assets/images/productos/desbrozadora-kawashima-dkm43k.jpg')}}"
                                                 title="" alt="">
                                        </div>
                                        <img class="free-delivery-recom" src="{{asset('assets/images/otros/gratis.png')}}"
                                             title="Envío gratis Jardepot" alt="Envío gratis Jardepot">
                                    </a>
                                    <a class="title text-truncate">Desbrozadora honda 4sdf</a>
                                    <h3 class="old-price-recom text-muted">$39,450.00</h3>
                                    <h2 class="new-price-recom">$34,450.00</h2>
                                    <div class="divider"></div>
                                    <button type="button" class="btn">
                                        <span style="font-size: 14px"><i class="material-icons fn-color-jd">shopping_cart</i>Agregar al carrito</span>
                                    </button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card shadow-sm product-item" style="border-radius: 5px">
                                    <a href="">
                                        <div class="" style="height: 205px">
                                            <img style="max-width: 80%"
                                                 src="{{asset('assets/images/productos/desbrozadora-kawashima-dkm43k.jpg')}}"
                                                 title="" alt="">
                                        </div>
                                    </a>
                                    <a class="title text-truncate">Desbrozadora honda 4sdf</a>
                                    <h3 class="old-price-recom text-muted">$39,450.00</h3>
                                    <h2 class="new-price-recom">$34,450.00</h2>
                                    <div class="divider"></div>
                                    <button type="button" class="btn">
                                        <span style="font-size: 14px"><i class="material-icons fn-color-jd">shopping_cart</i>Agregar al carrito</span>
                                    </button>
                                </div>
                            </div>
                            <div class="swiper-slide">Slide 3</div>
                            <div class="swiper-slide">Slide 4</div>
                            <div class="swiper-slide">Slide 5</div>
                            <div class="swiper-slide">Slide 6</div>
                            <div class="swiper-slide">Slide 7</div>
                            <div class="swiper-slide">Slide 8</div>
                        </div>
                        <!-- Add Pagination -->
                        <div class="mt-3"></div>
                        <div class="swiper-pagination" style="margin-bottom: -5px"></div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                </div>
                <br>
                @include('components.infoCompra')
                @include('components.caruselCanales')
            </div>
        </div>
    </div>
@endsection

@section('specificJS')
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <script src="{{asset('assets/js/components/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/sidebar.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/swiper.js')}}"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 4,
            spaceBetween: 20,
            slidesPerGroup: 4,
            loop: true,
            loopFillGroupWithBlank: true,
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 320px
                300: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    slidesPerGroup: 1,
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    slidesPerGroup: 1,
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
    </script>
@endsection
