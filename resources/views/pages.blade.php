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
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T2GB24V"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-28826115-1"></script>

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
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-28826115-1');
</script>
{{--  Js especifico de cada página  --}}
@yield('specificJS')
</body>
</html>
