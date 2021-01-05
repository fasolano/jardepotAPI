<!DOCTYPE html>
<html lang="es-MX">
<head>
{{--    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-T2GB24V');</script>
    <!-- End Google Tag Manager -->--}}

    <style>
        #menu>li>*{
            margin: 0;
            padding: 0;
            color: #f68600;
            font-weight: 500;
        }
        #menu,#menu>li>ul{
            list-style: none;
        }
        #menu li>a{
            display: flex;
            text-decoration: none;
            min-width: 100px;
            margin: 0;
            padding: 0;
        }
        #menu>li{
            position: relative;
            float: left;
        }
        #menu>li>ul{
            position: absolute;
            display: none;
        }
        #menu>li:hover>ul {
            display:block;
        }
        #menu>li:hover {
            color: #c16c05;
        }
    </style>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-28826115-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-28826115-1');
    </script>
    <!-- Global site tag (gtag.js) - Google Ads: 786429434 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-786429434"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-786429434');
    </script>
    <script>
        gtag('event', 'page_view', {
            'send_to': 'AW-786429434',
            'user_id': 'replace with value',
            'value': 'replace with value',
            'items': [{
                'id': 'replace with value',
                'google_business_vertical': 'retail'
            }]
        });
    </script>

    {{--  Metatitle, metadescripcion, titulo de página, etc.  --}}
    @yield('metaData')
<!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '209203906543019');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=209203906543019&ev=PageView&noscript=1"/>
    </noscript>
    <!-- Hotjar Tracking Code for www.jardepot.com -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:2182129,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
    <!-- End Facebook Pixel Code -->
    @include('layout.head')

    {{--  Css especifico de cada página  --}}
    @yield('specificCSS')
</head>

<body style="font-family: Roboto !important; position: relative;">
    {{--<!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T2GB24V" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->--}}

    <!--  Clickcease.com tracking-->
    <script type='text/javascript'>var script = document.createElement('script');
        script.async = true; script.type = 'text/javascript';
        var target = 'https://www.clickcease.com/monitor/stat.js';
        script.src = target;var elem = document.head;elem.appendChild(script);
    </script>
    <noscript>
        <a href='https://www.clickcease.com' rel='nofollow'><img src='https://monitor.clickcease.com/stats/stats.aspx' alt='ClickCease'/></a>
    </noscript>
    <!--  Clickcease.com tracking-->


    <div class="overlayMenuCart" style="position:absolute; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; display: none;">
        <div class="containerMenuCart" style="position: absolute; bottom: 0; width: 100%; z-index: 9999; position: fixed;">
            <button class="btn col-12 buy-now-menu" style="background-color: #f44336; color: white; height: 55px; font-size: 25px; font-weight: 500">¡Comprar ahora!</button>
            <button class="btn col-12 add-cart-menu" style="height: 55px; font-size: 25px; font-weight: 500; background-color: #28a745; color: white;">¡Agregar al carrito!</button>
        </div>
    </div>
    <div id="overlay-bussy"><div id="loading"></div></div>
    @include('layout.navbar')
    <div class="container-fluid" style="background: #fafafa;">
        <div class="row justify-content-md-center">
            <div class="col-xl-12 col-lg-12" style="max-width: 1300px;">
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
