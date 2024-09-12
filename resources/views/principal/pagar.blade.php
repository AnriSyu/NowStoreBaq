<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title id="title_title">NowStoreCol - Catálogo</title>
    <link rel="icon" type="image/png" href="{{asset('img/nowstorebaq_logo.png')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/pagar.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="{{asset("js/lib/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("js/lib/all.min.js")}}"></script>
    <script src="{{asset('js/lib/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/lib/select2.min.js')}}"></script>
    <script src="{{asset("js/plantilla.js")}}"></script>
    <script src="{{asset("js/pagar.js")}}"></script>
</head>
<body>
@include('parcial.navbar')
<main class="mt-5" style="width: 90%;margin:auto">

    <div class="nsb-mensaje-volver-carrito">
        <a href="/carrito" class="text-dark text-decoration-none">
            <i class="fas fa-arrow-left"></i> Volver al carrito
        </a>
    </div>

    <div class="text-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-dark text-decoration-none" href="/carrito">Carrito</a> > <span class="nsb-activo"> Pagar </span> </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body nsb-card-body">
                    <div class="col-md-12">
                        <h4 class="mb-4">DIRECCIÓN DE ENVÍO</h4>

                        <form method="POST" >
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres*</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos*</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección*</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="celular" class="form-label">Celular*</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+57</span>
                                            <input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="select_departamento" class="form-label">Departamento*</label>
                                        <select id="select_departamento" class="form-select" name="departamento" required>
                                            <option value="">Selecciona el Departamento</option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{ $departamento->id }}">{{ $departamento->departamento }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="select_municipio" class="form-label">Municipio*</label>
                                        <select id="select_municipio" class="form-select" name="municipio" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-3 col-12">
                                    <div class="mb-3">
                                        <label for="codigo_postal" class="form-label">Código Postal*</label>
                                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" required>
                                    </div>
                                </div>
                                <div class="col-md col-12">
                                    <div class="mb-3">
                                        <label for="referencias" class="form-label">Referencias</label>
                                        <input type="text" class="form-control" id="referencias" name="referencias" placeholder="Apartamento, suite, unidad, piso, etc. (opcional)">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="id_usuario" name="id_usuario" value="{{ Auth::user()->id }}">
                            <div class="text-center my-3">
                                <button type="submit" class="btn nsb-btn nsb-btn-guardar-datos-persona">GUARDAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4">
                <h5 class="card-title">Resumen Del Pedido</h5>
                <p class="card-text">Subtotal: {{$totalFormato}}</p>
                @if($descuento > 0)
                    <p class="card-text">Descuento: {{$descuentoFormato}}</p>
                @endif
                <a class="btn nsb-btn nsb-btn-pagar w-100">PROCEDE AL PAGO</a>
            </div>
        </div>
    </div>
</main>
@include('parcial.footer')
</body>
</html>
