@extends('pages')

@section('metaData')
    <title>Tu carrito Jardepot - Checkout</title>
    <meta title="Tu carrito Jardepot - Checkout"/>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('specificCSS')
    <!-- Scrollbar Custom CSS -->
    <script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/pages/checkout.css')}}">
@endsection

@section('content')
    <div class="wrapper">
        <!-- Page Content  -->
        <div id="content" class="row">
            <div class="col-lg-12 col-md-12 mt-3 mb-4">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-client-tab" data-toggle="tab" href="#nav-client"
                           role="tab" aria-controls="nav-client" aria-selected="true">DATOS DE ENVIO</a>
                        <a class="nav-item nav-link" id="nav-envio-tab" data-toggle="tab" href="#nav-envio"
                           role="tab" aria-controls="nav-envio" aria-selected="false">MÉTODO DE ENTREGA</a>
                        <a class="nav-item nav-link" id="nav-orden-tab" data-toggle="tab" href="#nav-orden"
                           role="tab" aria-controls="nav-orden" aria-selected="false">VISTA PREVIA DE LA ORDEN</a>
                        <a class="nav-item nav-link" id="nav-confirmation-tab" data-toggle="tab"
                           href="#nav-confirmation" role="tab"
                           aria-controls="nav-confirmation" aria-selected="false">CONFIRMACIÓN</a>
                    </div>
                </nav>
                <div class="tab-content pt-3 py-3 px-3 px-sm-0 shadow" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-client" role="tabpanel"
                         aria-labelledby="nav-client-tab">
                        <form id="form-create-cliente" action="javascript:void(0)">
                            <div class="row justify-content-center  m-2 ">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="firstName" name="firstName"
                                               placeholder="Nombre(s)*" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="lastName" name="lastName"
                                               placeholder="Apellidos*" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="email" name="email"
                                               placeholder="Email*" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="phone" name="phone"
                                               placeholder="Teléfono*" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="state" name="state"
                                               placeholder="Estado*" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="city" name="city"
                                               placeholder="Ciudad/Municipio*" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="zip" name="zip"
                                               placeholder="Código postal*" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="suburb" name="suburb"
                                               placeholder="Colonia*" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="address" name="address"
                                               placeholder="Dirección*" required>
                                    </div>
                                </div>
                                <div class="row justify-content-center ">
                                    <button type="submit" class="btn btn-dark btn-sm" style="border-radius: 20px"><i
                                            class="material-icons">navigate_next</i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-envio" role="tabpanel" aria-labelledby="nav-envio-tab">
                        <form id="form-create-envio" action="javascript:void(0)">
                            <div class="row justify-content-center m-2">
                                <div class="col-md-12">
                                    <label><input type="radio" id="opcionEntrega1" name="delivery"
                                                  value="domicilio">&nbsp;<b>Envio a domicilio</b>
                                        <span id="costo-entrega"></span> MXN / Entrega de 2 a 6 días hábiles *Compras mayores a <span id="minima-compra"></span> gratis
                                        y en área de cobertura</label>
                                    <label><input type="radio" id="opcionEntrega2" name="delivery"
                                                  value="cuernavaca"><span>&nbsp;</span><b>Entrega en sucursal
                                            Cuernavaca</b> GRATIS / Entrega de 1 a 2 días hábiles *En algunos casos la
                                        entrega puede extenderse hasta 7 días hábiles en cuyo caso se lo haremos saber
                                        de inmediato.</label>
                                    <label id="delivery-error" class="error" for="delivery"></label>
                                    <div class="row justify-content-center ">
                                        <button class="btn btn-dark btn-sm" style="border-radius: 20px" onclick="tabCliente()">
                                            <i class="material-icons">navigate_before</i></button>&nbsp;
                                        <button type="submit" class="btn btn-dark btn-sm" style="border-radius: 20px"><i
                                                class="material-icons">navigate_next</i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-orden" role="tabpanel" aria-labelledby="nav-orden-tab">
                        <div class="container m-2 p-3">
                            <div class="table-responsive">
                                <table class="table mt-3" style="background-color: #ffffff !important;">
                                    <thead>
                                    <tr>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col" class="text-center">Precio</th>
                                        <th scope="col" class="text-center">Cantidad</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody id="body-tr">

                                    </tbody>
                                </table>
                            </div>
                            <div class="row m-1">
                                <div class="col-md-12">
                                    <h3 class="title-card">Método de envío</h3>
                                    <div class="divider"></div>
                                </div>
                                <div class="col-md-12">
                                    <div id="metodoEnvio">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center ">
                                <h2><span class="text-muted">Precio Total: </span><span id="totalCheck"></span></h2>
                            </div>
                            <div class="row">
                                <h3 class="text-muted mt-2">Datos de envio</h3>
                                <div class="col-md-12">
                                    <label>
                                        <input type="checkbox" name="facturar" id="facturar"
                                               onclick="checkFactura()">&nbsp;Agregar datos de facturación</label>
                                </div>
                                <div class="col-md-3 text-direccion">
                                    <p class="text-muted">Nombre:</p>
                                    <p id="nombreCheck"></p>
                                </div>
                                <div class="col-md-3 text-direccion">
                                    <p class="text-muted">Correo electrónico:</p>
                                    <p id="correoCheck"></p>
                                </div>
                                <div class="col-md-3 text-direccion">
                                    <p class="text-muted">Teléfono:</p>
                                    <p id="telefonoCheck"></p>
                                </div>
                                <div class="col-md-3 text-direccion">
                                    <p class="text-muted">Estado:</p>
                                    <p id="estadoCheck"></p>
                                </div>
                                <div class="col-md-3 text-direccion">
                                    <p class="text-muted">Ciudad:</p>
                                    <p id="ciudadCheck"></p>
                                </div>
                                <div class="col-md-3 text-direccion">
                                    <p class="text-muted">Código postal:</p>
                                    <p id="cpCheck"></p>
                                </div>
                                <div class="col-md-3 text-direccion">
                                    <p class="text-muted">Colonia:</p>
                                    <p id="coloniaCheck"></p>
                                </div>
                                <div class="col-md-3 text-direccion">
                                    <p class="text-muted">Dirección:</p>
                                    <p id="direccionCheck"></p>
                                </div>
                            </div>
                            <div id="div-factura" class="row">
                                <form id="form-create-factura" action="javascript:void(0)">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tipoPersona">Tipo de persona</label>
                                                <select class="form-control" id="tipoPersona" name="tipoPersona">
                                                    <option value="fisica">Persona Física</option>
                                                    <option value="moral">Persona Moral</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="usoCFDI">Uso de CFDI*</label>
                                                <select class="form-control" id="usoCFDI" name="usoCFDI">
                                                    <option value="G01 Adquisición de mercancías">G01 Adquisición de
                                                        mercancías
                                                    </option>
                                                    <option value="G03 Gastos en general">G03 Gastos en general</option>
                                                    <option value="I08 Otra maquinaria y equipo">I08 Otra maquinaria y
                                                        equipo
                                                    </option>
                                                    <option value="P01 Por definir">P01 Por definir</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="formaPago">Forma de pago*</label>
                                                <select class="form-control" id="formaPago" name="formaPago">
                                                    <option value="01 Efectivo">Deposito en ventanilla con efectivo
                                                    </option>
                                                    <option value="02 Cheque nominativo">Deposito de cheque</option>
                                                    <option value="03 Transferencia eletrónica de fondos">Transferencia
                                                        electrónica
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="razonSocial">Razón social*</label>
                                                <input type="text" class="form-control" id="razonSocial"
                                                       name="razonSocial">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="rfc">RFC*</label>
                                                <input type="text" class="form-control" id="rfc" name="rfc">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="correoFac">Correo electrónico*</label>
                                                <input type="text" class="form-control" id="correoFac" name="correoFac">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="estadoFac">Estado*</label>
                                                <input type="text" class="form-control" id="estadoFac" name="estadoFac">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="municipioFac">Muncipio/Ciudad*</label>
                                                <input type="text" class="form-control" id="municipioFac"
                                                       name="municipioFac">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="cpFac">Código postal*</label>
                                                <input type="text" class="form-control" id="cpFac" name="cpFac">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="direccionFac">Dirección*</label>
                                                <input type="text" class="form-control" id="direccionFac"
                                                       name="direccionFac">
                                            </div>
                                        </div>
                                    </div>
                                        <div id="btn-pay-form" class="row justify-content-center ">
                                            <button class="btn btn-dark btn-sm" style="border-radius: 20px" onclick="tabEnvio()"><i
                                                    class="material-icons">navigate_before</i></button> &nbsp;
                                            <button type="submit" class="btn btn-dark">Crear orden de compra</button>
                                        </div>

                                </form>
                            </div>
                            <div id="btn-pay-div" class="row justify-content-center ">
                                <button class="btn btn-dark btn-sm" style="border-radius: 20px" onclick="tabEnvio()"><i
                                        class="material-icons">navigate_before</i></button> &nbsp;
                                <button class="btn btn-dark" onclick="createOrder()">Crear orden de compra</button>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-confirmation" role="tabpanel"
                         aria-labelledby="nav-confirmation-tab">
                        <div class="container">
                            <div class="col-md-12 p-2 text-center">
                                <button class="bg-color-jd"><i class="material-icons">check</i></button>
                                <h2 class="mt-2">En tu correo ya tienes el formato con el puedes realizar el desposito
                                    en ventanilla o una transferencia electrónica</h2>
                                <div class="text-center p-1">
                                    <h2><span class="text-muted mr-1">Total a pagar:</span><span id="totalConfirm"></span></h2>
                                </div>
                                <h2 class="py-1">Datos bancarios:</h2>
                                <h3 class="py-1">Beneficiario: JARDEPOT SA de CV</h3>
                                <h3 class="py-1">RFC: JAR111021F14</h3>
                            </div>

                            <div class="row justify-content-center p-2">
                                <div class="col-md-4 px-1 card m-3 shadow">
                                    <div>
                                        <img src="{{asset('assets/images/bancos/citibanamex.png')}}" alt="Banamex"
                                             class="img-bank">
                                        <p class="text-muted lh">Cuenta: <strong>0084594</strong></p>
                                        <p class="text-muted lh">Sucursal: <strong>4097</strong></p>
                                        <p class="text-muted lh">CLABE: <strong>0025 4040 9700 8459 41</strong></p>
                                    </div>
                                </div>
                                <div class="col-md-4 px-1 card m-3 shadow">
                                    <div>
                                        <div
                                            style="max-height: 132px !important; height: 132px; width: 100%; max-width: 300px;">
                                            <div style=" background-color: #072146; height: 40%;">
                                                <img src="{{asset('assets/images/bancos/bbva.svg')}}" alt="Bancomer"
                                                     style="width: 50%;">
                                            </div>
                                        </div>
                                        <p class="text-muted lh">Cuenta: <strong>0110147699</strong></p>
                                        <p class="text-muted lh">CLABE: <strong>0125 4000 1101 4769 96</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center p-2">
                                <div class="col-md-4 card m-3 shadow">
                                    <img src="{{asset('assets/images/bancos/banbajio.png')}}" alt="Banbajio"
                                         class="img-bank">
                                    <p class="text-muted lh">Cuenta: <strong>11925492</strong></p>
                                    <p class="text-muted lh">CLABE: <strong>0305 4090 0003 3487 84</strong></p>
                                </div>

                                <div class="col-md-4 card m-3 shadow">
                                    <img src="{{asset('assets/images/bancos/banorte.png')}}" alt="Banorte"
                                         class="img-bank" style="height: 119px;">
                                    <p class="text-muted lh">Cuenta: <strong>0323900559</strong></p>
                                    <p class="text-muted lh">CLABE: <strong>0725 4000 3239 0055 94</strong></p>
                                </div>

                                <div class="col-md-4 card m-3 shadow">
                                    <div class="img-bank" style="height: 125px;">
                                        <img src="{{asset('assets/images/bancos/santander.svg')}}" alt="Santander"
                                             style="width: 80%">
                                    </div>
                                    <p class="text-muted lh">Cuenta: <strong>65505199530</strong></p>
                                    <p class="text-muted lh">CLABE: <strong>0145 4065 5051 9953 08</strong></p>
                                </div>
                            </div>

                            <p class="text-muted lh">
                                Una vez realizado su depósito o transferencia, favor de informar al correo
                                ventas@jardepot.com Incluyendo sus datos
                                completos para facturación y envío, así como los productos solicitados. Después de haber
                                efectuado su pago, no se
                                aceptan cancelaciones. Atentos saludos del equipo de atención a clientes JARDEPOT SA de
                                CV. Quienes agradecen su confianza esperando poder contar con su preferencia.
                            </p>
                            <div class="row justify-content-center mt-2 p-1">
                                <a href="{{url('/')}}" class="btn btn-primary">Regresar al inicio</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('specificJS')
    <div class="overlay"></div>
    <!-- jQuery Custom Scroller CDN -->
    <script type="text/javascript" src="{{asset('assets/js/pages/checkout.js')}}"></script>

@endsection
