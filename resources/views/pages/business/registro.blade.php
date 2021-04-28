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
<div style="top:0px; right:0px; left:0px;">
    <img src="/assets/images/otros/business/header-1920.png" style="width: 100%;"/>
</div>
<div class="row align-items-center h-100">
    <div class="col-md-7 col-sm-12 mx-auto my-auto">
        <div class="btn btn-sm" style="float: right;height:35px; border-radius: 20px; background-color: rgb(62,65,65); color:white; font-weight:bold;">
            <span>Jardepot Business</span>
            <img src="/assets/images/otros/business/corona.png" style="height: 30px;" class="my-auto" />
        </div>
        <br/><br/>
        <div style="background-color: #f1f1f1; padding-bottom:1px; border-radius:20px;" class="mx-5 has-feedback">
            <div class="d-flex"
                style="align-items:center; background-color:#14B9D6; min-height:100px; margin-left: auto; margin-right: auto; max-height:100px; max-width:100px; border-radius:50%; overflow:hidden;" >
                <i class="fa fa-user fa-4x mx-auto" style="color: white;"></i>
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
                    Consulta nuestro <a href="#" data-toggle="modal" data-target="#avisoPrivacidad">aviso de privacidad.</a>
                </p>
                <br/>
                <div class="w-100 d-flex">
                    <button type="submit" class="btn mx-auto" style="border-radius:20px !important;color:white; background-color: #f68600;">¡Registrarme!</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br/>

<div style="bottom:0px; right:0px; left:0px;">
    <img src="/assets/images/otros/business/footer-1920.png" style="width: 100%;"/>
</div>

<div class="modal fade" id="avisoPrivacidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center; font-weight:bold;">
                <h2 class="modal-title" id="exampleModalLabel">Aviso de Privacidad</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-justify" style="font-weight: bold; font-size:20px;">
                Los datos personales (Los Datos) solicitados, son tratados por Jardepot S.A. de C.V. (Jardepot), con la finalidad de brindarle el servicio que nos solicita, conocer sus necesidades de productos o servicios y estar en posibilidad de ofrecerle los que más se adecuen a sus preferencias; comunicarle promociones, atender quejas y aclaraciones, y en su caso, tratarlos para fines compatibles con los mencionados en este Aviso de Privacidad y que se consideren análogos para efectos legales. En caso de formalizar con Usted la aceptación de algún producto o servicio ofrecido por Jardepot, sus Datos serán utilizados para el cumplimiento de las obligaciones derivadas de esa relación jurídica. Los Datos serán tratados de conformidad con la Ley Federal de Protección de Datos Personales en Posesión de los Particulares y su Reglamento. La confidencialidad de los Datos está garantizada y los mismos están protegidos por medidas de seguridad administrativas, técnicas y físicas, para evitar su daño, pérdida, alteración, destrucción, uso, acceso o divulgación indebida. Únicamente las personas autorizadas tendrán acceso a sus Datos. En caso de existir alguna modificación al presente Aviso de Privacidad se hará de su conocimiento en nuestro sitio de Internet
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
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
