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
    <script src="https://kit.fontawesome.com/c1b6c8a9c6.js" crossorigin="anonymous"></script>
    {{--<script src="https://www.paypal.com/sdk/js?client-id=AXYsm9VJ1VvDrdy5xzQHHJBnnhuhEKcFWhhFPkXBZI9V-G4CmfiXDpNh2DaKT06EaWDFnqWG_1z5ztbi&currency=MXN"></script>--}}
    {{-- test   alcocer-buyer@jardepot.com
    27a0a110dd046--}}
@endsection

@section('content')
<div class="row">
    <img src="/assets/images/otros/business/header-1920.png" style="max-width: 100%;"/>
</div>

<div class="col-md-4 col-sm-12 col-lg-4" style="text-align: center;">
    <div class="d-flex flex-row-reverse">
        <div class="btn btn-sm my-2" style="height:30px; border-radius: 20px; background-color: rgb(62,65,65); color:white; font-weight:bold;">
            <span>Jardepot Business</span>
            <div style="border-radius:50%; height:30px; margin-top:-50px;">
                <img src="/assets/images/otros/business/corona.png" style="height: 30px;" />
            </div>
        </div>
    </div>
    <div style="background-color: #f1f1f1; height:100%; padding-top:10%; padding-bottom:1px; border-radius:20px;" class="mx-3 has-feedback">
        <div
            style="padding-top: 3%; background-color:#14B9D6; min-height:100px; margin-left: auto; margin-right: auto; margin-top:-100px; max-height:100px; max-width:100px; border-radius:50%; overflow:hidden;" >
            <i class="fa fa-user fa-4x" style="color: white;"></i>
        </div>
        <br/>
        <form class="form-horizontal mx-5 form-group" id="formRegistro" enctype="multipart/form-data" method="POST" action="/business/registro" autocomplete="off">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" required id="userName" name="userName" class="form-control" placeholder="Nombre Completo" autocomplete="off"/>
            </div>
            <div class="form-group">
                <input type="tel" required id="userPhone" name="userPhone" class="form-control" placeholder="Teléfono"/>
            </div>
            <div class="form-group">
                <input type="email" required id="userEmail" name="userEmail" class="form-control" placeholder="Correo electrónico"/>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="password" required id="password" name="password" class="form-control" placeholder="Contraseña"/>
                    <div class="input-group-append">
                        <button class="reveal-password" data-field="#password">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="password" required name="repeatPassword" id="repeatPassword" class="form-control" placeholder="Repita la contraseña"/>
                    <div class="input-group-append">
                        <button class="reveal-password" data-field="#repeatPassword">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group" style="text-align: left">
                <label>Acuse RFC</label>
                <input type="file" name="rfc" required id="userRFC" class="form-control" placeholder=""/>
            </div>
            {{-- <input type="checkbox" name="remember" id="remember" style="text-align: left" /> &nbsp; <label for="remember">Recordarme</label> --}}
            <br/><br/>
            <p style="font-size: 13px">
                Consulta nuestro <a href="#">aviso de privacidad.</a>
            </p>
            <br/>
            <button type="submit" class="btn" style="border-radius:20px !important;color:white; background-color: #f68600;">¡Registrarme!</button>
        </form>
    </div>
</div>
<br/>
<div class="row">&nbsp;</div>
<div class="row">
    <img src="/assets/images/otros/business/footer-1920.png" style="max-width: 100%;"/>
</div>

<script>
$(document).ready(function(){
    $("#formRegistro").submit(function(evento){
        let password = document.querySelector("#password").value
        let r_password = document.querySelector('#repeatPassword').value
        if(password != r_password){
            alert("Las contraseñas no coinciden")
            evento.preventDefault();
            document.querySelector("password").focus()
        }
    })

    $(document).on('click', '.reveal-password', function(ev){
        ev.preventDefault()
        let element = $(this.dataset.field).attr('type')
        if(element == "password"){
            $(this).html('')
            $(this).html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>')
            $(this.dataset.field).attr('type', 'text')
        }
        else if(element == 'text'){
            $(this).html('')
            $(this).html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/></svg>')
            $(this.dataset.field).attr('type', 'password')
        }

    })
})

</script>
@endsection
