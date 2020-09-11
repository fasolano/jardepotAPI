@extends('pages')


@section('metaData')
    <title>Tu carrito Jardepot</title>
    <meta title="Tu carrito Jardepot"/>
    <meta name="description" content="Tu carrito Jardepot">
    <meta name="keywords" content="Carrito, Jardepot">
    <meta name="robots" content="noindex">
@endsection

@section('specificCSS')
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/components/breadcrumb.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pages/cart.css')}}">
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <!--<script src="https://www.paypal.com/sdk/js?client-id=AXYsm9VJ1VvDrdy5xzQHHJBnnhuhEKcFWhhFPkXBZI9V-G4CmfiXDpNh2DaKT06EaWDFnqWG_1z5ztbi&currency=MXN"></script>-->
    <script src="https://www.paypal.com/sdk/js?client-id=AU1Jzf7ziTCncrNsNBjmk_tD03Iz_1o8J4FNGTh5Z2mYHRSV21eh6rQbPDiQgOzTFiVXFmLdtzT4XzI_&currency=MXN"></script>
@endsection

@section('content')
    <div class="wrapper">
        <!-- Page Content  -->
        <div id="content" class="row my-3">

            <div class="col-lg-12 col-md-12">
                <div id="cart-content" class="border shadow bg-white rounded d-lg-block px-2">
                    <div class="row m-3 d-block d-md-none" style="color: #FFFFFF;">
                        <div class="col-md-3 text-center my-2">
                            <a class="btn btn-warning" href="{{url('/')}}">Seguir comprando</a>
                        </div>
                        <div class="col-md-3 text-center my-2">
                            <a class="btn btn-warning btn-modal-paypal" href="javascript: void(0)" data-toggle="modal"
                               data-target="#modalPayPal">Pagar con tarjeta</a>
                        </div>
                        <div class="col-md-3 text-center my-2">
                            <a class="btn btn-warning" href="javascript: void(0)" data-toggle="modal"
                               data-target="#modalMercadoPago">Pagar con tarjeta en Mensualidades</a>
                        </div>
                        <div class="col-md-3 text-center my-2">
                            <a href="{{url('/checkout')}}" class="btn btn-warning">Pagar con transferencia o depósito bancario</a>
                        </div>
                    </div>
                    <h1 class="text-center my-2">Carrrito de compra</h1>
                    <div id="no-more-tables">
                        <table class="table col-sm-12 table-condensed cf">
                            <thead class="cf">
                            <tr>
                                <th>Producto</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th class="text-center">
                                    <button class="btn btn-secondary" id="remove-all-products">Borrar todo</button>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="table-body">
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-center justify-content-md-end">
                        <div class="col-3">
                            <h3>Total: <span id="total-final"></span></h3>
                        </div>
                    </div>
                    <div class="row m-3" style="color: #FFFFFF;">
                        <div class="col-md-3 text-center my-2">
                            <a class="btn btn-warning" href="{{url('/')}}">Seguir comprando</a>
                        </div>
                        <div class="col-md-3 text-center my-2">
                            <a class="btn btn-warning btn-modal-paypal" href="javascript: void(0)" data-toggle="modal"
                               data-target="#modalPayPal">Pagar con tarjeta</a>
                        </div>
                        <div class="col-md-3 text-center my-2">
                            <a class="btn btn-warning btn-modal-mercado" href="javascript: void(0)" data-toggle="modal"
                               data-target="#modalMercadoPago">Pagar con tarjeta en Mensualidades</a>
                        </div>
                        <div class="col-md-3 text-center my-2">
                            <a href="{{url('/checkout')}}" class="btn btn-warning">Pagar con transferencia o depósito bancario</a>
                        </div>
                    </div>
                </div>

                <div id="no-cart-content" style="height: 500px; display: none;">
                    <div class="card" style="color: #000000; background-color: #e0e0e0;border-radius: 15px;width: 45%; margin: 22px 0 22px 0;">
                        <span style="padding: 5px">No tienes articulos en tu carrito</span>
                    </div>
                    <a class="btn btn-warning" href="{{url('/')}}">Continuar comprando</a>
                </div>

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
                    <form id="form-paypal">
                    <div class="row mb-2" style="font-size: 14px;">
                        <div class="col-12">
                            <p></p>
                            <br>
                            <label><input type="checkbox" name="terminosPayPal" id="terminosPayPal">
                                Acepto terminos y condiciones</label>
                            <a href="javascript: void(0)" data-toggle="modal" data-target="#modalCondicionEnvio"
                               style="color: rgba(0, 0, 0, 0.87);"><b>*Consultalos aquí</b></a>
                            <br>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input id="name-paypal" class="form-control" maxlength="70" name="firstName" placeholder="Nombre(s)*">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input id="lastname-paypal"  class="form-control" maxlength="70" name="lastName" placeholder="Apellidos*">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input id="email-paypal"  class="form-control" maxlength="40" name="email" placeholder="Email*">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input id="phone-paypal"  class="form-control" minlength="10" maxlength="10" name="phone" placeholder="Teléfono(10 dígitos)*">
                                </div>
                            </div>
                        </div>
                    <div class="row" style="font-size: 14px;">
                        <div id="form-complete" class="col-12" style="display: none;">
                            <div id="paypal-button-container"></div>
                            {{--<button type="submit" class="btn bg-color-jd">Siguiente</button>--}}
                        </div>
                        <div id="form-incomplete" class="col-12">
                            <p id="text-input-paypal" class="text-muted">Por favor rellena todos los campos</p>
                            <p id="text-terms-paypal" class="text-muted">Acepta los terminos y condiciones</p>
                        </div>
                    </div>
                    </form>
                </div>
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
                            <p>*Se agregará una comisión diferente de acuerdo al plazo seleccionado para el pago</p>
                            <br>
                            <label><input type="checkbox" name="terminosPayPal" id="terminosMP">
                                Acepto terminos y condiciones</label>
                            <a href="javascript: void(0)" data-toggle="modal" data-target="#modalCondicionEnvio"
                               style="color: rgba(0, 0, 0, 0.87);">*Consultalos aquí</a>
                            <br>
                        </div>
                    </div>
                    <form id="form-mp">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="name-mp" name="name" placeholder="Nombre(s)*">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="lastname-mp" name="lastName" placeholder="Apellidos*">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="email-mp" name="email" placeholder="Email*">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="phone-mp" name="phone" maxlength="10" placeholder="Teléfono (10 dígitos)*"></div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="state-mp" name="state" placeholder="Estado*">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="city-mp" name="city" placeholder="Ciudad*">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="zip-mp" name="zipCode" placeholder="Código postal*"></div>
                            </div>
                            <div class="col-6">
                                <div class="form-group"><input class="form-control" id="suburb-mp" name="suburb" placeholder="Colonia*">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group"><input class="form-control" id="address-mp" name="address" placeholder="Direccion*">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row" style="font-size: 14px;">
                        <div id="form-incomplete-mp" class="col-12">
                            <p id="text-input-mp" class="text-muted">Por favor rellena todos los campos</p>
                            <p id="text-terms-mp" class="text-muted">Acepta los terminos y condiciones</p>
                        </div>
                        <div id="form-complete-mp" class="col-12 text-right" style="display: none;">
                            <button class="btn btn-warning" type="button" id="btn-mercado-pago">Siguiente</button>
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
