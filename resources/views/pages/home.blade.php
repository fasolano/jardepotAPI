@extends('pages')

@section('metaData')
    <title>{{ $descriptionLevel2->metatitle}}</title>
    <meta title="{{ $descriptionLevel2->metatitle}}"/>
    <meta name="description" content="{{$descriptionLevel2->metadescription}}">
    <meta name="keywords" content="{{$descriptionLevel2->keywords}}">

    <meta property="og:title" content="{{ $descriptionLevel2->metatitle}}" />
    <meta property="og:description" content="{{ $descriptionLevel2->metadescription}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.jardepot.com/" />
    <meta property="og:image" content="{{asset('img/logos/logoOG.jpg')}}" />
    <meta property="og:image:url" content="{{asset('img/logos/logoOG.jpg')}}" />
    <meta property="og:image:secure_url" content="{{asset('img/logos/logoOG.jpg')}}" />
@endsection

@section('content')
    <div class="row shadow border border-light p-3 bg-white m-1 mt-3 rounded">
       <h1 style="font-size: 23px !important;">Máquinas, accesorios y consumibles de Jardín, Agrícola y Forestal.</h1>
    </div>
    <div class="d-none d-md-block d-lg-block">
        <div class="row div-banners">
            <div class="col-xl-5 pr-0">
                <div class="mb-2 banner divimg" id="banner1"
                     style="background-position-y: inherit;box-sizing: border-box;max-height: 60%;background-position:right">
                    <a style="text-decoration: none; width: 100%;" href="{{url('equipos/podadoras')}}">
                        <div class="info" style="place-content: flex-start; align-items: flex-start; flex-direction: row;">
                            <div class="px-2" style="background: rgba(0,0,0,.4);flex-direction: column; box-sizing: border-box; display: flex; place-content: flex-start; align-items: flex-start;">
{{--                                <h2 class="title" style="text-align: left;">Jardinería</h2>--}}
{{--                                <h3 class="subtitle" style="text-align: left;">Un pasto bien cuidado...<br>Comienza con el equipo adecuado.</h3>--}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="mt-1 banner divimg" id="banner2"
                     style="background-position-y: inherit; box-sizing: border-box;max-height: 40%;background-position:right">
                    <a style="text-decoration: none; width: 100%; flex-direction: row; box-sizing: border-box; display: flex;" href="{{url('equipos/motocultores')}}">
                        <div class="info" style="place-content: flex-end; align-items: flex-end; flex-direction: row;">
                            <div class="px-2" style="background: rgba(0,0,0,.4);flex-direction: column; box-sizing: border-box; display: flex; place-content: flex-end; align-items: flex-end;">
{{--                                <h2 class="title">Agricultura</h2>--}}
{{--                                <h3 class="subtitle">Tu proyecto merece el mejor respaldo.</h3>--}}
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
{{--                                <h3 class="subtitle" style="text-align: left;">9% de descuento en toda la tienda<br>del 13 al 23 de octubre</h3>--}}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center mt-4 d-block d-sm-block d-md-none ">
        <div class="col-12">
        <div class="col-9 col-offset-2">
            <a href="{{url('ofertas')}}">
            <img src="{{asset('assets/images/banner/banner3-mob.jpg')}}" style="width: 310px" alt="oferta" title="Banner Oferta Jardepot">
                <div class="info" style="margin-top: -150px">
                    <div class="px-2" style="background: rgba(0,0,0,.4);flex-direction: column; box-sizing: border-box; display: flex; place-content: flex-end center; align-items: flex-start;">
                        <h2 class="title">Ofertas</h2>
                    </div>
                </div>
            </a>
        </div>
        </div>
        <div class="col-12"><br><br></div>
    </div>

    <div class="d-none d-sm-none d-md-block">
        @include('components.infoCompra')
    </div>

    <div class="row mt-4">
        @foreach($menuAdditional as $key => $cat1)
            @if($key < 2)
                <div class="col-md-4">
                    <div class="border shadow p-3 bg-white rounded div-sublinks">
                        <h3>{{$cat1['nivel1']}}</h3>
                        <div class="col-sm-12">
                            <div class="jd-sublinks-items">
                                @foreach($cat1['nivel2'] as $categoria2)
                                    <a href="{{url($categoria2['href'])}}" class="my-1"><i class="material-icons">keyboard_arrow_right</i>{{$categoria2['name']}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @if($key == 2)
                    <div class="col-md-4">
                        <div class="border shadow p-3 bg-white rounded div-sublinks">
                            <h3>Otros</h3>
                            <div class="md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                @endif
                            <!-- Accordion card -->
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="card-header title-card" role="tab" id="headingOne{{$key}}"
                                         style="background-color: #fff;">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne{{$key}}"
                                           aria-expanded="true" aria-controls="collapseOne{{$key}}">
                                            <h5 class="mb-0 text-dark">
                                                {{$cat1['nivel1']}} <i class="material-icons">keyboard_arrow_down</i>
                                            </h5>
                                        </a>
                                    </div>
                                    <!-- Card body -->
                                    <div id="collapseOne{{$key}}" class="collapse {{$key == 2?'show':''}}" role="tabpanel"
                                         aria-labelledby="headingOne{{$key}}" data-parent="#accordionEx">
                                        <div class="card-body p-0">
                                            <div class="col-sm-12">
                                                <div class="jd-sublinks-items">
                                                    @foreach($cat1['nivel2'] as $key2 => $categoria2)
                                                        <a href="{{url($categoria2['href'])}}" class="my-1">
                                                            <i class="material-icons">keyboard_arrow_right</i>{{$categoria2['name']}}
                                                        </a>
                                                    @endforeach
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
      "url": "http://jardepot.com",
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
