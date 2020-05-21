<?php
date_default_timezone_set('America/Mexico_City');
error_reporting(E_ERROR | E_PARSE);

$path = "/jardepotAPI/public/";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    @include('layout.head')
</head>

<body>
<div class="row">
    <!-- Contenedor Principal -->
    <div class="col-md-12 offset-md-1">


        <div class="container">
            <header class="blog-header py-3">
                <div class="row flex-nowrap justify-content-between align-items-center">
                    @include('layout.navbar')
                </div>
            </header>
        </div>

        <main role="main" class="container">
            <div class="row">
                <div class="col-md-8 blog-main">


                </div><!-- /.blog-main -->

                <aside class="col-md-4 blog-sidebar">
                </aside><!-- /.blog-sidebar -->

            </div><!-- /.row -->

        </main><!-- /.container -->


        {{--    @yield('content')--}}

        @include('layout.footer')
    </div>
    <!-- Fin Contenedor Principal -->

</div>

@include('layout.cierre')

</body>
</html>
