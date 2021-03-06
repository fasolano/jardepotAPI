{{--Vista escritorio--}}
<style>
    .icon_ofertas{
        background-image: url('/assets/images/icons/header_ofertas.png');
        background-size: cover;
        width: 40px !important;
        height: 40px !important;
        transition: all 0.3s ease-in-out;
    }
    .icon_ofertas:hover{
        background-image: url('/assets/images/icons/header_ofertas_alt.png');
        background-size: cover;
        width: 40px !important;
        height: 40px !important;
    }
    .icon_whatsapp{
        background-image: url('/assets/images/icons/header_whatsapp.png');
        background-size: cover;
        width: 40px !important;
        height: 40px !important;
        transition: all 0.3s ease-in-out;
    }
    .icon_whatsapp:hover{
        background-image: url('/assets/images/icons/header_whatsapp_alt.png');
        background-size: cover;
        width: 40px !important;
        height: 40px !important;
    }
    .icon_refacciones{
        background-image: url('/assets/images/icons/header_refacciones.png');
        background-size: cover;
        width: 40px !important;
        height: 40px !important;
        transition: all 0.3s ease-in-out;
    }
    .icon_refacciones:hover{
        background-image: url('/assets/images/icons/header_refacciones_alt.png');
        background-size: cover;
        width: 40px !important;
        height: 40px !important;
    }
    .icon_carrito{
        background-image: url('/assets/images/icons/header_carrito.png');
        background-size: cover;
        width: 40px !important;
        height: 46px !important;
        transition: all 0.3s ease-in-out;
    }
    .icon_carrito:hover{
        background-image: url('/assets/images/icons/header_carrito_alt.png');
        background-size: cover;
        width: 40px !important;
        height: 46px !important;
    }
    @media (min-width: 1500px){
        .ml-xxl-1{
            margin-left: .25rem !important;
        }
    }
    @media (max-width: 1260px){
        .ml-xxs-n1{
            margin-left: -.25rem !important;
        }
        .ml-xxs-n2{
            margin-left: -.5rem !important;
        }
        .ml-xxs-n3{
            margin-left: -.75rem !important;
        }
        .ml-xxs-1{
            margin-left: .25rem !important;
        }
        .ml-xxs-2{
            margin-left: .5rem !important;
        }
        .ml-xxs-3{
            margin-left: .75rem !important;
        }
    }
</style>
<div class="sticky-top">
    <nav class="navbar-dark bg-dark container-fluid d-none d-md-none d-lg-block">
        <div class="row justify-content-md-center flex-column align-items-center">
            <div class="div-navbar row" style="height: 82px;">
                <div class="col-md-1 col-sm-12 mr-3">
                    <div style="color: #fff;background-color: #e76a27;" class="h-100 w-100 mx-auto px-lg-n2">
                        <a style="cursor: pointer;" data-toggle="modal" data-target="#modalTelefonos" class="mx-lg-3">
                            <i class="material-icons my-3" style="font-size: 45px">add_ic_call</i>
                        </a>
                    </div>
                        {{-- <div class="col-md-6">
                            <div style="position: fixed;margin-left: 28px;margin-top: 20px !important;">
                                @if(isset($product['name']))
                                <img style="width: 60px;height: 60px; cursor: pointer;" onclick="return gtag_report_conversion('https://wa.me/525551857805?text=Hola,%20me%20gustaría%20saber%20sobre%20{{ urlencode($product['name']) }}')"
                                @else
                                <img style="width: 60px;height: 60px; cursor: pointer;" onclick="return gtag_report_conversion('https://wa.me/525551857805?text=Hola,%20me%20gustaría%20saber%20')"
                                @endif
                                    src="{{asset('assets/images/icons/whatsapp.png')}}"
                                title="WhatsApp"alt="WhatsApp">
                            </div>
                        </div> </div>--}}
                </div>
                <div class="col-md-11 ml-lg-n5">
                    <div class="row my-2">
                        <div class="col-md-2 mt-2" style="padding: 0; line-height:25px;">
                            <div class="text-barra-2 text-center" style="font-size: 22px;">
                                Llámanos al<br/>
                                <a href="tel:8002129225" style="font-size: 22px !important;">
                                    800 212 9225
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2 mt-2 ml-md-n1" style="padding-right: 0;padding-left: 5px; line-height:25px;">
                            <div class="text-barra text-center" style="font-size: 20px;">
                                EDOMX <br><a href="tel:7226481040" style="font-size: 22px !important;">
                                    722 648 1040
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2 mt-2 ml-md-n1" style="padding: 0; line-height:25px;">
                            <div class="text-barra text-center" style="font-size: 20px;">
                                CDMX <br><a href="tel:5549968849" style="font-size: 22px !important;">
                                    55 4996 8849
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2 mt-2 ml-md-n1" style="padding: 0; line-height:25px;">
                            <div class="text-barra text-center" style="font-size: 20px;">
                                GDL<br>
                                <a href="tel:3317283353" style="font-size: 22px !important;">
                                    33 1728 3353
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2 mt-2 ml-md-n1" style="padding: 0; line-height:25px;">
                            <div class="text-barra text-center" style="font-size: 20px;">
                                MTY<br> <a href="tel:8120635708" style="font-size: 22px !important;">
                                    81 2063 5708
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2 mt-2 ml-md-n1" style="padding: 0; line-height:25px;">
                            <div class="text-barra text-center" style="font-size: 20px;">
                                Mayoreo<br> <a href="tel:5544598506" style="font-size: 22px !important;">
                                    55 4459 8506
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-xl" style="height: 82px !important">
            <div class="container ">
                <div class="row">
                    <div class="col-md-1 my-3 ml-xl-1 mr-lg-n4 ml-md-n3 pr-md-n3 ml-xxs-n3">
                        <i style="color: #ffffff; font-size: 50px; cursor:pointer;" id="toggle-navbar" class="material-icons d-flex">menu</i>
                    </div>
                    <div class="col-md-2 my-3 mr-n3 ml-n3 ml-xxs-1">
                        <a class="navbar-brand" href="{{url('/')}}" style="height: 50px">
                            <picture >
                                <source srcset="{{asset('img/logos/logoJardepot.webp')}}" type="image/webp">
                                <source srcset="{{asset('img/logos/logoJardepot.png')}}" type="image/png">
                                <img class="logo-navbar" style="height:100%;" src="{{asset('img/logos/logoJardepot.png')}}"
                                    alt="¡Tu equipo siempre contigo!" title="¡Tu equipo siempre contigo!">
                            </picture>

                            {{--   <img class="logo-navbar" style="width: 58px;margin-left: 20px" src="{{asset('assets/images/otros/calaberita.png')}}"
                                    alt="Imagen Temporada" title="Imagen Temporada">--}}
                        </a>
                    </div>
                    <div class="col-md-7 my-2 mr-n5 ml-xxs-3">
                        <div class="" id="navbarsExample06">
                            <form id="search-form" class="form-inline my-2 my-md-0 search-form">
                                <div class="input-group mb-3 mt-1" style="width: 95%">
                                    <input id="inputSearch" type="text" class="form-control inputSearch" placeholder="Busca tu producto..."
                                        aria-label="Busca tu producto" aria-describedby="Busca tu producto." style="height: 40px !important; margin-bottom:-10px !important;">
                                    <div class="input-group-append">
                                    <span class="input-group-addon">
                                        <button class="btn btnSearch" type="submit" id="" style="height: 40px !important"><i style="color: gray" class="material-icons d-flex">search</i></button></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{--<div class="col-md-2 d-flex justify-content-between align-items-center">
                        <a target="_blank" href="https://www.facebook.com/Jardepot">
                            <img src="{{asset("assets/images/icons/facebook_40x40.png")}}" alt="" style="width: 40px;">
                        </a>
                        <a target="_blank" href="https://www.instagram.com/jardepot_mexico/">
                            <img src="{{asset("assets/images/icons/instragram_40x40.png")}}" alt="" style="width: 40px;">
                        </a>
                        <a href="https://www.youtube.com/channel/UCym0cCHYeEDqs70RD7Zs2-g" target="_blank">
                            <img src="{{asset("assets/images/icons/youtube_40x40.png")}}" alt="" style="width: 40px;">
                        </a>
                    </div>--}}
                    <div class="col-md-3 mt-2 ml-md-n2 ml-xl-n4">
                        <button class="btn btn ml-4" role="button" style="padding: 0 0 0 0 !important; color: #FFF" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="icon_carrito" style="margin-bottom:-6px; margin-top:1px;" alt="Mostrar mi carrito" title="Mostrar mi carrito"></div>
                            {{-- <i class="material-icons d-flex" style="color: #f68600;font-size: 24px !important;">shopping_cart</i> --}}
                            <span class="cart-items-count" id="items-count-nav1">0</span>
                            <div style="font-size: 11px;" class="mt-2">Carrito</div>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton" style="width: 300px">
                            <div class="dropdown-item">
                                <span style="font-size: 15px" id="products-coun-nav1"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{url('cart')}}" class="text-muted">Ver carrito</a>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div id="items-card-nav1"></div>
                            <div class="dropdown-item" id="option-dropdown-cart1">
                                <div class="mt-1" style="flex-direction: row; box-sizing: border-box; display: flex; place-content: center space-between; align-items: center;">
                                    <button class="btn btn-secondary btn-lg btn-circle" onclick="removeAllProducts()" data-toggle="tooltip" title="Borrar todo">
                                        <i class="material-icons" >remove_shopping_cart</i>
                                    </button>
                                    <a class="btn btn-warning btn- btn-circle" href="{{url('cart')}}" data-toggle="tooltip" title="Pagar">
                                        <i class="material-icons">check</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @php
                            $producto = "";
                            if(isset($product['name'])){
                                $producto = urlencode(" " . $product['name']);
                            }
                        @endphp
                        <button class="btn ml-2 ml-xxs-1" role="button" style="color: #FFF;padding: 0 0 0 0 !important; margin-top:5px;" type="button" onclick="location.href='{{route('sales')}}'">
                            <div class="icon_ofertas mx-1" alt="¡Ver ofertas!" title="¡Ver ofertas!"></div>
                            <div style="font-size: 11px;" class="mt-1">¡Ofertas!</a></div>
                        </button>
                        <button class="btn ml-2 ml-xxs-1" role="button" style="color: #FFF;padding: 0 0 0 0 !important; margin-top:5px;" type="button" onclick="return gtag_report_conversion('https://wa.me/525551857805?text=Hola,%20me%20gustaría%20saber%20sobre%20{{ $producto }}')">
                            <div class="icon_whatsapp mx-1" alt="Asesoría" title="Asesoría"></div>
                            <div style="font-size: 11px;" class="mt-1">Asesoría</div>
                        </button>
                        <button class="btn ml-2 ml-xxs-1" role="button" style="color: #FFF;padding: 0 0 0 0 !important; margin-top:5px;" type="button" onclick="window.open('https://wa.me/527226481040?text=Hola,%20me%20gustaría%20saber%20sobre%20las%20refacciones%20de%20{{ $producto }}')">
                            <div class="icon_refacciones mx-2" alt="Refacciones" title="Refacciones"></div>
                            <div style="font-size: 11px;" class="mt-1">Refacciones</div>
                        </button>
                    </div>

                    {{-- <div class="col-md-1" style="margin-top: 5px">
                        <button class="btn dropdown-toggle" style="text-align:center;color: #FFF" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span style="color: #fff !important;cursor:pointer;font-size: 15px">
                                <i class="material-icons d-flex" style="color: #f68600;font-size: 24px !important;">perm_identity</i>
                                Mi club
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton" style="width: 300px">
                            <div class="dropdown-item">
                                <span style="font-size: 15px" ></span><a href="{{url('cuenta/login')}}" class="text-muted">Iniciar sesión</a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </nav>

    <nav id="menu-familias" class="navbar navbar-expand-lg navbar-light bg-light shadow-sm d-none d-md-none d-lg-block">
        <div class="container-xl">
            {{--        <a class="navbar-brand" href="#">Container XL</a>--}}
            <div class="collapse navbar-collapse row" id="navbarsDesktopL">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    {{--<ul class="navbar-nav mr-auto col-md-8 d-flex flex-wrap">
                        @foreach ($navbar as $key => $categoria1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown{{$key}}" data-toggle="dropdown"
                                   aria-expanded="false">{{$categoria1['nivel1']}}</a>
                                <div class="dropdown-menu" aria-labelledby="dropdown{{$key}}">
                                    @foreach($categoria1['nivel2'] as $categoria2)
                                        <a class="dropdown-item" href="{{url($categoria2['href'])}}">{{$categoria2['name']}}</a>
                                    @endforeach
                                </div>
                            </li>
                        @endforeach
                    </ul>--}}

{{--                    <ul class="navbar-nav mr-auto col-md-8 d-flex flex-wrap justify-content-center align-items-center" id="menu">--}}
                    <ul class="navbar-nav mr-auto col-md-12 d-flex flex-wrap justify-content-center align-items-center" id="menu">
                        @foreach ($navbar as $key => $categoria1)
                            <li class="nav-item dropdown mr-xl-4 ml-md-1 ml-xl-2 column-items ml-xxs-n1" id="prueba1" style="@if($key == 0){{ 'margin-left:-1.7rem;' }}@endif">
                                <a class="d-flex flex-wrap justify-content-center align-items-center" title="{{$categoria1['nivel1']}}"  href="javascript:;">
                                    {{$categoria1['nivel1']}}
                                </a>
                                @if(isset($categoria1['nivel2']))
                                <ul class="{{count($categoria1['nivel2']) > 10 ? 'column-navbar':''}} dropdown-menu">

                                    @foreach($categoria1['nivel2'] as $categoria2)
                                    <li class="dropdown-item"><a class="text-left text-muted" title="{{$categoria2['name']}}" href="{{url($categoria2['href'])}}">{{$categoria2['name']}}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

{{--                    <a class="mr-2 btn-sm d-flex" href="{{route('sales')}}"><img style="width: 100px;position: absolute;margin-left: -100px;margin-top: -15px" src="{{asset('assets/images/ofertas/promocion.png')}}" title="Ofertas Jardepot" alt="Ofertas Jardepot"></a>--}}
{{--                    <a class="mr-2 btn-sm d-flex" href="{{route('sales')}}" style="background-color: #f44336; color: white;"><i class="material-icons iconMod">attach_money</i>¡OFERTAS!</a>--}}
              {{--      <a onclick="return gtag_report_conversion('https://wa.me/525551857805?text=Hola,%20me%20gustaría%20saber%20')" style="color:#fff;" class="mr-2 btn-success btn-sm d-flex" rel="noopener">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                             focusable="false" width="20px" height="20px" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                             preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01z" fill="#fff"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" />
                        </svg>Whatsapp</a>
                    <a class="mr-2 btn-warning btn-sm d-flex" target="_blank" href="https://wa.me/527226481040?text=Hola,%20me%20gustaría%20saber%20sobre%20sus%20refacciones"
                       style="text-decoration: none;" rel="noopener"><i class="material-icons iconMod">settings</i>Refacciones</a>--}}

                    {{--            BOTON DE NAVBAR--}}
                    {{--<div class="mr-2 bg-dark btn-sm d-flex position-relative" style="text-decoration: none;" rel="noopener">
                        <button class="btn dropdown-toggle py-0 position-relative" style="color: #FFF" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex justify-content-center align-items-center position-relative" style="color: #fff !important;cursor:pointer;font-size: 15px">
                            <i class="material-icons d-flex" style="color: #f68600;font-size: 22px !important;">shopping_cart</i>
                            <span class="cart-items-count" id="items-count-nav1">0</span> Carrito
                        </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-right" aria-labelledby="dropdownMenuButton" style="width: 300px">
                            <div class="dropdown-item">
                                <span style="font-size: 15px" id="products-coun-nav1"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{url('cart')}}" class="text-muted">Ver carrito</a>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div id="items-card-nav1"></div>
                            <div class="dropdown-item" id="option-dropdown-cart1">
                                <div class="mt-1" style="flex-direction: row; box-sizing: border-box; display: flex; place-content: center space-between; align-items: center;">
                                    <button class="btn btn-secondary btn-lg btn-circle" onclick="removeAllProducts()" data-toggle="tooltip" title="Borrar todo">
                                        <i class="material-icons" >remove_shopping_cart</i>
                                    </button>
                                    <a class="btn btn-warning btn- btn-circle" href="{{url('cart')}}" data-toggle="tooltip" title="Pagar">
                                        <i class="material-icons">check</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                </div>


            </div>
        </div>
    </nav>
</div>

{{--Vista Movil --}}
<nav class="navbar navbar-dark sticky-top bg-dark  d-block d-sm-block d-lg-none" style="background-color: #3d3c3b !important;">
    <div class="div-navbar-movil">
        <div class="row" style="width: 100%">
            <div class="col-10">
                <div class="text-left">
                    <a data-toggle="modal" data-target="#modalTelefonos">
                        <i class="material-icons">call</i>Más Teléfonos<i class="material-icons">keyboard_arrow_down</i>
                    </a>
                </div>
            </div>
            <div class="col-2 text-right">
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsMovil"
                        aria-controls="navbarsMovil" aria-expanded="false" aria-label="Toggle navigation" style="border-color: transparent">
                    <i class="material-icons">menu</i>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <a class="navbar-brand" href="{{url('/')}}">
                <picture>
                    <source srcset="{{asset('img/logos/logoJardepot.webp')}}" type="image/webp">
                    <source srcset="{{asset('img/logos/logoJardepot.png')}}" type="image/png">
                    <img class="logo-navbar" style="width: 60%" src="{{asset('img/logos/logoJardepot.png')}}"
                         alt="Logo Jardepot" title="Logo Jardepot">
                </picture>
                {{--<img class="logo-navbar" style="width: 40px" src="{{asset('assets/images/otros/calaberita.png')}}"
                     alt="Imagen Temporada title="Imagen Temporada">--}}
            </a>
        </div>
        <div class="col-4" style="margin-top: 1px">
            <button class="btn dropdown-toggle" style="color: #FFF" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span style="color: #fff !important;cursor:pointer;">
                    <i class="material-icons" style="color: #f68600;font-size: 28px !important;">shopping_cart</i>
                    <span class="cart-items-count" id="items-count-nav2"></span>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton" style="width: 300px">
                <div class="dropdown-item">
                    <span style="font-size: 15px" id="products-coun-nav2"></span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{url('cart')}}" class="text-muted">Ver carrito</a>
                </div>
                <div class="dropdown-divider"></div>
                <div id="items-card-nav2"></div>

                <div class="dropdown-item" id="option-dropdown-cart2">
                    <div class="mt-1" style="flex-direction: row; box-sizing: border-box; display: flex; place-content: center space-between; align-items: center;">
                        <button class="btn btn-secondary btn-lg btn-circle" onclick="removeAllProducts()" data-toggle="tooltip"  title="Borrar todo">
                            <i class="material-icons">remove_shopping_cart</i>
                        </button>
                        <a class="btn btn-warning btn- btn-circle" href="{{url('cart')}}" data-toggle="tooltip" title="Pagar">
                            <i class="material-icons">check</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar-collapse collapse" id="navbarsMovil">
        <ul class="navbar-nav mr-auto">
            @foreach ($navbar as $categoria1)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown{{$key}}" data-toggle="dropdown"
                       aria-expanded="false">{{$categoria1['nivel1']}}</a>
                    @if(isset($categoria1['nivel2']))
                    <div class="dropdown-menu {{count($categoria1['nivel2']) > 10 ? 'column-navbar':''}} " aria-labelledby="dropdown{{$key}}">
                        @foreach($categoria1['nivel2'] as $categoria2)
                            <a class="dropdown-item" href="{{url($categoria2['href'])}}">{{$categoria2['name']}}</a>
                        @endforeach
                    </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    <div class="navbar-collapse">
        <form class="form-inline my-2 my-md-0 search-form">
            <div class="input-group" style="width: 95%;margin-top: 0">
                <input type="text" class="form-control inputSearch" placeholder="Busca tu producto..."
                       aria-label="Busca tu producto" aria-describedby="Busca tu producto..." style="margin-top: 0">
                <div class="input-group-append">
                    <span class="input-group-addon">
                        <button class="btn btnSearch" type="submit" id="" style="margin-top: 0">
                            <i style="color: gray" class="material-icons d-flex">search</i>
                        </button>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-12">
            @if(isset($product['name']))
            <a class="mr-2 btn-success btn-sm d-flex" onclick="return gtag_report_conversion('https://wa.me/525551857805?text=Hola,%20me%20gustaría%20saber%20sobre%20{{ urlencode($product['name']) }}')"
            @else
            <a class="mr-2 btn-success btn-sm d-flex" onclick="return gtag_report_conversion('https://wa.me/525551857805?text=Hola,%20me%20gustaría%20saber%20')"
            @endif
               style="text-decoration: none; color: #fff;" rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                     focusable="false" width="20px" height="20px" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                     preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01z" fill="#fff"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" />
                </svg>Whatsapp</a>
        </div>
        <div class="col-12 mt-2">
            <a class="mr-2 btn-warning btn-sm d-flex" href="tel:8002129225"
               style="text-decoration: none;"><i class="material-icons iconMod">call</i>Llámanos</a>
        </div>
    </div>
</nav>

{{--<nav class="navbar navbar-light bg-light  d-block d-sm-block d-lg-none">
    <div class="row">
        <div class="col-6">
            <a class="mr-2 btn-success btn-sm d-flex" target="_blank" href="https://wa.me/525551857805?text=Hola,%20me%20gustaría%20saber%20" style="text-decoration: none;"  rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                     focusable="false" width="20px" height="20px" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                     preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01z" fill="#fff"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" />
                </svg>Whatsapp</a>
        </div>
        <div class="col-6">
            <a class="mr-2 btn-warning btn-sm d-flex" href="tel:8002129225"
               style="text-decoration: none;"><i class="material-icons iconMod">call</i>Llámanos</a>
        </div>
    </div>
</nav>--}}

<!-- Modal Teléfonos-->
<div class="modal fade" id="modalTelefonos" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
     aria-labelledby="modalTelefonosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTelefonosLabel">LLámanos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div style="padding: 0;" class="col-12 col-md-3">
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;font-size: 20px">Del Interior</p>
                                <a href="tel:8002129225" class="telModal" ><span class="my-4" style="font-size: 20px; font-weight: 500;"><i class="material-icons">call</i>800 212 9225</span></a>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px; font-size: 20px">Mayoreo</p>
                                <a href="tel:5544598506" class="telModal"><span class="my-4" style="font-size: 20px; font-weight: 500;"><i class="material-icons">call</i>55 4459 8506</span></a>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px; font-size: 20px">Refacciones</p>
                                <a href="tel:7226481040" class="telModal"><span class="my-4" style="font-size: 20px; font-weight: 500;"><i class="material-icons">call</i>722 648 1040</span></a>
                            </div>
                        </div>
                        <div style="padding: 0;" class="col-12 col-md-2">
                            <div style="margin-bottom: 20px;">
                                <p>CDMX</p>
                                <a href="tel:5549968849" class="telModal" ><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>55 4996 8849</span></a><br>
                                <a href="tel:5549974360" class="telModal" ><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>55 4997 4360</span></a><br>
                                <a href="tel:5551857805" class="telModal" ><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>55 5185 7805</span></a><br>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">Querétaro</p>
                                <a href="tel:4423960365" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>442 396 0365</span></a><br>
                                <a href="tel:4421239272" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>442 123 9272</span></a><br>
                            </div>
                        </div>
                        <div style="padding: 0;" class="col-12 col-md-2">
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">Guadalajara</p>
                                <a href="tel:3317283353" class="telModal" ><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>33 1728 3353</span></a><br>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <p>Morelos</p>
                                <a href="tel:7773179630" class="telModal"><span style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>777 317 9630</span></a><br>
                                <a href="tel:7773179652" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>777 317 9652</span></a><br>
                                <a href="tel:7773645067" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>777 364 5067</span></a><br>
                                <a href="tel:7773645635" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>777 364 5635</span></a><br>
                            </div>
                        </div>
                        <div style="padding: 0;" class="col-12 col-md-2">
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">Nuevo León</p>
                                <a href="tel:8120635708" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>81 2063 5708</span></a><br>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">Edo. Mex.</p>
                                <a href="tel:7226481040" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>722 648 1040</span></a><br>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">Michoacán</p>
                                <a href="tel:4433560484" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>443 356 0484</span></a><br>
                            </div>
                        </div>
                        <div style="padding: 0;" class="col-12 col-md-2">
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">Puebla</p>
                                <a href="tel:2227051726" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>222 705 1726</span></a><br>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">Veracruz</p>
                                <a href="tel:2293300992" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>229 330 0992</span></a><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTelefonosLabel2">Atención a Comercializadoras y Mayoristas</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div style="padding: 0;" class="row">
                            <div class="col-md-12">
                                <a class="telModal" href="tel:5544598506"><i class="material-icons">call</i> 55 4459 8506</a>
                            </div>
                        </div>
                        <hr>
                        <div style="padding: 0;" class="row">
                            <div class="col-md-1"><i class="material-icons">email</i></div>
                            <div class="col-md-4">
                                 <a href="mailto:mayoreo@jardepot.com" class="telModal">mayoreo@jardepot.com</a>
                            </div>
                            <div class="col-md-3">
                                <a href="mailto:ventas@jardepot.com" class="telModal">ventas@jardepot.com</a>
                            </div>
                            <div class="col-md-4">
                                <a href="mailto:refacciones@jardepot.com" class="telModal">refacciones@jardepot.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '#toggle-navbar', function(){
        if($("#menu-familias").hasClass('d-lg-block')){
            $("#menu-familias").removeClass('d-lg-block')
        } else {
            $("#menu-familias").addClass('d-lg-block')
        }
    })
</script>
