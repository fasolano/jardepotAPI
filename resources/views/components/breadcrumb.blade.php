<div id="breadcrumb-route" class="row d-flex pl-2" style="color: rgba(0,0,0,.87); background: rgba(0,0,0,.03);">
    <div class="d-flex align-items-center flex-wrap">
        <i class="material-icons mr-2">home</i>
        <a href="{{route("home")}}"><span>Inicio</span></a>
        <i class="material-icons mr-2">navigate_next</i>
        <span>{{ucfirst($level1)}}</span>
        <i class="material-icons mr-2">navigate_next</i>
        @if(isset($level3))
            <span>{{ucfirst($level2)}}</span>
            <i class="material-icons mr-2">navigate_next</i>
            <b>{{ucfirst($level3)}}</b>
        @else
            <b>{{ucfirst($level2)}}</b>
        @endif
    </div>
    <div class="breadcrumbText" style="font-size: 19px; font-weight: bold; color: #f68600; margin-left: 25px;">
        <ul>
            <li>#QuédateEnCasa Nosotros lo enviamos...</li>
            <li>JarDepot, ¡Tu equipo Siempre Contigo!</li>
            <li>#QuédateEnCasa Nosotros lo enviamos...</li>
        </ul>
    </div>
</div>
