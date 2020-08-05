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
@endsection

@section('content')
    <div class="wrapper">
        <!-- Page Content  -->
        <div id="content" class="row">
            <div class="col-lg-12 col-md-12">
                @if(0 == 0)
                    <div class="table-responsive shadow mb-3">
                        <table class="table  mt-3" style="background-color: #ffffff !important;">
                            <thead>
                            <tr>
                                <th scope="col">Producto</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Total</th>
                                <th scope="col"  class="text-center">
                                    <button class="btn btn-secondary">Borrar todo</button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row"><img style="width: 80px;height: 80px;"
                                                     src="{{asset('assets/images/productos/aspersora-takashi-at26ec.jpg')}}">
                                </th>
                                <td><a style="font-weight: 500;color: #000000" href="{{url('')}}">Aspersora Takashi AT26EC</a></td>
                                <td> $2,575.00</td>
                                <td>
                                    <div>
                                        <button class="btn"><i class="material-icons">add</i></button>
                                        <span>1</span>
                                        <button class="btn"><i class="material-icons">remove</i></button>
                                    </div>
                                </td>
                                <td>$2,575.00</td>
                                <td class="text-center">
                                    <button title="Borrar" class="btn btn-secondary btn-circle">X</button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><img style="width: 80px;height: 80px;"
                                                     src="{{asset('assets/images/productos/aspersora-takashi-at26ec.jpg')}}">
                                </th>
                                <td><a style="font-weight: 500;color: #000000" href="{{url('')}}">Aspersora Takashi AT26EC</a></td>
                                <td> $2,575.00</td>
                                <td>
                                    <div>
                                        <button class="btn"><i class="material-icons">add</i></button>
                                        <span>1</span>
                                        <button class="btn"><i class="material-icons">remove</i></button>
                                    </div>
                                </td>
                                <td>$2,575.00</td>
                                <td class="text-center">
                                    <button title="Borrar" class="btn btn-secondary btn-circle">X</button>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="5" class="text-right">
                                    <span>Subtotal: </span>$2,575.00<br><span>Total: </span>$2,575.00
                                </td>
                                <td></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="row d-none d-sm-none d-md-block m-3"  >
                        <div class="row" style="color: #FFFFFF;">
                            <div class="col-sm-3 text-center">
                                <a class="btn btn-warning">Salir</a>
                            </div>
                            <div class="col-sm-3 text-left">
                                <a class="btn btn-warning" href="javascript: void(0)" data-toggle="modal"
                                   data-target="#modalPayPal">Pagar - PayPal</a>
                            </div>
                            <div class="col-sm-3 text-left">
                                <a class="btn btn-warning" href="javascript: void(0)" data-toggle="modal"
                                   data-target="#modalMercadoPago">Pagar - Mercado Pago</a>
                            </div>
                            <div class="col-sm-3 text-left">
                                <a href="{{url('/checkout')}}" class="btn btn-warning">Pagar - Deposito Bancario</a>
                            </div>
                        </div>
                    </div>
                    <div class="row d-block d-sm-block d-md-none">
                        <div class="col-10 offset-2 text-right m-3">
                            <a class="btn btn-warning btn-block" style="color: #FFFFFF">Salir</a>
                        </div>
                        <div class="col-10 offset-2 text-right m-3" style="color: #FFFFFF">
                            <a class="btn btn-warning btn-block" href="javascript: void(0)" data-toggle="modal"
                               data-target="#modalPayPal">Pagar - PayPal</a>
                        </div>
                        <div class="col-10 offset-2 text-right m-3" style="color: #FFFFFF">
                            <a class="btn btn-warning btn-block" href="javascript: void(0)" data-toggle="modal"
                               data-target="#modalMercadoPago">Pagar - Mercado Pago</a>
                        </div>
                        <div class="col-10 offset-2 text-right m-3" style="color: #FFFFFF">
                            <a href="{{url('/checkout')}}" class="btn btn-warning btn-block" >Pagar - Deposito Bancario</a>
                        </div>
                    </div>

                @else
                    <div style="height: 500px;">
                        <div class="card"
                             style="color: #000000; background-color: #e0e0e0;border-radius: 15px;width: 45%; margin: 22px 0 22px 0;">
                            <span style="padding: 5px">No tienes articulos en tu carrito</span>
                        </div>
                        <a class="btn btn-warning" href="{{url('/')}}">Continuar comprando</a>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Modal PayPal-->
    <div class="modal fade" id="modalPayPal" tabindex="-1" role="dialog" aria-labelledby="modalPayPal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPayPalLabel">Pagar con Paypal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ml-4 mr-4">
                    <div class="row mb-2" style="font-size: 14px;">
                        <div class="col-12">
                            <p>*Se agregará una comisión del 4% por método de pago Paypal</p>
                            <br>
                            <label><input type="checkbox" name="terminosPayPal" id="terminosPayPal">
                                Acepto terminos y condiciones</label>
                            <a href="javascript: void(0)" data-toggle="modal" data-target="#modalCondicionEnvio"
                               style="color: rgba(0, 0, 0, 0.87);">*Consultalos aquí</a>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group"><input class="form-control" id="" name="" placeholder="Nombre(s)*">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group"><input class="form-control" id="" name="" placeholder="Apellidos*">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group"><input class="form-control" id="" name="" placeholder="Email*">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group"><input class="form-control" id="" name=""
                                                           placeholder="Teléfono(10 dígitos)*"></div>
                        </div>
                    </div>
                    <div class="row" style="font-size: 14px;">
                        <div class="col-6">
                            <p class="text-muted">Por favor rellena todos los campos</p>
                            <p class="text-muted">Acepta los terminos y condiciones</p>
                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                </div>
                {{--  <div class="modal-footer">
                      <button type="button" class="btn  bg-color-jd" data-dismiss="modal">Cerrar</button>
                  </div>--}}
            </div>
        </div>
    </div>
    <!-- Modal MercadoPago-->
    <div class="modal fade" id="modalMercadoPago" tabindex="-1" role="dialog" aria-labelledby="modalMercadoPago"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pagar con MercadoPago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2" style="font-size: 14px;">
                        <div class="col-12">
                            <p>*Se agregará una comisión del 4% por método de pago MercadoPago</p>
                            <br>
                            <label><input type="checkbox" name="terminosPayPal" id="terminosPayPal">
                                Acepto terminos y condiciones</label>
                            <a href="javascript: void(0)" data-toggle="modal" data-target="#modalCondicionEnvio"
                               style="color: rgba(0, 0, 0, 0.87);">*Consultalos aquí</a>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group"><input class="form-control" id="" name="" placeholder="Nombre(s)*">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group"><input class="form-control" id="" name="" placeholder="Apellidos*">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group"><input class="form-control" id="" name="" placeholder="Email*">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group"><input class="form-control" id="" name=""
                                                           placeholder="Teléfono (10 dígitos)*"></div>
                        </div>
                        <div class="col-6">
                            <div class="form-group"><input class="form-control" id="" name="" placeholder="Estado*">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group"><input class="form-control" id="" name="" placeholder="Ciudad*">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group"><input class="form-control" id="" name=""
                                                           placeholder="Código postal*"></div>
                        </div>
                        <div class="col-6">
                            <div class="form-group"><input class="form-control" id="" name="" placeholder="Colonia*">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group"><input class="form-control" id="" name="" placeholder="Direccion*">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="font-size: 14px;">
                        <div class="col-6">
                            <p class="text-muted">Por favor rellena todos los campos</p>
                            <p class="text-muted">Acepta los terminos y condiciones</p>
                        </div>
                        <div class="col-6 text-right">
                            <button class="btn btn-warning">Siguiente</button>
                        </div>
                    </div>
                </div>
                {{--  <div class="modal-footer">
                      <button type="button" class="btn  bg-color-jd" data-dismiss="modal">Cerrar</button>
                  </div>--}}
            </div>
        </div>
    </div>
@endsection

@section('specificJS')
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <script src="{{asset('assets/js/components/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/components/sidebar.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/pages/cart.js')}}"></script>


@endsection
