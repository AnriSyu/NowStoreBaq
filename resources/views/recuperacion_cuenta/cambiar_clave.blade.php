<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NowStoreBaq</title>
    <link rel="icon" type="image/png" href="{{asset('img/nowstorebaq_logo.png')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/minimal.css')}}">
    <link rel="stylesheet" href="{{asset('css/Object.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="{{asset("js/lib/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("js/lib/all.min.js")}}"></script>
    <script src="{{asset('js/lib/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/lib/sweetalert2.min.js')}}"></script>
</head>
<body>
@include('parcial.navbar')
<main class="container">
    <div class="row justify-content-center my-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    @if(session('status'))
                        <div class="py-5 text-center">
                            <h1>¡Perfecto!</h1>
                            <div class="alert alert-success" role="alert">
                                <span>{{ session('status') }}</span>
                            </div>
                            <a href="/ingresar">Volver a ingresar</a>
                        </div>
                    @else
                        @if($estado == 'error')
                            <div class="py-5 text-center">
                                <h1>Error</h1>
                                <p class="my-5">{{ $mensaje }}</p>
                                <a href="/ingresar">Volver a ingresar</a>
                            </div>
                        @else
                            <h3 class="card-title text-center mb-4">Recuperar contraseña</h3>
                            <form method="post" action="/cbrclv" id="form_cbrclv">
                                <input type="hidden" name="token" value="{{ $token }}">
                                @csrf
                                <label for="input_clave">Nueva contraseña:</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="input_clave" name="input_clave">
                                    <span class="input-group-text btn btn-light" id="span_ver_clave"
                                          title="Mostrar Contraseña"><i class="fas fa-eye"></i></span>
                                </div>
                                @error('input_clave')
                                <div class="text-center mt-3">
                                    <div class="alert alert-danger" role="alert">
                                        <span>{{ $message }}</span>
                                    </div>
                                </div>
                                @enderror
                                <label for="input_clave_repetir">Repetir contraseña:</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="input_clave_repetir"
                                           name="input_clave_repetir">
                                    <span class="input-group-text btn btn-light" id="span_ver_clave_repetir"
                                          title="Mostrar Contraseña"><i class="fas fa-eye"></i></span>
                                </div>
                                @error('input_clave_repetir')
                                <div class="text-center mt-3">
                                    <div class="alert alert-danger" role="alert">
                                        <span>{{ $message }}</span>
                                    </div>
                                </div>
                                @enderror
                                <button type="submit" class="btn nsb-btn nsb-btn-primario my-3" id="button_continuar"
                                        style="width:100%">CONTINUAR
                                </button>
                                @error('other_error')
                                <div class="text-center my-3">
                                    <div class="alert alert-danger" role="alert">
                                        <span>{{ $message }}</span>
                                    </div>
                                </div>
                                @enderror
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@include('parcial.footer')

<script>
    $("#span_ver_clave").on("click", function () {
        const inputClave = $('#input_clave');

        if (inputClave.attr('type') === 'password') {
            inputClave.attr('type', 'text');
        } else {
            inputClave.attr('type', 'password');
        }
    })
    $("#span_ver_clave_repetir").on("click", function () {
        const inputClave = $('#input_clave_repetir');

        if (inputClave.attr('type') === 'password') {
            inputClave.attr('type', 'text');
        } else {
            inputClave.attr('type', 'password');
        }
    })
</script>
</body>
</html>