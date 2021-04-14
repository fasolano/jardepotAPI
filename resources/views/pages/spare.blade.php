@extends('pages')


@section('metaData')
    <title>{{ ucfirst($productType." ".$brand." ".$mpn)}}</title>
    <meta title="{{ ucfirst($productType." ".$brand." ".$mpn)}}"/>
    <meta name="description" content="{{$productType." ".$brand." ".$mpn}}">
    <meta name="googlebot" content="index,follow" />
    <meta name="robots" content="index,follow">
@endsection

@section('specificCSS')
    <link rel="stylesheet" href="{{asset('assets/css/components/sidebar.min.css')}}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/jquery.mCustomScrollbar.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/leaflet.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/leaflet-gesture-handling.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pages/spare.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/drift-basic.min.css')}}">
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('level1', 'Refacciones')
        @slot('level2', $productType." ".$brand." ".$mpn)
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

            <div class="col-lg-9 col-md-12 card shadow">
                <h1 class="title-product">{{ucwords($productType)}} {{ucwords($brand)}} - <span style="text-transform: uppercase;">{{$mpn}}</h1>
                <h3>Comunícate al &nbsp <i class="fa fa-phone"></i> <strong> 800 212 9225</strong> ó <strong>722 648 1040</strong></h3>
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
                                            <h3 class="list-title text-center">Lista de refacciones</h3>
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
                                        <h3 class="list-title text-center" id="nombreParte"> nombre de la parte</h3>
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
        </div>
    </div>
@endsection

@section('specificJS')
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <script src="{{asset('assets/js/components/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/sidebar.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/slick.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/leaflet.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/leaflet-gesture-handling.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/drift.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/pages/spare.js')}}"></script>
@endsection
