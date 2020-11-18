@extends('pages')


@section('metaData')
    <title>{{ ucfirst('Rastrea tu envío')}}</title>
    <meta title="{{ ucfirst('Rastrea tu envío')}}"/>
{{--    <meta name="description" content="{{$product['metaDescription']}}">--}}
{{--    <meta name="keywords" content="{{$product['keywords']}}">--}}

{{--    <meta property="og:title" content="{{ $product['metaTitle'] }}" />--}}
{{--    <meta property="og:description" content="{{ $product['metaDescription'] }}" />--}}
    <meta property="og:type" content="website" />
{{--    <meta property="og:url" content="{{$canonical}}" />--}}
    <meta property="og:url" content="{{'https://www.jardepot.com/tracking'}}" />
    <meta property="og:image" content="{{asset('img/logos/logoOG.jpg')}}" />
    <meta property="og:image:url" content="{{asset('img/logos/logoOG.jpg')}}" />
    <meta property="og:image:secure_url" content="{{asset('img/logos/logoOG.jpg')}}" />
@endsection

@section('specificCSS')
    <link rel="stylesheet" href="{{asset('assets/css/components/sidebar.min.css')}}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/jquery.mCustomScrollbar.min.css')}}">
{{--    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.min.css')}}">--}}

{{--    <link rel="stylesheet" href="{{asset('assets/css/pages/cart.min.css')}}">--}}
    <link rel="canonical" href="{{'https://www.jardepot.com/tracking'}}">
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
@endsection

@section('content')
{{--    @component('components.breadcrumb')--}}
{{--        @slot('level1', 'Rastreo')--}}
{{--    @endcomponent--}}
    <div class="wrapper">

        <!-- Page Content  -->
        <div id="content" class="row">
{{--            <div class="card d-none d-lg-block col-lg-3 mr-3" style="max-width: 23%">--}}
{{--         --}}
{{--            </div>--}}
            <div class="col-lg-12 col-md-12">
                <h1 class="title-product">Rastea tu pedido</h1>
                <p>20290</p>
                <div class="row">
                    <div class="col-md-4" style="padding-right: 0">
                        <div class="card shadow-sm" style="overflow: hidden;">
                            <div class="p-2">
                                <form id="formTracking" action="javascript:void(0)">
                                    <div class="form-group">
                                        <label class="sr-only form-control-label" for="email">Correo electrónico</label>
                                        <input type="text" class="form-control" placeholder="Correo electrónico" id="email" name="email" value="joseoroz1@gmail.com">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only form-control-label" for="telefono">Teléfono</label>
                                        <input type="text" class="form-control" placeholder="Teléfono (10 digitos)*" id="telefono" name="telefono" value="7774200866">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only form-control-label" for="pedido">Número de pedido</label>
                                        <input type="text" class="form-control" placeholder="Número de pedido" id="pedido" name="pedido">
                                    </div>
                                    <div class="text-right">

                                        <button type="submit" class="btn btn-warning">Buscar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 d-none d-md-none d-lg-block">
                        <div class="card shadow-sm" style="display: inherit" id="prueba"></div>

                     {{--   <div class="card shadow-sm" style="display: inherit">
                            <div class="p-2">
                                <img src="{{asset('assets/images/otros/tracking/logo_odm.png')}}" style="width: 150px">
                                <p class="mt-3" style="font-size: 18px">Guía: <strong>45564564564</strong></p>
                                <a class="btn btn-primary" target="_blank" href="https://odmexpress.com.mx/rastreo-2/?rastreo_fall=5646"> Ir a la página </a>
                            </div>
                        </div>--}}
                    </div>
                </div>
                <div class="divider"></div>
                <div class="row">

                </div>
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
    <script type="text/javascript" src="{{asset('assets/js/components/sidebar.min.js')}}"></script>
{{--    <script type="text/javascript" src="{{asset('assets/js/pages/cart.min.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('assets/js/pages/tracking.js')}}"></script>


@endsection

