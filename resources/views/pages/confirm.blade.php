@extends('pages')

@section('metaData')
    <title>Tu carrito Jardepot</title>
    <meta title=""/>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- Event snippet for Compra Paypal conversion page -->
    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-786429434/VyDMCPuDyt8BEPrr__YC',
            'transaction_id': ''
        });
    </script>
@endsection

@section('specificCSS')
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.css')}}">
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
@endsection

@section('content')
    <div class="wrapper">
        <!-- Page Content  -->
        <div id="content" class="row my-3">

            <div class="col-lg-12 col-md-12">
                <div class="border shadow bg-white rounded d-flex flex-column justify-content-center align-items-center px-2 py-3">
                    @if($state == "success")
                        <i class="material-icons fn-color-jd" style="font-size: 100px;">check</i>
                        <h2 class="py-2 col-12 col-lg-8 text-center">Gracias por tu compra por {{$payment}}.</h2>
                        <h3 class="py-1 col-12 col-lg-8 text-center">Tu pedido se procesará en breve y te informaremos el número de guía de paquetería que le corresponde.</h3>
                        <h3 class="py-1 col-12 col-lg-8 text-center">¿Necesitas factura electronica? Responde con tus datos de facturación al mensaje de correo que te enviamos a la dirección de correo electrónico que nos proporcionaste</h3>
                        <h2 class="py-2 col-12 col-lg-8 text-center">Si tienes alguna duda por favor contáctanos 800 212 9225.</h2>
                    @else
                        <i class="material-icons fn-color-jd" style="font-size: 100px;">cancel</i>
                        <h2 class="py-2 col-12 col-lg-8 text-center">Algo ha salido mal, {{$payment}} no ha procesado correctamente tu compra.</h2>
                        <h3 class="py-1 col-12 col-lg-8 text-center">Sabemos que en ocasiones esto puede ser frustrante. Comunicate con nosotros, te apoyaremos en lo que necesites.</h3>
                        <h3 class="py-1 col-12 col-lg-8 text-center">Por favor intentalo de nuevo.</h3>
                        <h2 class="py-2 col-12 col-lg-8 text-center">Estamos aquí para ayudarte contáctanos 800 212 9225</h2>
                    @endif
                    <a class="btn btn-warning" href="{{url('/')}}">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('specificJS')
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <script src="{{asset('assets/js/components/jquery.mCustomScrollbar.concat.min.js')}}"></script>
@endsection
