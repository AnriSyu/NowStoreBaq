<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title id="title_title">NowStoreBaq - Carrito</title>
    <link rel="icon" type="image/png" href="{{asset('img/nowstorebaq_logo.png')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/carrito_articulos.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="{{asset("js/lib/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("js/lib/all.min.js")}}"></script>
    <script src="{{asset('js/lib/jquery-3.7.1.min.js')}}"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')
    <main class="mt-5" style="width: 90%;margin:auto">
        <div class="text-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="nsb-activo">Carrito</a></li>
                    <li class="breadcrumb-item"><a >Confirmar</a></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body nsb-card-body">
                        <div class="d-flex">
                            <div class="checkbox-wrapper-19">
                                <input type="checkbox" id="checkbox_todo" />
                                <label for="checkbox_todo" class="check-box"></label>
                            </div>
                            <h3 class="card-title"> TODOS LOS ARTÍCULOS (2)</h3>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center g-0">
                            <div class="col-1 text-center">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="" />
                                    <label for="cbtest-19" class="check-box"></label>
                                </div>
                            </div>
                            <div class="col-2">
                                <img src="https://placehold.co/500" class="img-fluid">
                            </div>
                            <div class="col ms-4">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p>SHEIN EZwear 2 piezas Camiseta corta de verano para mujer con cuello redondo casual y ajuste delgado</p>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col d-flex">
                                        <span class="me-4"><strong>Color: </strong> Negro</span>
                                        <span><strong>Talla: </strong> M</span>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span class="nsb-articulo-precio-descuento " id="span_precio_actual">$50.000</span>
                                                <del class="nsb-articulo-precio-borrado" id="span_precio_original">$100.000</del>
                                                <span class="nsb-articulo-descuento" id="span_descuento">-50%</span>
                                            </div>
                                            <div class="flex-row-reverse ">
                                                <button type="button" class="btn btn-light" onclick="cambiarCantidad(-1)">-</button>
                                                <input type="text" class="nsb-selector-cantidad" value="1">
                                                <button type="button" class="btn btn-light" onclick="cambiarCantidad(1)">+</button>
                                            </div>
                                            <i class="fas fa-trash-can ms-4" id="icon_borrar_articulo"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-3 nsb-card-pedido">
                    <div class="card-body">
                        <h5 class="card-title">Resumen Del Pedido</h5>
                        <p>$70.102</p>
                        <p>Descuento: $3.690</p>
                        <button type="button" class="btn btn-primary btn-block">Pagar ahora (2)</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('partials.footer')
</body>
