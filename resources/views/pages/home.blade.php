@extends('pages')

@section('metaData')
    <title>{{ $descriptionLevel2->metatitle}}</title>
    <meta title="{{ $descriptionLevel2->metatitle}}"/>
    <meta name="description" content="{{$descriptionLevel2->metadescription}}">
{{--    <meta name="keywords" content="{{$descriptionLevel2->keywords}}">--}}
    <meta name="googlebot" content="index,follow" />
    <meta name="robots" content="index,follow">

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
       <h1 style="font-size: 23px !important;">Máquinas, accesorios y consumibles de Jardín, Agrícola y Forestal.</h1>
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

    <div class="d-none d-sm-none d-md-block m-3">
        @include('components.infoCompra')
    </div>

{{----}}

    <div class="d-block d-sm-block d-md-none mt-5">
        @include('components.infoCompra')
    </div>

    @include('components.caruselCanales')

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
