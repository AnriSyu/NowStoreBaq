<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title id="title_title">NowStoreCol - Carrito</title>
    <link rel="icon" type="image/png" href="{{asset('img/nowstorebaq_logo.png')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/carrito_articulos.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="{{asset("js/lib/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("js/lib/all.min.js")}}"></script>
    <script src="{{asset('js/lib/jquery-3.7.1.min.js')}}"></script>
</head>
<body class="d-flex flex-column min-vh-100">
@include('parcial.navbar')
<main class="mt-5" style="width: 90%;margin:auto">
    <div class="text-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><span class="nsb-activo">Carrito</span> > <span> Pagar </span> </li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body nsb-card-body">
                    <div class="d-flex">
                        <div class="checkbox-wrapper-19">
                            <input type="checkbox" id="checkbox_todo" checked/>
                            <label for="checkbox_todo" class="check-box"></label>
                        </div>
                        <h3 class="card-title"> TODOS LOS ARTÍCULOS <span id="span_cantidad_articulos"></span></h3>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body" id="cardbody_lista_articulos">

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3 nsb-card-pedido" id="card_pedido">
                <div class="card-body">
                    <h3 class="card-title">Resumen Del Pedido</h3>
                    <div class="text-start mt-4">
                        <span class="nsb-resumen-precio" id="span_resumen_precio"></span>
                        <p class="nsb-resumen-descuento" id="p_resumen_descuento"></p>
                    </div>
                    <button id="button_pagar" type="button" class="mt-3 btn nsb-btn nsb-btn-primario" style="width: 100%;font-size:2em">GENERAR PEDIDO <span class="span_cantidad_articulos" id="span_cantidad_articulos_pagar"></span></button>
                </div>
            </div>
        </div>
    </div>
</main>
@include('parcial.footer')
<script src="{{asset('js/carrito_articulos.js')}}"></script>
</body>
