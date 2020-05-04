<?php
date_default_timezone_set('America/Mexico_City');
error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    @include('layouts.head')
</head>

<body oncopy="return false">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T2GB24V"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->



<!-- Contenedor Principal -->
<div class="jd-main-cont col-md-12">
    @include('layouts.navbar')

    @yield('content')

    @include('layouts.footer')
</div>
<!-- Fin Contenedor Principal -->

@include('layouts.cierre')

</body>
</html>
