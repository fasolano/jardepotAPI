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
@include('layout.navbar')
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-xl-9 col-lg-11 my-4">
            {{--  Contenido de la página  --}}
            @yield('content')
        </div>
    </div>
</div>
{{--<div class="container">
    <!-- Contenedor Principal -->

    <div class="col-md-12 offset-md-1">

        <div class="container">
            <header class="blog-header py-3">
                <div class="row flex-nowrap justify-content-between align-items-center">
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


        --}}{{--    @yield('content')--}}{{--

    </div>

    <!-- Fin Contenedor Principal -->
</div>--}}

@include('layout.footer')
@include('layout.cierre')

{{--  Js especifico de cada página  --}}
@yield('specificJS')
</body>
</html>
