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
    <script src="{{asset('js/lib/popper.min.js')}}"></script>
    <script src="{{asset('js/lib/select2.min.js')}}"></script>
    <script src="{{asset("js/plantilla.js")}}"></script>
    <script src="{{asset('js/lib/notify.min.js')}}"></script>
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
                        <h4 class="mb-4">DATOS DE ENVÍO</h4>
                        <form method="POST" action="/guardar-datos-persona" id="form_guardar_datos_persona">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="input_nombres" class="form-label">Nombres*</label>
                                        <input type="text" class="form-control" id="input_nombres" name="input_nombres" placeholder="Nombres" value="{{ $persona->nombres ?? '' }}">
                                        <span class="nsb-error" id="span_input_nombres_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="input_apellidos" class="form-label">Apellidos*</label>
                                        <input type="text" class="form-control" id="input_apellidos" name="input_apellidos" placeholder="Apellidos" value="{{ $persona->apellidos ?? '' }}">
                                        <span class="nsb-error" id="span_input_apellidos_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="input_direccion" class="form-label">Dirección*</label>
                                        <input type="text" class="form-control" id="input_direccion" name="input_direccion" placeholder="Dirección" value="{{ $persona->direccion ?? '' }}">
                                        <span class="nsb-error" id="span_input_direccion_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="input_celular" class="form-label">Celular*</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+57</span>
                                            <input type="text" class="form-control" id="input_celular" data-type="number" name="input_celular" placeholder="Celular" value="{{ $persona->celular ?? '' }}">
                                        </div>
                                        <span class="nsb-error" id="span_input_celular_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="select_departamento" class="form-label">Departamento*</label>
                                        <select id="select_departamento" class="form-select" name="select_departamento">
                                            <option value="">Selecciona el Departamento</option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{ $departamento->id }}"
                                                        @if(isset($persona) && $persona->id_departamento == $departamento->id)
                                                            selected
                                                        @endif
                                                >
                                                    {{ $departamento->departamento }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="nsb-error" id="span_select_departamento_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="select_municipio" class="form-label">Municipio*</label>
                                        <select id="select_municipio" class="form-select" name="select_municipio" @if (isset($persona)) data-municipio-seleccionado="{{ $persona->id_municipio }}" @endif>
                                            <option value="">Selecciona el Municipio</option>
                                        </select>
                                        <span class="nsb-error" id="span_select_municipio_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-3 col-12">
                                    <div class="mb-3">
                                        <label for="input_codigo_postal" class="form-label">Código Postal*</label>
                                        <input type="text" class="form-control" id="input_codigo_postal" data-type="number" name="input_codigo_postal" placeholder="Código Postal" value="{{ $persona->codigo_postal ?? '' }}">
                                    </div>
                                    <span class="nsb-error" id="span_input_codigo_postal_error" ></span>
                                </div>
                                <div class="col-md col-12">
                                    <div class="mb-3">
                                        <label for="input_referencias" class="form-label">Referencias</label>
                                        <input type="text" class="form-control" id="input_referencias" name="input_referencias" placeholder="Apartamento, suite, unidad, piso, etc. (opcional)" value="{{ $persona->referencias ?? '' }}">
                                    </div>
                                    <span class="nsb-error" id="span_input_referencias_error"></span>
                                </div>
                            </div>
                            <div class="text-center my-3">
                                <button type="submit" id="button_guardar" class="btn nsb-btn nsb-btn-guardar-datos-persona">GUARDAR</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 mb-3">
                <h5 class="card-title">Resumen Del Pedido</h5>
                <p class="card-text">Subtotal:
                    @if($mitadTotal < $total)
                        <span style="text-decoration: line-through; color: #999;">{{$totalFormato}}</span>
                        <span style="color: #0984e3; font-weight: bold;">{{$precioMitadTotalFormato}}</span>
                    @else
                        {{$totalFormato}}
                    @endif
                </p>
                @if($descuento > 0)
                    <p class="card-text">Descuento: {{$descuentoFormato}}</p>
                @endif
                <div class="alert alert-info" role="alert">
                    Al hacer clic en "Procede al pago", serás redirigido al chat con un asesor para finalizar tu compra.
                </div>
                <form method="POST" action="/pagar">
                    @csrf
                    <button id="button_pagar" class="mt-3 btn nsb-btn nsb-btn-primario w-100 @if($persona == null) disabled @endif">PROCEDE AL PAGO</button>
                </form>
                @if($persona == null)
                    <div class="alert alert-danger mt-3" role="alert" id="alerta_datos_incompletos">
                        Debes completar los datos de envío para proceder al pago.
                    </div>
                @endif
                <div class="alert alert-danger mt-3" role="alert" id="alerta_error">
                </div>
            </div>
        </div>
    </div>
</main>
@include('parcial.footer')
</body>
</html>
