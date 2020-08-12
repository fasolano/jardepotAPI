<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-T2GB24V');</script>
    <!-- End Google Tag Manager -->
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
<!-- Hotjar Tracking Code for https://www.jardepot.com -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1678354,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
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
