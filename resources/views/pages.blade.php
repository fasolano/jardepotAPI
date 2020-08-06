<!DOCTYPE html>
<html lang="es">
<head>
    {{--  Metatitle, metadescripcion, titulo de página, etc.  --}}
    @yield('metaData')

    @include('layout.head')

    {{--  Css especifico de cada página  --}}
    @yield('specificCSS')
</head>

<body style="font-family: Roboto !important;">
<div id="overlay-bussy"><div id="loading"></div></div>
@include('layout.navbar')
<div class="container-fluid" style="background: #fafafa;">
    <div class="row justify-content-md-center">
        <div class="col-xl-12 col-lg-12" style="max-width: 1400px;">
            {{--  Contenido de la página  --}}
            <div id="snackbar"></div>
            @yield('content')
        </div>
    </div>
</div>

@include('layout.footer')
@include('layout.cierre')

{{--  Js especifico de cada página  --}}
@yield('specificJS')
</body>
</html>
