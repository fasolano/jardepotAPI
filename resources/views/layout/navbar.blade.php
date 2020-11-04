{{--Vista escritorio--}}
<nav class="sticky-top navbar-dark bg-dark container-fluid d-none  d-md-none  d-lg-block">
    <div class="row justify-content-md-center flex-column align-items-center">
        <div class="div-navbar col-12 col-xl-12 col-lg-12 col-md-12">
            <div class="row" style="color: white;">
{{--                <div class="col-3 d-none d-sm-none d-md-block">--}}
                <div class="col-2 d-none d-sm-none d-md-block">
                    <div class="col-12">
                        <div class="text-barra text-left">
                            Llámanos al:<br>
                            <a href="tel:8002129225">
                                <i class="material-icons iconMod">local_phone</i>800 212 9225
                            </a>
                        </div>
                    </div>
                </div>
{{--                <div class="col-8 d-flex">--}}
                <div class="col-7 d-flex" style="padding-right: 0">
                    <div class="row">
                        <div class="col-3">
                            <div class="text-barra text-left">
                                CDMX <br><a href="tel:5549968849"><i class="material-icons iconMod">call</i>55 4996 8849</a>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-barra text-left">
                                GDL<br>
                                <a href="tel:3317283353"><i class="material-icons iconMod">call</i>33 1728 3353</a>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-barra text-left">
{{--                                EDOMX<br>--}}
{{--                                <a href="tel:7226481040"><i class="material-icons iconMod">call</i>722 648 1040</a>    --}}
                                Monterrey<br>
                                <a href="tel:8120635708"><i class="material-icons iconMod">call</i>81 2063 5708</a>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="text-barra text-left">
                                Mayoreo<br>
                                <a href="tel:5544598506"><i class="material-icons iconMod">call</i>55 4459 8506</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2" style="padding: 0"> {{--Esto se quita despues y las otras cols--}}
                </div>
                <div class="col-1" style="font-size: 35px;cursor:pointer;">
                    <a data-toggle="modal" data-target="#modalTelefonos">
                        <i class="material-icons">add_ic_call <i class="material-icons iconMod">keyboard_arrow_down</i></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xl">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <picture>
                            <source srcset="{{asset('img/logos/logoJardepot.webp')}}" type="image/webp">
                            <source srcset="{{asset('img/logos/logoJardepot.png')}}" type="image/png">
                            <img class="logo-navbar" style="width: 80%" src="{{asset('img/logos/logoJardepot.png')}}"
                                 alt="Logo Jardepot" title="Logo Jardepot">
                        </picture>

                        <img class="logo-navbar" style="width: 58px;margin-left: 20px" src="{{asset('assets/images/otros/calaberita.png')}}"
                             alt="Moño rosa" title="Moño rosa">
                    </a>
                </div>
                <div class="col-md-7">
                    <div class="" id="navbarsExample06">
                        <form id="search-form" class="form-inline my-2 my-md-0 search-form">
                            <div class="input-group mb-3" style="width: 100%">
                                <input id="inputSearch" type="text" class="form-control inputSearch" placeholder="Busca tu producto..."
                                       aria-label="Busca tu producto" aria-describedby="Busca tu producto.">
                                <div class="input-group-append">
                                    <span class="input-group-addon">
                                        <button class="btn btnSearch" type="submit" id=""><i style="color: gray" class="material-icons d-flex">search</i></button></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 5px">
                    <button class="btn dropdown-toggle" style="color: #FFF" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span style="color: #fff !important;cursor:pointer;font-size: 15px">
                        <i class="material-icons d-flex" style="color: #f68600;font-size: 24px !important;">shopping_cart</i>
                            <span class="cart-items-count" id="items-count-nav1">0</span> Carrito de compras</span>
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
                </div>
            </div>
        </div>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm d-none d-md-none  d-lg-block">
    <div class="container-xl">
        {{--        <a class="navbar-brand" href="#">Container XL</a>--}}
        <div class="collapse navbar-collapse" id="navbarsDesktopL">
            <ul class="navbar-nav mr-auto">
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
            </ul>
            <a class="mr-2 btn btn-danger btn-sm d-flex" href="{{route('sales')}}"><i class="material-icons iconMod">attach_money</i>Ofertas</a>
            <a class="mr-2 btn-success btn-sm d-flex" target="_blank" href="https://wa.me/525551857805?text=Hola,%20me%20gustaría%20saber%20" style="text-decoration: none;" rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                     focusable="false" width="20px" height="20px" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                     preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01z" fill="#fff"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" />
                </svg>Whatsapp</a>
            <a class="mr-2 btn-warning btn-sm d-flex" target="_blank" href="https://wa.me/527226481040?text=Hola,%20me%20gustaría%20saber%20sobre%20sus%20refacciones"
               style="text-decoration: none;" rel="noopener"><i class="material-icons iconMod">settings</i>Refacciones</a>
        </div>
    </div>
</nav>

{{--Vista Movil --}}
<nav class="navbar navbar-dark sticky-top bg-dark  d-block d-sm-block d-lg-none">
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
                    <img class="logo-navbar" style="width: 80%" src="{{asset('img/logos/logoJardepot.png')}}"
                         alt="Logo Jardepot" title="Logo Jardepot">
                </picture>
                <img class="logo-navbar" style="width: 40px" src="{{asset('assets/images/otros/calaberita.png')}}"
                     alt="Moño rosa" title="Moño rosa">
            </a>
        </div>
        <div class="col-4" style="margin-top: 8px">
            <button class="btn dropdown-toggle" style="color: #FFF" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span style="color: #fff !important;cursor:pointer;">
                    <i class="material-icons" style="color: #f68600;font-size: 30px !important;">shopping_cart</i>
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
                    <div class="dropdown-menu" aria-labelledby="dropdown{{$key}}">
                        @foreach($categoria1['nivel2'] as $categoria2)
                            <a class="dropdown-item" href="{{url($categoria2['href'])}}">{{$categoria2['name']}}</a>
                        @endforeach
                    </div>
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
</nav>

<nav class="navbar navbar-light bg-light  d-block d-sm-block d-lg-none">
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
</nav>

<!-- Modal Teléfonos-->
<div class="modal fade" id="modalTelefonos" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
     aria-labelledby="modalTelefonosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTelefonosLabel">Nuestros números teléfonicos</h5>
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
                        </div>
                        <div style="padding: 0;" class="col-12 col-md-2">
                            <div style="margin-bottom: 20px;">
                                <p>CDMX</p>
                                <a href="tel:5549968849" class="telModal" ><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>55 4996 8849</span></a><br>
                                <a href="tel:5549974360" class="telModal" ><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>55 4997 4360</span></a><br>
                                <a href="tel:5576181056" class="telModal" ><span style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>55 7618 1056</span></a><br>
                                <a href="tel:5551857805" class="telModal" ><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>55 5185 7805</span></a><br>
                            </div>
                        </div>
                        <div style="padding: 0;" class="col-12 col-md-2">
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
                                <p style="margin-bottom: 0px;">Estado de México</p>
                                <a href="tel:7226481040" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>722 648 1040</span></a><br>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">Michoacán</p>
                                <a href="tel:4433560484" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>443 356 0484</span></a><br>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">Guadalajara</p>
                                <a href="tel:3317283353" class="telModal" ><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>33 1728 3353</span></a><br>
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
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">S.L.P.</p>
                                <a href="tel:4443280420" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>444 328 0420</span></a><br>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <p style="margin-bottom: 0px;">Q. Roo</p>
                                <a href="tel:9982940670" class="telModal"><span class="my-4" style="font-size: 15px; font-weight: 300;"><i class="material-icons">call</i>998 294 0670</span></a><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTelefonosLabel2">Atención a Comercializadoras y Mayoristas</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <a class="telModal" href="tel:5544598506"><i class="material-icons">call</i> 55 4459 8506</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
