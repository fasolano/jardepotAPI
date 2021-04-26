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
@endsection

@section('content')
<div class="row">
    <img src="/assets/images/otros/header.png" style="max-width: 100%;"/>
</div>


    <div class="col-md-5 col-lg-5">
        <form class="form-horizontal" role="form" style="border: 1px solid #e1e1e1; padding-top: 10%; padding-bottom:10%;">
            <div style="text-align:center" class="mx-3">
                <h2>¡BIENVENIDO!</h2>
                <p style="font-weight: bold;"> Si ya eres miembro de <span style="color:crimson">JarDepot</span>,
                    por favor inicia sesión con tus datos
                </p>
            </div>
            <br/>
            <div class="form-group mx-3">
                <input class="form-control" placeholder="Correo electrónico" id="userEmail" type="email"/>
            </div>
            <div class="form-group mx-3">
                <input class="form-control" placeholder="Contraseña" type="password" id="userPassword"/>
            </div>
            <div style="text-align: center">
                <button type="submit" class="btn mx-3" style="border-radius:1px !important; color:white; background-color: #f68600;">¡Iniciar sesión!</button>
            </div>
        </form>
    </div>
    <div class="col col-md-5" style="text-align: center;">
        <div style="background-color: #f1f1f1; height:100%; padding-top:15%;" class="mx-3">
            <h3>¿Aún no eres miembro?</h3>
            <br/>
            <p>
                Únete a Jardepot Club y disfruta sus beneficios ¡Totalmente Gratis!
            </p>
            <br/>
            <a href="{{ url('cuenta/registro') }}" class="btn" style="border-radius:1px !important;color:white; background-color: #f68600;">¡Registrarme!</a>
        </div>
    </div>


@endsection
