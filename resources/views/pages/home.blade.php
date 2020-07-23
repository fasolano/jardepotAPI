@extends('pages')

@section('content')
    <div class="row" style="height: 500px;">
        <div class="col-xl-5">
            <div class="py-2" style="height: 300px;">
                <img src="{{asset('assets/images/banner/podadora.jpg')}}" style="width: 100%; height: 100%;"
                     alt="Podadora">
            </div>
            <div class="py-2" style="height: 200px;">
                <img src="{{asset('assets/images/banner/motocultor.jpg')}}" style="width: 100%; height: 100%;"
                     alt="Motocultor">
            </div>
        </div>
        <div class="col-xl-7 p-2">
            <img src="{{asset('assets/images/banner/aspersora.jpg')}}" style="width: 100%; height: 100%;"
                 alt="Aspersora">
        </div>
    </div>
    @include('components.infoCompra')

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="border shadow p-3 bg-white rounded">
                <h3>Equipos</h3>
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
                    <a>Parihuelas</a>
                    <a>Podadoras</a>
                    <a>Sopladoras</a>
                    <a>Tractopodadoras</a>
                    <a>Trituradoras</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border shadow p-3 bg-white rounded">
                <h3>Marcas</h3>
                <div class="jd-sublinks-items " style="width: 80%">
                    <a><i class="material-icons">keyboard_arrow_right</i>Aspersoras</a>
                    <a><i class="material-icons">keyboard_arrow_right</i>Desbrozadoras</a>
                    <a><i class="material-icons">keyboard_arrow_right</i>Desinfectantes</a>
                    <a><i class="material-icons">keyboard_arrow_right</i>Cortasetos</a>
                    <a>Fertilizadoras</a>
                    <a>Generadores</a>
                    <a>Hidrolavadoras</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border shadow p-3 bg-white rounded">
                <h3>Otros</h3>
                <div class=" md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headingOne1">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true"
                               aria-controls="collapseOne1">
                                <h5 class="mb-0" style="text-decoration: none;">
                                    Collapsible Group Item <i class="material-icons">keyboard_arrow_down</i>
                                </h5>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1"
                             data-parent="#accordionEx">
                            <div class="card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headingTwo2">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2"
                               aria-expanded="false" aria-controls="collapseTwo2">
                                <h5 class="mb-0">
                                    Collapsible Group Item<i class="material-icons">keyboard_arrow_down</i>
                                </h5>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2"
                             data-parent="#accordionEx">
                            <div class="card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headingThree3">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3"
                               aria-expanded="false" aria-controls="collapseThree3">
                                <h5 class="mb-0">
                                    Collapsible Group Item <i class="material-icons">keyboard_arrow_down</i>
                                </h5>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3" data-parent="#accordionEx">
                            <div class="card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            </div>
                        </div>

                    </div>
                    <!-- Accordion card -->
                </div>
                <!-- Accordion wrapper -->
            </div>
        </div>
    </div>

    @include('components.caruselCanales')

@endsection
