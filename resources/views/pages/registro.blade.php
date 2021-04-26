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

<div class="col col-md-5" style="text-align: center;">
    <div style="background-color: #f1f1f1; height:100%; padding-top:15%; padding-bottom:15%;" class="mx-3">
        <form class="form-horizontal">
            <div class="form-group">
                <input type="text" id="userName" placeholder="Nombre Completo"/>
            </div>
        </form>
        <a href="{{ url('cuenta/login') }}" class="btn" style="border-radius:1px !important;color:white; background-color: #f68600;">¡Quiero beneficios!</a>
    </div>
</div>


@endsection
