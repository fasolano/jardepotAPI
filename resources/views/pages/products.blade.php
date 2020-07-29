@extends('pages')


@section('metaData')
    <title>Products</title>
    {{--<meta title="{{ ucfirst($titleweb)}}"/>
    <meta name="description" content="{{$metadesc}}">
    <meta name="keywords" content="{{$keywords}}">--}}
@endsection

@section('specificCSS')
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/pages/products.css')}}">
    <!-- Components CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/sidebar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.css')}}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/jquery.mCustomScrollbar.min.css')}}">
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
            <div class="border shadow bg-white rounded d-none d-lg-block col-lg-3 mr-3 p-0" style="max-width: 23%">
                @component('components.sidebar')
                    @slot('id', 'Desktop')
                @endcomponent
            </div>

            <div class="col-lg-9 col-md-12">
                <div class="row border shadow bg-white rounded">
                    <h1 class="m-2 text-muted">Aspersoras</h1>
                </div>
                <div class="row border shadow rounded bg-dark my-2 text-white px-2 d-flex justify-content-between align-items-center">
                    <div>
                        <span>Ordenar por:</span>
                        <select>
                            <option value="relevancia">Relevancia</option>
                            <option value="menor-precio">Menor Precio</option>
                            <option value="mayor-precio">Mayor Precio</option>
                        </select>
                    </div>
                    <button type="button" id="sidebarCollapse" class="btn bg-color-jd btn-sm d-flex align-items-center justify-content-center d-lg-none d-flex">
                        <i class="material-icons mr-2">menu</i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <div>
                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Mostrar 8
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">8</a>
                                <a class="dropdown-item" href="#">12</a>
                                <a class="dropdown-item" href="#">16</a>
                            </div>
                        </div>


                    </div>
                </div>
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
    <script type="text/javascript" src="{{asset('assets/js/components/sidebar.js')}}"></script>
@endsection
