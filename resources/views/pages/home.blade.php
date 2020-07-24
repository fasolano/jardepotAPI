@extends('pages')

@section('content')
    <div class="row" style="height: 530px !important;">
        <div class="col-xl-5">
            <div class="mb-2 banner divimg"
                 style="background-position-y: inherit;background-image: url('assets/images/banner/podadora.jpg'); flex: 1 1 100%;box-sizing: border-box;max-height: 60%;min-height: 117px;">
                <a style="text-decoration: none; width: 100%;" href="/Equipos/Podadoras">
                    <div class="info" style="place-content: flex-start; align-items: flex-start; flex-direction: row;">
                        <div class="px-2" style="background: rgba(0,0,0,.4);flex-direction: column; box-sizing: border-box; display: flex; place-content: flex-start; align-items: flex-start;">
                            <h2 class="title" style="text-align: left;">Jardinería</h2>
                            <h3 class="subtitle" style="text-align: left;">Un pasto bien cuidado...<br>Comienza con el equipo adecuado.</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="mt-1 banner divimg"
                 style="background-position-y: inherit; background-image: url('assets/images/banner/motocultor.jpg');flex: 1 1 100%; box-sizing: border-box;max-height: 40%;min-height: 117px">
                <a style="text-decoration: none; width: 100%; flex-direction: row; box-sizing: border-box; display: flex;"
                   href="/Equipos/Motocultores">
                    <div class="info" style="place-content: flex-end; align-items: flex-end; flex-direction: row;">
                        <div class="px-2" style="background: rgba(0,0,0,.4);flex-direction: column; box-sizing: border-box; display: flex; place-content: flex-end; align-items: flex-end;">
                            <h2 class="title">Agricultura</h2>
                            <h3 class="subtitle">Tu proyecto merece el mejor respaldo.</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="mt-0 col-xl-7" style="height: 96%">
            <div class="banner divimg" style="background-image: url('assets/images/banner/aspersora.jpg'); order: 2; box-sizing: border-box; max-height: 100%;min-height: 100%;">
                <a style="text-decoration: none; height: 100% !important;" href="/Equipos/Aspersoras">
                    <div class="info" style="place-content: flex-start center;align-items: flex-start;flex-direction: column;">
                        <div class="px-2"
                             style="background: rgba(0,0,0,.4);flex-direction: column; box-sizing: border-box; display: flex; place-content: flex-start center; align-items: flex-start;">
                            <h2 class="title">Aspersoras</h2>
                            <h3 class="subtitle" style="text-align: left;">Para cuidar tu esfuerzo,<br>es bueno contar
                                con el mejor equipo</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @include('components.infoCompra')

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="border shadow p-3 bg-white rounded"
                 style="min-height: 420px">
                <h3>Equipos</h3>
                <div class="col-sm-12">
                    <div class="jd-sublinks-items">
                        <a><i class="material-icons">keyboard_arrow_right</i>Aspersoras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Desbrozadoras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Desinfectantes</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Cortasetos</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Fertilizadoras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Generadores</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Hidrolavadoras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Hoyadoras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Motobombas</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Motocultores</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Motores</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Multifuncionales</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Motosierras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Nebulizadoras</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="height: 100% !important;">
            <div class="border shadow p-3 bg-white rounded" style="min-height: 420px">
                <h3>Marcas</h3>
                <div class="col-sm-12">
                    <div class="jd-sublinks-items">
                        <a><i class="material-icons">keyboard_arrow_right</i>Aspersoras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Desbrozadoras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Desinfectantes</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Cortasetos</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Fertilizadoras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Generadores</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Hidrolavadoras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Hoyadoras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Motobombas</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Motocultores</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Motores</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Multifuncionales</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Motosierras</a>
                        <a><i class="material-icons">keyboard_arrow_right</i>Nebulizadoras</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="height: 100% !important;">
            <div class="border shadow p-3 bg-white rounded" style="min-height: 420px">
                <h3>Otros</h3>
                <div class=" md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header title-card" role="tab" id="headingOne1" style="background-color: #fff;">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1"
                               aria-expanded="true" aria-controls="collapseOne1">
                                <h5 class="mb-0 text-dark">
                                    Accesorios y Consumibles <i class="material-icons">keyboard_arrow_down</i>
                                </h5>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1"
                             data-parent="#accordionEx">
                            <div class="card-body p-0">
                                <div class="col-sm-12">
                                    <div class="jd-sublinks-items">
                                        <a><i class="material-icons">keyboard_arrow_right</i>Aspersoras</a>
                                        <a><i class="material-icons">keyboard_arrow_right</i>Desbrozadoras</a>
                                        <a><i class="material-icons">keyboard_arrow_right</i>Desinfectantes</a>
                                        <a><i class="material-icons">keyboard_arrow_right</i>Cortasetos</a>
                                        <a><i class="material-icons">keyboard_arrow_right</i>Fertilizadoras</a>
                                        <a><i class="material-icons">keyboard_arrow_right</i>Generadores</a>
                                        <a><i class="material-icons">keyboard_arrow_right</i>Hidrolavadoras</a>
                                        <a><i class="material-icons">keyboard_arrow_right</i>Hoyadoras</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                    <div class="card">
                        <div class="card-header title-card" role="tab" id="headingTwo2" style="background-color: #fff;">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2"
                               aria-expanded="false" aria-controls="collapseTwo2">
                                <h5 class="mb-0 text-dark">
                                    Herramientas Manuales<i class="material-icons">keyboard_arrow_down</i>
                                </h5>
                            </a>
                        </div>
                        <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2"
                             data-parent="#accordionEx">
                            <div class="card-body p-0">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad
                                squid. 3
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab" id="headingThree3" style="background-color: #fff;">
                            <a class="collapsed bg-dark title-card" data-toggle="collapse" data-parent="#accordionEx"
                               href="#collapseThree3"aria-expanded="false" aria-controls="collapseThree3">
                                <h5 class="mb-0 text-dark" style="">
                                    Refacciones <i class="material-icons">keyboard_arrow_down</i>
                                </h5>
                            </a>
                        </div>
                        <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3"
                             data-parent="#accordionEx">
                            <div class="card-body p-0">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad
                                squid. 3
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.caruselCanales')

@endsection
