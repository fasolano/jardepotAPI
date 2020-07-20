{{--
    --}}

<nav class="sticky-top navbar-dark bg-dark navbar-heigth container-fluid">
    <div class="row justify-content-md-center flex-column align-items-center">
        <div class="div-navbar col-xl-9 col-lg-11">
            <div class="row" style="color: white;">
                <div class="col-4 font-weight-bold" style="font-size: 25px;">
                    Llámanos al:
                    <a href="tel:8002129225" style="text-decoration: none; color: white;">
                        <i class="material-icons mr-2">local_phone</i>(800)212 9225
                    </a>
                </div>
                <div class="col-7 d-flex">
                    <div class="col-4">CDMX:<br>(55) 4996 8849</div>
                    <div class="col-4">GDL:<br>(33) 1728 3353</div>
                    <div class="col-4">EDOMX:<br>(722) 648 1040</div>
                </div>
                <div class="col-1">
                    <span>+</span>
                    <i class="material-icons mr-2">local_phone</i>
                </div>
                {{--            <div>Más teléfonos</div>--}}

            </div>
        </div>
        <div>
            <a class="navbar-brand" href="#"><img class="logo-navbar" src="{{asset('img/logos/logoJardepot.png')}}"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample06" aria-controls="navbarsExample06" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExample06">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        {{--                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
                    </li>
                </ul>
                <form class="form-inline my-2 my-md-0">
                    <input class="form-control" type="text"  placeholder="Search">
                </form>
            </div>
        </div>
    </div>

</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-xl">
{{--        <a class="navbar-brand" href="#">Container XL</a>--}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07XL" aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07XL">
            <ul class="navbar-nav mr-auto">
{{--                <li class="nav-item active">--}}
{{--                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
{{--                </li>--}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown07XL" data-toggle="dropdown" aria-expanded="false">Agricultura</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown07XL">
                        <a class="dropdown-item" href="#">Action</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown07XL" data-toggle="dropdown" aria-expanded="false">Sanitizacion</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown07XL">
                        <a class="dropdown-item" href="#">Action</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown07XL" data-toggle="dropdown" aria-expanded="false">Jardinería</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown07XL">
                        <a class="dropdown-item" href="#">Action</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown07XL" data-toggle="dropdown" aria-expanded="false">construccion</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown07XL">
                        <a class="dropdown-item" href="#">Action</a>
                    </div>
                </li>
            </ul>
            <a class="mr-2 nav-link btn btn-danger" href="#">Ofertas</a>
            <a class="mr-2 nav-link btn btn-success" href="#">Whatsapp</a>
            <a class="mr-2 nav-link btn btn-warning" href="#">Refacciones</a>
        </div>
    </div>
</nav>

{{--
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Never expand</a>
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbarsExample01" style="">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-md-0">
            <input class="form-control" type="text" placeholder="Search" aria-label="Search">
        </form>
    </div>
</nav>
--}}
