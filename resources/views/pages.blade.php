<!DOCTYPE html>
<html lang="es">
<head>
    {{--  Metatitle, metadescripcion, titulo de página, etc.  --}}
    @yield('metaData')

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('layout.head')

    {{--  Css especifico de cada página  --}}
    @yield('specificCSS')
</head>

<body style="font-family: Roboto !important;">
@include('layout.navbar')
<div class="container-fluid" style="background: #fafafa;">
    <div class="row justify-content-md-center">
        <div class="col-xl-12 col-lg-12" style="max-width: 1400px;">
            {{--  Contenido de la página  --}}
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
