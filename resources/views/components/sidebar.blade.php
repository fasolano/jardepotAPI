

<div class="accordion" id="accordionSide{{ $id }}">
    @if (isset($filters))
        <div>
            <div id="heading{{ $id.$key }}">
                <h2 class="mb-0">
                    <div class="text-left head-collapse fn-color-jd px-2" data-toggle="collapse" data-target="#collapse1"
                         aria-expanded="true" aria-controls="collapse1">
                        <span>Filtros de Aspersoras</span>
                        <i class="material-icons">keyboard_arrow_up</i>

                    </div>
                </h2>
            </div>
            <div id="collapse1" class="collapse show px-2" aria-labelledby="heading1" data-parent="#accordionSide{{ $id }}">
                <div class="row">
                    <p class="text-center col-12 title-muted">Organizar por ... :</p>
                    <div class="text-center col-6 my-1">
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                                <input type="checkbox"> Takashi
                            </label>
                        </div>
                    </div>
                    <div class="text-center col-6 my-1">
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                                <input type="checkbox"> Takashi
                            </label>
                        </div>
                    </div>
                    <div class="text-center col-6 my-1">
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                                <input type="checkbox"> Takashi
                            </label>
                        </div>
                    </div>
                    <div class="text-center col-6 my-1">
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                                <input type="checkbox"> Takashi
                            </label>
                        </div>
                    </div>
                    <div class="text-center col-6 my-1">
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                                <input type="checkbox"> Takashi
                            </label>
                        </div>
                    </div>
                    <div class="text-center col-6 my-1">
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                                <input type="checkbox"> Takashi
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @foreach ($sections as $keyLevel1 => $itemLevel1)
        {{-- Si es la iteción es la 2 significa que la vista es de brand y los botones deben cambiar --}}
        @if ($loop->iteration == 2)
            <div>
                <div id="heading{{ $id.$loop->iteration }}">
                    <h2 class="mb-0">
                        <div class="text-left head-collapse collapsed fn-color-jd px-2" data-toggle="collapse"
                             data-target="#collapse{{ $id.$loop->iteration }}" aria-expanded="false" aria-controls="collapse{{ $id.$loop->iteration }}">
                            <span>Secciones de {{$itemLevel1->nombreCategoriaNivel1}}</span>
                            <i class="material-icons">keyboard_arrow_up</i>
                        </div>
                    </h2>
                </div>
                <div id="collapse{{ $id.$loop->iteration }}" class="collapse show px-2">
                    <div class="row">
                        @foreach ($itemLevel1->nivel2 as $keyLevel2 => $itemLevel2)
                            <div class="col-4 px-2">
                                <a href="{{route('products', ['categoryLevel1'=> strtolower($itemLevel1->nombreCategoriaNivel1), 'categoryLevel2'=> strtolower($itemLevel2->name)])}}"
                                   class="btn btn-light p-0" style="width: 100%">
                                    <img src="{{asset('assets/images/brands/'.strtolower($itemLevel2->name).'.jpg')}}" alt="shindaiwa" style="width: 100%">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div>
                <div id="heading{{ $id.$loop->iteration }}">
                    <h2 class="mb-0">
                        <div class="text-left head-collapse collapsed fn-color-jd px-2" data-toggle="collapse"
                             data-target="#collapse{{ $id.$loop->iteration }}" aria-expanded="false" aria-controls="collapse{{ $id.$loop->iteration }}">
                            <span>
                                @if ($loop->iteration == 1)
                                    Secciones por
                                @endif
                                {{$itemLevel1->nombreCategoriaNivel1}}
                            </span>
                            <i class="material-icons">keyboard_arrow_up</i>
                        </div>
                    </h2>
                </div>
                <div id="collapse{{ $id.$loop->iteration }}" class="collapse show px-2">
                    <div class="row">
                        @foreach ($itemLevel1->nivel2 as $keyLevel2 => $itemLevel2)
                            <div class="col-6 text-center my-1 p-0">
                                <a href="{{route('products', ['categoryLevel1'=> strtolower($itemLevel1->nombreCategoriaNivel1), 'categoryLevel2'=> strtolower($itemLevel2->name)])}}"
                                   class="btn bg-color-jd btn-no-border px-0" style="width: 80%; font-size: 15px; white-space: nowrap;">
                                    {{$itemLevel2->name}}
                                </a>
                            </div>
                        @endforeach
                        {{--<div class="col-6 text-center my-1 p-0">
                            <button type="button" class="btn bg-color-jd btn-no-border">Small button</button>
                        </div>--}}
                    </div>
                </div>
            </div>
        @endif
    @endforeach


    {{--<div>
        <div id="heading{{ $id.$key }}">
            <h2 class="mb-0">
                <div class="text-left head-collapse fn-color-jd px-2" data-toggle="collapse" data-target="#collapse1"
                     aria-expanded="true" aria-controls="collapse1">
                    <span>Filtros de Aspersoras</span>
                    <i class="material-icons">keyboard_arrow_up</i>

                </div>
            </h2>
        </div>
        <div id="collapse1" class="collapse show px-2" aria-labelledby="heading1" data-parent="#accordionSide{{ $id }}">
            <div class="row">
                <p class="text-center col-12 title-muted">Organizar por ... :</p>
                <div class="text-center col-6 my-1">
                    <div class="btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                            <input type="checkbox"> Takashi
                        </label>
                    </div>
                </div>
                <div class="text-center col-6 my-1">
                    <div class="btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                            <input type="checkbox"> Takashi
                        </label>
                    </div>
                </div>
                <div class="text-center col-6 my-1">
                    <div class="btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                            <input type="checkbox"> Takashi
                        </label>
                    </div>
                </div>
                <div class="text-center col-6 my-1">
                    <div class="btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                            <input type="checkbox"> Takashi
                        </label>
                    </div>
                </div>
                <div class="text-center col-6 my-1">
                    <div class="btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                            <input type="checkbox"> Takashi
                        </label>
                    </div>
                </div>
                <div class="text-center col-6 my-1">
                    <div class="btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary btn-sm btn-filter btn-no-border">
                            <input type="checkbox"> Takashi
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div id="heading2">
            <h2 class="mb-0">
                <div class="text-left head-collapse collapsed fn-color-jd px-2" data-toggle="collapse"
                     data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                    <span>Secciones por tipo de producto</span>
                    <i class="material-icons">keyboard_arrow_up</i>
                </div>
            </h2>
        </div>
        <div id="collapse2" class="collapse show px-2" aria-labelledby="heading2" data-parent="#accordionSide{{ $id }}">
            <div class="row">
                <div class="col-6 text-center my-1 p-0">
                    <button type="button" class="btn bg-color-jd btn-no-border">Small button</button>
                </div>
                <div class="col-6 text-center my-1 p-0">
                    <button type="button" class="btn bg-color-jd btn-no-border">Small button</button>
                </div>
                <div class="col-6 text-center my-1 p-0">
                    <button type="button" class="btn bg-color-jd btn-no-border">Small button</button>
                </div>
                <div class="col-6 text-center my-1 p-0">
                    <button type="button" class="btn bg-color-jd btn-no-border">Small button</button>
                </div>
                <div class="col-6 text-center my-1 p-0">
                    <button type="button" class="btn bg-color-jd btn-no-border">Small button</button>
                </div>
                <div class="col-6 text-center my-1 p-0">
                    <button type="button" class="btn bg-color-jd btn-no-border">Small button</button>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div id="heading3">
            <h2 class="mb-0">
                <div class="text-left head-collapse collapsed fn-color-jd px-2" data-toggle="collapse"
                     data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                    <span>Filtros de Aspersoras</span>
                    <i class="material-icons">keyboard_arrow_up</i>
                </div>
            </h2>
        </div>
        <div id="collapse3" class="collapse show px-2" aria-labelledby="heading3" data-parent="#accordionSide{{ $id }}">
            <div class="row">
                <div class="col-4 px-2">
                    <button type="button" class="btn btn-light p-0" style="width: 100%">
                        <img src="{{asset('assets/images/brands/shindaiwa.jpg')}}" alt="shindaiwa" style="width: 100%">
                    </button>
                </div>
                <div class="col-4 px-2">
                    <button type="button" class="btn btn-light p-0" style="width: 100%">
                        <img src="{{asset('assets/images/brands/shindaiwa.jpg')}}" alt="shindaiwa" style="width: 100%">
                    </button>
                </div>
                <div class="col-4 px-2">
                    <button type="button" class="btn btn-light p-0" style="width: 100%">
                        <img src="{{asset('assets/images/brands/shindaiwa.jpg')}}" alt="shindaiwa" style="width: 100%">
                    </button>
                </div>
            </div>
        </div>
    </div>--}}
</div>
