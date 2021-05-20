@php
    $redirectors = [
            route('products', ['equipos', 'motores']) => route('products', ['repuestos-y-consumibles', 'motores']),
            route('products', ['equipos', 'multifuncionales']) => route('products', ['jardineria', 'multifuncionales']),
            route('products', ['equipos', 'tractopodadoras']) => route('products', ['jardineria', 'tractopodadoras']),
            route('products', ['equipos', 'motocultores']) => route('products', ['agricultura', 'motocultores']),
            route('products', ['equipos', 'parihuelas']) => route('products', ['agricultura', 'parihuelas']),
            route('products', ['equipos', 'termonebulizadoras']) => route('products', ['sanitizacion', 'termonebulizadoras']),
            route('products', ['equipos', 'trituradoras']) => route('products', ['agricultura', 'trituradores']),
            route('products', ['equipos', 'nebulizadoras']) => route('products', ['sanitizacion', 'nebulizadoras']),
            route('products', ['equipos', 'hoyadoras']) => route('products', ['agricultura', 'hoyadoras']),
            route('products', ['equipos', 'sopladoras']) => route('products', ['jardineria', 'sopladoras']),
            route('products', ['equipos', 'desbrozadoras']) => route('products', ['jardineria', 'desbrozadoras']),
            route('products', ['equipos', 'podadoras']) => route('products', ['jardineria', 'podadoras']),
            route('products', ['equipos', 'cortasetos']) => route('products', ['jardineria', 'cortasetos']),
            route('products2', ['marcas', 'shindaiwa', 'cortasetos']) => route('products', ['jardineria', 'cortasetos']),
            route('products2', ['marcas', 'kawashima', 'trituradoras']) => route('products', ['agricultura', 'trituradores']),
        ];
@endphp
<div class="accordion" id="accordionSide{{ $id }}">
    @if (isset($filters))
        <div>
            <div id="heading{{ $id."0" }}">
                <h2 class="mb-0">
                    <div class="text-left head-collapse fn-color-jd px-2" data-toggle="collapse" data-target="#collapse{{ $id."0" }}"
                        aria-expanded="false" aria-controls="collapse{{ $id."0" }}">
                        <span>Filtros de {{ucfirst($level2)}}</span>
                        <i class="material-icons">keyboard_arrow_up</i>

                    </div>
                </h2>
            </div>
            <div id="collapse{{ $id."0" }}" class="collapse show px-2">
                <div class="row" style="padding: 3%">
                    <p class="text-center col-12 title-muted">Organizar por {{$textFilter}}:</p>
                    @foreach ($filters as $keyFilter => $itemFilter)
                        @php
                            $url = route('products2', ['categoryLevel1'=> strtolower(str_replace(" ", "-", $level1)),
                                        'categoryLevel2'=> strtolower(str_replace(" ", "-", $level2)), 'categoryLevel3'=> strtolower(str_replace(" ", "-", $itemFilter['name']))]);
                        @endphp
                        @if(strtolower($level1) == "marcas")
                            <div class="text-center col-6 my-1 p-1">
                                <div class="btn-group-toggle filter" data-toggle="buttons">
                                    <a data-val="{{$itemFilter['id']}}" title="{{$itemFilter['name']}}" class="btn btn-secondary btn-sm btn-filter-2 btn-no-border
                                            {{$idFilter == $itemFilter['id']?"active-filter bg-color-jd active":""}}" onclick="function noclick(e) { e.stopPropagation();}"
                                        href="@if(isset($redirectors[$url])){{ $redirectors[$url] }}@else{{ $url }}@endif" >
                                        {{$itemFilter['name']}}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-center col-6 my-1 p-1">
                                <div class="btn-group-toggle filter" data-toggle="buttons">
                                    <label class="btn btn-secondary btn-sm btn-filter btn-no-border" title="{{$itemFilter['name']}}"
                                            style="height: {{strlen($itemFilter['name'])>15?"40":"20"}}px" data-val="{{$itemFilter['id']}}">
                                        <input type="checkbox"> {{$itemFilter['name']}}
                                    </label>
                                </div>
                            </div>
                        @endif
                    @endforeach
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
            {{--    <div id="collapse{{ $id.$loop->iteration }}" class="collapse show px-2">
                    <div class="row">
                        @foreach ($itemLevel1->nivel2 as $keyLevel2 => $itemLevel2)
                            <div class="col-4 px-2">
                                <a href="{{route('products', ['categoryLevel1'=> strtolower(str_replace(" ", "-", $itemLevel1->nombreCategoriaNivel1)),
                                                                'categoryLevel2'=> strtolower(str_replace(" ", "-", $itemLevel2->name))])}}"
                                   class="btn btn-light p-0" style="width: 100%">
                                    <img src="{{asset('assets/images/brands/'.strtolower($itemLevel2->name).'.jpg')}}" alt="{{$itemLevel2->name}}" style="width: 100%">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>--}}
                <div id="collapse{{ $id.$loop->iteration }}" class="collapse show px-2">
                    <div class="row">

                        @foreach ($itemLevel1->nivel2 as $keyLevel2 => $itemLevel2)
                            @php
                                $url = route('products', ['categoryLevel1'=>$itemLevel1->href, 'categoryLevel2'=> $itemLevel2->href]);
                            @endphp
                            <div class="col-6 text-center my-1 p-0">
                                <a href="@if(isset($redirectors[$url])){{ $redirectors[$url] }}@else{{ $url }}@endif"
                                    class="btn bg-color-jd btn-no-border px-0" style="width: 80%; font-size: 14px; white-space: nowrap;" title="{{$itemLevel2->name}}">
                                    {{$itemLevel2->name}}
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
                            @php
                                $url = route('products', ['categoryLevel1'=>$itemLevel1->href, 'categoryLevel2'=> $itemLevel2->href]);
                            @endphp
                            <div class="col-6 text-center my-1 p-0">
                                <a href="@if(isset($redirectors[$url])){{ $redirectors[$url] }}@else{{ $url }}@endif"
                                    class="btn bg-color-jd btn-no-border px-0" style="width: 80%; font-size: 14px; white-space: nowrap;" title="{{$itemLevel2->name}}">
                                    {{$itemLevel2->name}}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
