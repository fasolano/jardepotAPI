<?php
date_default_timezone_set('America/Mexico_City');
error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    @include('layout.head')
</head>

<body>

<div class="row">

    <!-- Contenedor Principal -->
    <div class="col-md-12">
        @include('layout.navbar')

        {{--    @yield('content')--}}

        @include('layout.footer')
    </div>
    <!-- Fin Contenedor Principal -->

</div>

@include('layout.cierre')

</body>
</html>
