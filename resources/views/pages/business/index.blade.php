@extends('pagesclub')

@section('metaData')
    <title>¡Únete al club!</title>
    <meta title="¡Únete al club!"/>
    <meta name="description" content="Unete al club">
{{--    <meta name="keywords" content="Carrito, Jardepot">--}}
    <meta name="googlebot" content="noindex" />
    <meta name="robots" content="noindex">
@endsection

@section('specificCSS')
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pages/cart.min.css')}}">
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AU1Jzf7ziTCncrNsNBjmk_tD03Iz_1o8J4FNGTh5Z2mYHRSV21eh6rQbPDiQgOzTFiVXFmLdtzT4XzI_&currency=MXN"></script>
    {{--<script src="https://www.paypal.com/sdk/js?client-id=AXYsm9VJ1VvDrdy5xzQHHJBnnhuhEKcFWhhFPkXBZI9V-G4CmfiXDpNh2DaKT06EaWDFnqWG_1z5ztbi&currency=MXN"></script>--}}
    {{-- test   alcocer-buyer@jardepot.com
    27a0a110dd046--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
@endsection

@section('content')
<div style="top:0px; right:0px; left:0px;">
    <img src="/assets/images/otros/business/header-1920.png" style="width: 100%;"/>
</div>
<div class="row align-items-center h-100">
    <div class="col-md-9 col-sm-12 mx-auto my-auto">
        <a href="/" style="float: left; color: #333333; font-weight:bold; font-size:24px;">Inicio</a>
        <a href="https://digicom.mx/business/login" target="_blank" style="float: right; color:#333333; font-weight:bold; font-size:24px;">Inicio de sesión <i class="fa fa-user"></i></a>
        <br/>
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/assets/images/otros/business/slide-1.png" class="w-100" alt="...">
                    <div class="carousel-caption" style="color:#333333; font-weight:bold;">
                        <h4>Únete a nuestra familia Jardepot</h4>
                        <a href="/business/registro" class="btn btn-md btn-primary " style="background-color: rgb(62,65,65); border-color: rgb(62,65,65); font-weight:bold;">Jardepot Business</a>
                    </div>

                </div>
                <div class="carousel-item">
                    <img src="/assets/images/otros/business/slide-2.png" class="w-100" alt="...">
                    <div class="carousel-caption" style="color:#333333; font-weight:bold;">
                        <h4>Únete a nuestra familia Jardepot</h4>
                        <a href="/business/registro" class="btn btn-md btn-primary" style="background-color: rgb(62,65,65); border-color: rgb(62,65,65); font-weight:bold;">Jardepot Business</a>

                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/assets/images/otros/business/slide-3.png" class="w-100" alt="...">
                    <div class="carousel-caption" style="color:#333333; font-weight:bold;">
                        <h4>Únete a nuestra familia Jardepot</h4>
                        <a href="/business/registro" class="btn btn-md btn-primary" style="background-color: rgb(62,65,65); border-color: rgb(62,65,65); font-weight:bold;">Jardepot Business</a>

                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>
    </div>
</div>


<div style="bottom:0px; right:0px; left:0px;">
    <img src="/assets/images/otros/business/footer-1920.png" style="width: 100%;"/>
</div>

<script>
$(document).ready(function(){
    $('.carousel').carousel({
        interval: 2000
    })
})

</script>
@endsection
