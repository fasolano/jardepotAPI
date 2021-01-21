@extends('pages')


@section('metaData')
    <title>Jardepot</title>
    <meta title=""/>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="noindex">
@endsection

@section('specificCSS')
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.min.css')}}">
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
@endsection

@section('content')
    <div class="wrapper">
        <!-- Page Content  -->
        <div class="row my-3">
            <div class="col-lg-12 col-md-12">
                <div class="border shadow bg-white rounded p-5 row">
                    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                        <h3>¿No encontraste lo que buscabas?</h3>
                        <h5>Comunícate al:</h5>
                        <h4><i class="material-icons">phone</i> 800 212 9225</h4>
                        <h4>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 aria-hidden="true"
                                 focusable="false" width="20px" height="20px"
                                 style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                                 preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path
                                    d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.188 8.188 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18c.21-.58.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01z"
                                    fill="#000"/>
                                <rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)"/>
                            </svg>
                            55 5185 7805
                        </h4>
                        <h4 class="my-5">Horario de atención: 9am a 6pm</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <form id="form-failed" class="d-flex flex-wrap px-2">
                                <div class="col-12">
                                    <h3>Nosotros te llamamos, ingresa tus datos.</h3>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="nombre" placeholder="Nombre completo*"
                                           id="name">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="phone" placeholder="Teléfono *">
                                </div>
                                <div class="col-12 my-3">
                                                    <textarea class="form-control" id="coments"
                                                              placeholder="Comentarios"
                                                              style="resize: none;"></textarea>
                                </div>
                                <div class="col-12 text-center mb-3">
                                    <button class="btn bg-color-jd" type="button" id="btn-form"> Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('specificJS')
    <script type="text/javascript" src="{{asset('assets/js/pages/products.min.js')}}"></script>
@endsection
