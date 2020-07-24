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
@endsection

@section('content')
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="material-icons fn-color-jd mr-2">close</i>
            </div>
        </nav>

        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
            <span>Toggle Sidebar</span>
        </button>

        <!-- Page Content  -->
        <div id="content" class="row">
            <div class="card d-none d-lg-block col-lg-3 mr-3" style="max-width: 23%">
                @component('components.sidebar')
                @endcomponent
            </div>

            <div class="card col-lg-9 col-md-12">

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
