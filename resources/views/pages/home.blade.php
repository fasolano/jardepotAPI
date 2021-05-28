@extends('pages')

@section('metaData')
    <title>{{ $descriptionLevel2->metatitle}}</title>
    <meta title="{{ $descriptionLevel2->metatitle}}"/>
    <meta name="description" content="{{$descriptionLevel2->metadescription}}">
{{--    <meta name="keywords" content="{{$descriptionLevel2->keywords}}">--}}
    <meta id="robotG" name="googlebot" content="index,follow" />
    <meta id="robotB" name="robots" content="index,follow">

    <meta property="og:title" content="{{ $descriptionLevel2->metatitle}}"/>
    <meta property="og:description" content="{{ $descriptionLevel2->metadescription}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://www.jardepot.com/"/>
    <meta property="og:image" content="{{asset('img/logos/logoOG.jpg')}}"/>
    <meta property="og:image:url" content="{{asset('img/logos/logoOG.jpg')}}"/>
    <meta property="og:image:secure_url" content="{{asset('img/logos/logoOG.jpg')}}"/>
    <link rel="canonical" href="https://www.jardepot.com">
@endsection

@section('content')
    <div class="row shadow border border-light p-3 bg-white m-1 mt-3 rounded">
       <h1 style="font-size: 23px !important;">{{ isset($descriptionLevel2->textH1)?$descriptionLevel2->textH1:'Jardepot' }}</h1>
    </div>

    <div id="carouselBanners" class="carousel slide mt-2" data-ride="carousel">
{{--        <ol class="carousel-indicators">
            <li data-target="#carouselBanners" data-slide-to="0" class="active"></li>
            <li data-target="#carouselBanners" data-slide-to="1"></li>
            <li data-target="#carouselBanners" data-slide-to="2"></li>
        </ol>--}}
        <div class="carousel-inner">
            @foreach($images as $key=>$imagen)
                @if($key==0)
                    <div class="carousel-item active {{strpos($imagen, "movil")!==false?"movil":"desktop"}}">
                        <a href="{{url('ofertas')}}">
                            <img class="d-block w-100" data-src="{{asset('assets/images/banner/'.$imagen)}}"  alt="Oferta Jardepot" title="oferta Jardepot">
                        </a>
                    </div>
               @else
                    <div class="carousel-item {{strpos($imagen,"movil")!==false?"movil":"desktop"}}">
                        <a href="{{url('ofertas')}}">
                            <img class="d-block w-100" data-src="{{asset('assets/images/banner/'.$imagen)}}" alt="Oferta Jardepot" title="oferta Jardepot">
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselBanners" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselBanners" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    {{--    <div class="d-none d-md-block d-lg-block">
            <div class="row div-banners">
                <div class="col-xl-5 pr-0">
                    <div class="mb-2 banner divimg" id="banner1"
                         style="background-position-y: inherit;box-sizing: border-box;max-height: 60%;background-position:right">
                        <a style="text-decoration: none; width: 100%;" href="{{url('equipos/podadoras')}}">
                            <div class="info" style="place-content: flex-start; align-items: flex-start; flex-direction: row;">
                                <div class="px-2" style="background: rgba(0,0,0,.4);flex-direction: column; box-sizing: border-box; display: flex; place-content: flex-start; align-items: flex-start;">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="mt-1 banner divimg" id="banner2"
                         style="background-position-y: inherit; box-sizing: border-box;max-height: 40%;background-position:right">
                        <a style="text-decoration: none; width: 100%; flex-direction: row; box-sizing: border-box; display: flex;" href="{{url('equipos/motocultores')}}">
                            <div class="info" style="place-content: flex-end; align-items: flex-end; flex-direction: row;">
                                <div class="px-2" style="background: rgba(0,0,0,.4);flex-direction: column; box-sizing: border-box; display: flex; place-content: flex-end; align-items: flex-end;">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="mt-xl-0 col-xl-7 pl-xl-0">
                    <div id="banner3" class="banner divimg2" style="max-height: 96%">
                        <a style="text-decoration: none; height: 100% !important;" href="{{url('ofertas')}}">
                            <div class="info" style="place-content: flex-start center;align-items: flex-end;flex-direction: column;">
                                <div class="px-2" style="background: rgba(0,0,0,.4);flex-direction: column; box-sizing: border-box; display: flex; place-content: flex-start center; align-items: flex-start;">
                                    <h2 class="title">Ofertas</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>--}}
    {{--    <div class="d-none d-md-block d-lg-block">--}}

    {{--   <a href="{{url('ofertas')}}">
          <img class="img-fluid mx-auto d-block" src="{{asset('assets/images/banner/banner2.jpg')}}"
           alt="Oferta Jardepot" title="oferta Jardepot"  style="max-width: 95%">
    </a>--}}

    {{-- <div class="row justify-content-md-center mt-4 d-block d-sm-block d-md-none"></div>--}}

    <div class="m-3">
        @include('components.infoCompra')
    </div>

    <div class="row mt-4">
        @foreach($menuAdditional as $key => $cat1)
            @if($key < 2)
                <div class="col-md-4">
                    <div class="border shadow p-3 bg-white rounded div-sublinks">
                        <h2>{{$cat1['nivel1']}}</h2>
                        <div class="col-sm-12">
                            <div class="jd-sublinks-items">
                                @if(isset($cat1['nivel2']))
                                @foreach($cat1['nivel2'] as $categoria2)
                                    <a href="{{ $categoria2['href'] }}" class="my-1"><i class="material-icons">keyboard_arrow_right</i>{{$categoria2['name']}}
                                    </a>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @if($key == 2)
                    <div class="col-md-4">
                        <div class="border shadow p-3 bg-white rounded div-sublinks">
                            <h2>Otros</h2>
                            <div class="md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                @endif
                            <!-- Accordion card -->
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="card-header title-card" role="tab" id="headingOne{{$key}}"
                                         style="background-color: #fff;">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne{{$key}}"
                                           aria-expanded="true" aria-controls="collapseOne{{$key}}">
                                            <h4 class="mb-0 text-dark">
                                                {{$cat1['nivel1']}} <i class="material-icons">keyboard_arrow_down</i>
                                            </h4>
                                        </a>
                                    </div>
                                    <!-- Card body -->
                                    <div id="collapseOne{{$key}}" class="collapse show" role="tabpanel"
                                         aria-labelledby="headingOne{{$key}}" data-parent="#accordionEx">
                                        <div class="card-body p-0">
                                            <div class="col-sm-12">
                                                <div class="jd-sublinks-items">
                                                    @if(isset($cat1['nivel2']))
                                                    @foreach($cat1['nivel2'] as $key2 => $categoria2)
                                                        <a href="{{url($categoria2['href'])}}" class="my-1">
                                                            <i class="material-icons">keyboard_arrow_right</i>{{$categoria2['name']}}
                                                        </a>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                @if($loop->last)
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    </div>
    <div class="row mt-4">
        <div class="col-12" style="background-color: #3d3c3b; color: white;
            border-bottom: 4px solid #e76a27;">
            <h2 class="text-center my-3">¿Quiénes somos?</h2>
            <p class="text-center" style="font-size: 18px;">
                Somos su tienda líder en México en maquinaria ligera para agricultura,
                construcción, jardinería o sanitización tanto para profesionales
                como para uso particular. Contamos con equipamientos y modelos de las
                mejores marcas del mercado que garantizan una gran eficiencia y vida útil.
            </p>
        </div>
    </div>

    <div class="row pb-4 shadow" style="background-color: #ffffff; box-shadow:rgba(0, 0, 0, 0.54);">
        <div class="col-md-4 mt-4 col-lg-4 col-sm-12">
            <div class="row">
                <div class="col-md-10 offset-md-1 col-sm-10 offset-sm-1 text-center w-90">
                    <img
                        class="justify-self-center"
                        src="/assets/images/icons/equipos-jardineria.png"
                        title="Equipos para jardinería"
                        height="60"
                        width="60"/>
                    <div class="mt-4">
                        <div class="mb-n2"><strong>
                            Equipos de Jardinería Profesional
                        </strong></div>
                        <br/>
                        <p style="font-size: 12px;" class="mt-n1">
                            Ponemos a su disposición los equipos de jardinería
                            más modernos para la <strong>poda de árboles, cortar el césped
                            o malas hierbas o sopladoras</strong> para realizar tareas de limpieza.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4 col-lg-4 col-sm-12">
            <div class="row">
                <div class="col-md-10 offset-md-1 col-sm-10 offset-sm-1 text-center w-90">
                    <img
                        class="justify-self-center"
                        src="/assets/images/icons/equipos-agricolas.png"
                        title="Equipos para agricultura"
                        height="60"
                        width="60"/>
                    <div class="mt-4">
                        <div class="mb-n2"><strong>
                            Equipos Agrícolas
                        </strong></div>
                        <br>
                        <p style="font-size: 12px;" class="mt-n1">
                            Todo el equipamiento en maquinaria para <strong>mejorar el
                            rendimiento de lo cultivos.</strong> Encuentre en nuestro extenso
                            catálogo, herramientas de primeras marcas para labrar tierras,
                            separar los granos en las cosechas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4 col-lg-4 col-sm-12">
            <div class="row">
                <div class="col-md-10 offset-md-1 col-sm-10 offset-sm-1 text-center w-90">
                    <img
                        class="justify-self-center"
                        src="/assets/images/icons/equipos-construccion.png"
                        title="Equipos para construcción"
                        height="60"
                        width="60"/>
                    <div class="mt-4">
                        <div class="mb-n2"><strong>
                            Maquinaria Ligera para Construcción
                        </strong></div>
                        <br>
                        <p style="font-size: 12px;" class="mt-n1">
                            Contamos con el equipamiento necesario para la ejecución
                            de una obra, para <strong>compactar superficies, cortadoras de piso,
                            equipos para romper o demolición.</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row shadow border border-light p-3 bg-white mt-3 rounded">
        <h4 style="font-size: 23px !important;">{!! $descriptionLevel2->descripcionSitio !!}</h4>
    </div> --}}
    <br/>
    <div class="d-block d-sm-block d-md-none mt-5">
        @include('components.infoCompra')
    </div>

    {{-- @include('components.caruselCanales') --}}

@endsection

@section('specificJS')
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "Jardepot",
      "url": "https://www.jardepot.com",
      "address": "Av. Emiliano Zapata 129, Tlaltenango, 62170 Cuernavaca, Mor., México",
      "sameAs": [
        "https://www.facebook.com/Jardepot",
        "https://www.instagram.com/jardepotsade",
        "https://twitter.com/jardepot",
        "https://www.youtube.com/channel/UCym0cCHYeEDqs70RD7Zs2-g"
      ]
    }
    </script>
@endsection
