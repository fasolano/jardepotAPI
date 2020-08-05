
@extends('pages')

@section('metaData')
    <title>Tu carrito Jardepot</title>
    <meta title=""/>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('specificCSS')
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.css')}}">
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <style>

        nav > .nav.nav-tabs{

            border: none;
            color:#f68600;
            background:#fff;
            border-radius:0;

        }
        nav > div a.nav-item.nav-link,
        nav > div a.nav-item.nav-link.active
        {
            border: none;
            padding: 18px 25px;
            color:#f68600;
            background:#fff;
            border-radius:0;
        }

        nav > div a.nav-item.nav-link.active:after
        {
            content: "";
            position: relative;
            bottom: -60px;
            left: -10%;
            border: 15px solid transparent;
            border-top-color: #e74c3c ;
        }
        .tab-content{
            background: #fdfdfd;
            line-height: 23px;
            border: 1px solid #ddd;
            border-top:5px solid #e74c3c;
            /*border-bottom:5px solid #e74c3c;*/
            padding:30px 25px;
        }

        nav > div a.nav-item.nav-link:hover,
        nav > div a.nav-item.nav-link:focus
        {
            border: none;
            background: #e74c3c;
            color:#fff;
            border-radius:0;
            transition:background 0.20s linear;
        }
    </style>
@endsection

@section('content')
    <div class="wrapper">

        <!-- Page Content  -->
        <div id="content" class="row">
            <div class="col-lg-12 col-md-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">DATOS DE ENVIO</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">MÉTODO DE ENTREGA</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">VISTA PREVIA DE LA ORDEN</a>
                        <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">CONFIRMACIÓN</a>
                    </div>
                </nav>
                <div class="tab-content py-3 px-3 px-sm-0 shadow" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row m-2">
                            <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Nombre(s)*"></div></div>
                            <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Apellidos*"></div></div>
                            <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Email*"></div></div>
                            <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Teléfono*"></div></div>
                            <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Estado*"></div></div>
                            <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Ciudad/Municipio*"></div></div>
                            <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Código postal*"></div></div>
                            <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Colonia*"></div></div>
                            <div class="col-md-12"><div class="form-group"><input type="text" class="form-control" placeholder="Dirección*"></div></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row m-2">
                            <label><input type="radio" name="entrega"><span>&nbsp;</span><b>Envio a domicilio</b> $300.00 MXN / Entrega de 2 a 6 días hábiles *Compras mayores a $3,000.00 gratis y en área de cobertura</label>
                            <label><input type="radio" name="entrega"><span>&nbsp;</span><b>Entrega en sucursal Cuernavaca</b> GRATIS / Entrega de 1 a 2 días hábiles *En algunos casos la entrega puede extenderse hasta 7 días hábiles en cuyo caso se lo haremos saber de inmediato.</label>
                            <label><input type="radio" name="entrega"><span>&nbsp;</span><b>Entrega en sucursal Pachuca</b> GRATIS / Entrega de 1 a 2 días hábiles *En algunos casos la entrega puede extenderse hasta 7 días hábiles en cuyo caso se lo haremos saber de inmediato.</label>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="container m-2">
                            <div class="table-responsive">
                                <table class="table mt-3" style="background-color: #ffffff !important;">
                                    <thead>
                                    <tr>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row"><img style="width: 60px;height: 60px;"
                                            src="{{asset('assets/images/productos/aspersora-takashi-at26ec.jpg')}}">
                                        </th>
                                        <td>Aspersora Takashi AT26EC</td>
                                        <td> $2,575.00</td>
                                        <td><span>1</span></td>
                                        <td>$2,575.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <span>Subtotal: </span>
                                        </td>
                                        <td>$2,575.00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <h3>Método de envío</h3>
                                <div class="divider"></div>
                                <br>
                                <p class="py-1">Envio a domicilio <span class="text-muted">$300.00 MXN / Entrega de 2 a 6 días hábiles *Compras mayores a $3,000.00 gratis y en área de cobertura</span></p>
                                <p class="py-1">Entrega en sucursal Cuernavaca <span class="text-muted"> GRATIS / Entrega de 1 a 2 días hábiles *En algunos casos la entrega puede extenderse hasta 7 días hábiles en cuyo caso se lo haremos saber de inmediato.</span></p>
                                <p class="py-1">Entrega en sucursal Pachuca <span class="text-muted">GRATIS / Entrega de 1 a 2 días hábiles *En algunos casos la entrega puede extenderse hasta 7 días hábiles en cuyo caso se lo haremos saber de inmediato.</span></p>
                            </div>
                            <div class="row">
                                <h2><span class="text-muted">Precio Total: </span><span>$13,000.00</span></h2>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('specificJS')
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <script src="{{asset('assets/js/components/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/sidebar.js')}}"></script>

@endsection
