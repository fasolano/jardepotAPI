@extends('pages')


@section('metaData')
    <title>{{ isset($descriptionLevel2->metatitle)?substr($descriptionLevel2->metatitle, 0,70):""}}</title>
    <meta title="{{ isset($descriptionLevel2->metatitle)?substr($descriptionLevel2->metatitle, 0,70):""}}"/>
    <meta name="description" content="{{isset($descriptionLevel2->metadescription)?$descriptionLevel2->metadescription:""}}">
    <meta name="keywords" content="{{isset($descriptionLevel2->keywords)?$descriptionLevel2->keywords:""}}">

    <meta property="og:title" content="{{ $descriptionLevel2->metatitle}}" />
    <meta property="og:description" content="{{ $descriptionLevel2->metadescription}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.jardepot.com/" />
    <meta property="og:image" content="{{asset('img/logos/logoOG.jpg')}}" />
    <meta property="og:image:url" content="{{asset('img/logos/logoOG.jpg')}}" />
    <meta property="og:image:secure_url" content="{{asset('img/logos/logoOG.jpg')}}" />
    <link rel="canonical" href="https://www.jardepot.com">
@endsection

@section('specificCSS')
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/pages/products.min.css')}}">
    <!-- Components CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/sidebar.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.min.css')}}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/jquery.mCustomScrollbar.min.css')}}">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('level1', $categoryLevel1)
        @slot('level2', $categoryLevel2)
    @endcomponent

    <div class="wrapper">
        <input id="level1" type="hidden" value="{{$categoryLevel1}}">
        <input id="level2" type="hidden" value="{{$categoryLevel2}}">
        <!-- Sidebar  -->
        <nav id="sidebar">
            @component('components.sidebar')
                @slot('id', 'Movil')
                @slot('sections', $sidebar)
                @if(isset($filters))
                    @slot('filters', $filters)
                    @slot('textFilter', $textFilter)
                @endif
                @if(isset($idFilter))
                    @slot('idFilter', $idFilter)
                @endif
                @slot('level1', $categoryLevel1)
                @slot('level2', $categoryLevel2)
            @endcomponent
        </nav>

        <!-- Page Content  -->
        <div id="content" class="row">
            <div class="border shadow bg-white rounded d-none d-lg-block col-lg-3 p-0" style="max-width: 21%">
                @component('components.sidebar')
                    @slot('id', 'Desktop')
                    @slot('sections', $sidebar)
                @if(isset($filters))
                    @slot('filters', $filters)
                    @slot('textFilter', $textFilter)
                @endif
                @if(isset($idFilter))
                    @slot('idFilter', $idFilter)
                @endif
                    @slot('level1', $categoryLevel1)
                    @slot('level2', $categoryLevel2)
                @endcomponent
            </div>

            <div id="content-products-principal" class="col-lg-10 col-md-12" style="">
                @if(isset($products))
                <div id="list-products-sections">
                    <div class="row border shadow bg-white rounded">
                        <h1 class="m-2 text-muted" style="font-size: 28px;">{{$categoryLevel2}}</h1>
                    </div>
                    <div class="row border shadow rounded bg-dark my-2 text-white px-2 d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <p>Ordenar por:</p>
                            <select id="orderBy" class="form-control">
                                <option value="default">Relevancia</option>
                                <option value="ASC">Menor Precio</option>
                                <option value="DESC">Mayor Precio</option>
                            </select>
                        </div>
                        <button type="button"
                                class="sidebarCollapse btn bg-color-jd btn-sm d-flex align-items-center justify-content-center d-lg-none d-flex">
                            <i class="material-icons mr-2">menu</i>
                            <span>Filtros y secciones</span>
                        </button>
                        <div class="row pagination-container">
                            <div class="col-12" style="border-radius: 5px;overflow: hidden;">
                                <nav aria-label="Search results products">
                                    <ul class="pagination d-flex justify-content-center align-items-center my-2">
                                        <li class="page-item previous-page disabled">
                                            <a class="page-link" data-val="--" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                                        </li>
                                        @for ($i = 0; $i < $numberPages; $i++)
                                            <li class="page-item number-page @if($i == 0) active @endif">
                                                <a class="page-link" data-val="{{ $i+1 }}" href="#">{{ $i+1 }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item next-page @if($numberPages <= 1) disabled @endif">
                                            <a class="page-link" data-val="++" href="#">Siguiente</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div>
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                   id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">

                                    Mostrar <span class="current-number-items">16</span>

                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item number-items" data-val="16" href="#" id="eight-products">16</a>
                                    <a class="dropdown-item number-items" data-val="20" href="#">20</a>
                                    <a class="dropdown-item number-items" data-val="24" href="#">24</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="cards-sections" class="row">
                        @foreach($products as $key => $item)
                            <div class="card shadow-sm product-item col-sm-6 col-md-4 col-lg-3 p-0 mt-2 @if($loop->iteration > 16) d-none  @endif"
                                style="border-radius: 5px;overflow: hidden;">
                                <a href="{{route('product',
                                ['marca'=> str_replace(" ", "-",strtolower($item['brand'])), 'productType'=> strtolower($item['productType']), 'brand'=> str_replace(" ", "-",strtolower($item['brand'])), 'mpn'=> strtolower($item['mpn'])])}}">
                                    @if(isset($item['discount']))
                                        <div class="ribbon ribbon-top-right" style="display: block">
                                            <span>Oferta</span>
                                        </div>
                                    @endif
{{--                                    @if(isset($item['discount']))--}}
{{--                                        <img src="{{ asset('assets/images/ofertas/oferta-15.png') }}" style="width: 85px;position: absolute;top: 0;left: 0;" title="Pestaña Izquierda" alt="Pestaña Izquierda">--}}
{{--                                    @endif--}}
                                    <div class="product-image" style="height: 205px">
                                        <img style="max-width: 80%; max-height: 100%"
                                             src="{{asset($item['images'][0]['medium'])}}"
                                             title="{{$item['name']}}" alt="{{$item['name']}}">
                                    </div>
                                    @if($item['newPriceFloat'] > 3000)
                                        <img class="free-delivery-prods" src="{{asset('assets/images/otros/gratis.png')}}"
                                         title="Envío gratis Jardepot" alt="Envío gratis Jardepot">
                                    @endif
                                </a>
                                <div class="d-flex align-items-center flex-column" style="height: 277px;">
                                    <p class="text-muted text-center"
                                       style="font-weight: 500; font-size: 18px;">{{$item['name']}}</p>
                                    @if($item['stock'])
                                    <p class="old-price" style="height: 21px;">
                                        @if(isset($item['oldPrice']))
                                            {{$item['oldPrice']}}
                                        @endif
                                    </p>
                                    <p class="new-price">{{$item['newPrice']}}</p>
                                    <p class="little-letters text-center">Precio aplica en pagos mediante depósito o transferencia bancaria.</p>
                                    <button class="btn btn-buy d-flex justify-content-center align-items-center"
                                            onclick="verifyAddCartProduct('{{$item['productType']}}','{{$item['brand']}}','{{$item['mpn']}}',1,'cart')">
                                        <i class="material-icons" style="font-size: 16px;">shopping_cart</i> Comprar
                                    </button>

                                    <p class="envio-volada d-flex justify-content-center align-items-center my-2"
                                       style="height: 24px; max-height: 24px;">
                                        @if($item['inventory'] > 0)
                                            <i class="material-icons" style="font-size: 16px;">flash_on</i>Envio de
                                            volada
                                        @endif
                                    </p>
                                    <p class="little-letters">*Envio gratis a partir de $3,000 de compra</p>
                                    <p class="little-letters">*Consulte condiciones.</p>
                                    <p class="product-description p-2 text-center text-truncate" data-toggle="tooltip"
                                       data-placement="bottom"
                                       style="min-height: 74px; max-height: 74px; white-space: normal;"
                                       title="{{$item['description']}}">
                                        {{$item['description']}}
                                    </p>
                                    @else
                                        <p class="little-letters">*Envio gratis a partir de $3,000 de compra</p>
                                        <p class="little-letters">*Consulte condiciones.</p>
                                        <p class="product-description p-2 text-center text-truncate" data-toggle="tooltip"
                                           data-placement="bottom"
                                           style="min-height: 74px; max-height: 74px; white-space: normal;"
                                           title="{{$item['description']}}">
                                            {{$item['description']}}
                                        </p>
                                        <p class="text-center mt-3" style="color: rgba(0,0,0,.54)!important; font-weight: 900; font-size: 15px; ">Consulta precio y existencia Llámanos al teléfono</p>
                                        <p style="font-weight: 900; font-size: 18px; color: #de1f21;">800 212 9225</p>
                                    @endif
                                </div>
                                <hr>
                                <div class="d-flex align-items-center flex-column">
                                    <div style="height: 36px">
                                        @if($item['stock'])
                                            <strong>
                                                <a href="#!" onclick="verifyAddCartProduct('{{$item['productType']}}','{{$item['brand']}}','{{$item['mpn']}}',1,'')"
                                                   class="btn-add-cart d-flex justify-content-center align-items-center"
                                                   style="font-size: 14px;">
                                                    <i class="material-icons fn-color-jd">shopping_cart</i>
                                                    <span class="text-muted" style="font-size: 14px; font-weight: 500;">Agregar al carrito</span>
                                                </a>
                                            </strong>
                                        @endif
                                    </div>
                                    <p class="little-letters text-center">*Sujeto a existencias.</p>
                                    <p class="little-letters text-center">*Precios sujetos a cambio sin previo
                                        aviso.</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row border shadow bg-white rounded mt-2 pagination-container">
                        <div class="col-12" style="border-radius: 5px;overflow: hidden;">
                            <nav aria-label="Search results products">
                                <ul class="pagination d-flex justify-content-center align-items-center my-2">
                                    <li class="page-item previous-page disabled">
                                        <a class="page-link" data-val="--" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                                    </li>
                                    @for ($i = 0; $i < $numberPages; $i++)
                                        <li class="page-item number-page @if($i == 0) active @endif">
                                            <a class="page-link" data-val="{{ $i+1 }}" href="#">{{ $i+1 }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item next-page @if($numberPages <= 1) disabled @endif">
                                        <a class="page-link" data-val="++" href="#">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    @if(isset($descriptionLevel2->texto))
                        <div class="row border shadow bg-white rounded mt-4 mb-4">
                            <div class="col-12" style="border-radius: 5px;overflow: hidden;">
                                {!! $descriptionLevel2->texto !!}
                            </div>
                        </div>
                    @endif
                </div>
                @endif
                @if(isset($productsListSearch) && count($productsListSearch) > 0)
                <div id="list-products-search">
                    <div class="row border shadow bg-white rounded">
                        <input type="hidden" value="{{$categoryLevel2}}" id="word-search">
                        @if($categoryLevel2 == "productos")
                            <h1 class="m-2 text-muted" style="font-size: 28px;">Ofertas</h1>
                        @else
                            <h1 class="m-2 text-muted" style="font-size: 28px;">Buscaste: {{$categoryLevel2}}</h1>
                        @endif
                    </div>
                    <div class="row border shadow rounded bg-dark my-2 text-white px-2 d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <p>Ordenar por:</p>
                            <select id="orderBy" class="form-control">
                                <option value="default">Relevancia</option>
                                <option value="ASC">Menor Precio</option>
                                <option value="DESC">Mayor Precio</option>
                            </select>
                        </div>
                        <button type="button"
                                class="sidebarCollapse btn bg-color-jd btn-sm d-flex align-items-center justify-content-center d-lg-none d-flex">
                            <i class="material-icons mr-2">menu</i>
                            <span>Filtros y secciones</span>
                        </button>
                        <div class="row pagination-container">
                            <div class="col-12" style="border-radius: 5px;overflow: hidden;">
                                <nav aria-label="Search results products">
                                    <ul class="pagination d-flex justify-content-center align-items-center my-2">
                                        <li class="page-item previous-page disabled">
                                            <a class="page-link" data-val="--" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                                        </li>
                                        @for ($i = 0; $i < $numberPages; $i++)
                                            <li class="page-item number-page @if($i == 0) active @endif">
                                                <a class="page-link" data-val="{{ $i+1 }}" href="#">{{ $i+1 }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item next-page @if($numberPages <= 1) disabled @endif">
                                            <a class="page-link" data-val="++" href="#">Siguiente</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div>
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                   id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    Mostrar <span class="current-number-items">16</span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item number-items" data-val="16" href="#" id="eight-products">16</a>
                                    <a class="dropdown-item number-items" data-val="20" href="#">20</a>
                                    <a class="dropdown-item number-items" data-val="24" href="#">24</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="cards-sections-search" class="row">
                        @foreach($productsListSearch as $key => $item)
                            <div class="card shadow-sm product-item col-sm-6 col-md-4 col-lg-3 p-0 mt-2 @if($loop->iteration > 16) d-none  @endif"
                                 style="border-radius: 5px;overflow: hidden;">
                                <a href="{{route('product',
                                ['marca'=> str_replace(" ", "-",strtolower($item['brand'])), 'productType'=> strtolower($item['productType']), 'brand'=> str_replace(" ", "-",strtolower($item['brand'])), 'mpn'=> strtolower($item['mpn'])])}}">
                                    @if(isset($item['discount']))
                                        <div class="ribbon ribbon-top-right" style="display: block"><span>Oferta</span></div>
                                    @endif
{{--                                    @if(isset($item['discount']))--}}
{{--                                        <img src="{{ asset('assets/images/ofertas/oferta-15.png') }}" style="width: 85px;position: absolute;top: 0;left: 0;" title="Pestaña Izquierda" alt="Pestaña Izquierda">--}}
{{--                                    @endif--}}
                                    <div class="product-image" style="height: 205px">
                                        <img style="max-width: 80%; max-height: 100%"
                                             src="{{asset($item['images'][0]['medium'])}}"
                                             title="{{$item['name']}}" alt="{{$item['name']}}">
                                    </div>
                                    @if($item['newPriceFloat'] > 3000)
                                        <img class="free-delivery-prods" src="{{asset('assets/images/otros/gratis.png')}}"
                                         title="Envío gratis Jardepot" alt="Envío gratis Jardepot">
                                    @endif
                                </a>
                                <div class="d-flex align-items-center flex-column" style="height: 277px;">
                                    <p class="text-muted text-center"
                                       style="font-weight: 500; font-size: 18px;">{{$item['name']}}</p>

                                    @if($item['stock'])
                                        <p class="old-price" style="height: 21px;">
                                            @if(isset($item['oldPrice']))
                                                {{$item['oldPrice']}}
                                            @endif
                                        </p>
                                        <p class="new-price">{{$item['newPrice']}}</p>
                                        <p class="little-letters text-center">Precio aplica en pagos mediante depósito o transferencia bancaria.</p>
                                        <button class="btn btn-buy d-flex justify-content-center align-items-center"
                                                onclick="verifyAddCartProduct('{{$item['productType']}}','{{$item['brand']}}','{{$item['mpn']}}',1,'cart')">
                                            <i class="material-icons" style="font-size: 16px;">shopping_cart</i> Comprar
                                        </button>

                                        <p class="envio-volada d-flex justify-content-center align-items-center my-2"
                                           style="height: 24px; max-height: 24px;">
                                            @if($item['inventory'] > 0)
                                                <i class="material-icons" style="font-size: 16px;">flash_on</i>Envio de
                                                volada
                                            @endif
                                        </p>
                                        <p class="little-letters">*Envio gratis a partir de $3,000 de compra</p>
                                        <p class="little-letters">*Consulte condiciones.</p>
                                        <p class="product-description p-2 text-center text-truncate" data-toggle="tooltip"
                                           data-placement="bottom"
                                           style="min-height: 74px; max-height: 74px; white-space: normal;"
                                           title="{{$item['description']}}">
                                            {{$item['description']}}
                                        </p>
                                    @else
                                        <p class="little-letters">*Envio gratis a partir de $3,000 de compra</p>
                                        <p class="little-letters">*Consulte condiciones.</p>
                                        <p class="product-description p-2 text-center text-truncate" data-toggle="tooltip"
                                           data-placement="bottom"
                                           style="min-height: 74px; max-height: 74px; white-space: normal;"
                                           title="{{$item['description']}}">
                                            {{$item['description']}}
                                        </p>
                                        <p class="text-center mt-3" style="color: rgba(0,0,0,.54)!important; font-weight: 900; font-size: 15px; ">Consulta precio y existencia Llámanos al teléfono</p>
                                        <p style="font-weight: 900; font-size: 18px; color: #de1f21;">800 212 9225</p>
                                    @endif
                                </div>
                                <hr>
                                <div class="d-flex align-items-center flex-column">
                                    <div style="height: 36px">
                                        @if($item['stock'])
                                            <strong>
                                                <a href="#!" onclick="verifyAddCartProduct('{{$item['productType']}}','{{$item['brand']}}','{{$item['mpn']}}',1,'')"
                                                   class="btn-add-cart d-flex justify-content-center align-items-center"
                                                   style="font-size: 14px;">
                                                    <i class="material-icons fn-color-jd">shopping_cart</i>
                                                    <span class="text-muted" style="font-size: 14px; font-weight: 500;">Agregar al carrito</span>
                                                </a>
                                            </strong>
                                        @endif
                                    </div>
                                    <p class="little-letters text-center">*Sujeto a existencias.</p>
                                    <p class="little-letters text-center">*Precios sujetos a cambio sin previo
                                        aviso.</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row border shadow bg-white rounded mt-2 pagination-container">
                        <div class="col-12" style="border-radius: 5px;overflow: hidden;">
                            <nav aria-label="Search results products">
                                <ul class="pagination d-flex justify-content-center align-items-center my-2">
                                    <li class="page-item previous-page disabled">
                                        <a class="page-link" data-val="--" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                                    </li>
                                    @for ($i = 0; $i < $numberPages; $i++)
                                        <li class="page-item number-page @if($i == 0) active @endif">
                                            <a class="page-link" data-val="{{ $i+1 }}" href="#">{{ $i+1 }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item next-page @if($numberPages <= 1) disabled @endif">
                                        <a class="page-link" data-val="++" href="#">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                @endif
                @if(isset($productsListSearch) && count($productsListSearch) == 0)
                <div id="form-search">
                            <div class="row border shadow bg-white rounded">
                                <div class="col-12 mb-3 d-flex justify-content-between"
                                     style="border-bottom: 1px solid rgba(204,204,204,.6);">
                                    <input type="hidden" value="{{$categoryLevel2}}" id="word-search">
                                    <h1 class="m-2 text-muted" style="font-size: 28px;">Buscaste: {{$categoryLevel2}} </h1>
                                    <button
                                        class="sidebarCollapse btn bg-color-jd btn-sm d-flex align-items-center justify-content-center d-lg-none d-flex">
                                        <i class="material-icons mr-2">menu</i>
                                        <span>Filtros y secciones</span>
                                    </button>
                                </div>
                                <div id="container-form" class="row">
                                    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                                        <h3>¿No encontraste tu producto?</h3>
                                        <h5>Comunícate al:</h5>
                                        <h4><i class="material-icons">phone</i> 800 212 9225</h4>
                                        <h4>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 aria-hidden="true"
                                                 focusable="false" width="20px" height="20px"
                                                 style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                                                 preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                <path
                                                    d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01z"
                                                    fill="#000"/>
                                                <rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)"/>
                                            </svg>
                                            55 5185 7805
                                        </h4>
                                        <h4 class="my-5">Horario de atención: 9am a 6pm</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <form id="form-failed" class="d-flex flex-wrap px-2">
                                                <div class="col-12">
                                                    <h3>Nosotros te llamamos, ingresa tus datos.</h3>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" name="nombre" placeholder="Nombre completo*" id="name" >
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" id="phone" placeholder="Teléfono *">
                                                </div>
                                                <div class="col-12 my-3">
                                                    <textarea class="form-control" id="coments" placeholder="Comentarios"
                                                      style="resize: none;"></textarea>
                                                </div>
                                                <div class="col-12 text-center mb-3">
                                                    <button class="btn bg-color-jd" type="button" id="btn-form"> Enviar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="container-form-sent"  class="flex-column justify-content-center align-items-center my-3 w-100 d-none">
                                    <h2 class="text-muted">Jardepot agradece tu confianza.</h2>
                                    <hr>
                                    <h3 class="mt-1 text-center" >Nuestro equipo responderá tu solicitud a la brevedad.</h3>
                                    <h4 class="mt-1 text-center">Puedes contactarnos a través del correo: ventas@jardepot.com, o por el telefono al (777) 399 08 09</h4>
                                    <h3 class="mt-1 text-center">en un horario de Lunes a Viernes de 9am a 6pm y Sábados de 9am a 2pm.</h3>
                                    <h3 class="mt-2 text-center">Será un gusto atenderte.</h3>
                                    <div class="mt-1 text-center">
                                        <a class=" btn bg-color-jd" href="{{route('home')}}">
                                            Regresar al Inicio
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endif

                @include('components.caruselCanales')
                @include('components.infoCompra')
            </div>
        </div>
    </div>
@endsection

@section('specificJS')
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <script src="{{asset('assets/js/components/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/pages/products.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/sidebar.min.js')}}"></script>
@endsection
