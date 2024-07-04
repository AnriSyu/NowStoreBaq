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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="{{asset("js/lib/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("js/lib/all.min.js")}}"></script>
    <script src="{{asset('js/lib/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/lib/sweetalert2.min.js')}}"></script>
</head>
<body>
@include('partials.navbar')
<main class="container">
    <div class="row justify-content-center my-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
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
                                <span class="input-group-text btn btn-light" id="span_ver_clave" title="Mostrar Contraseña"><i class="fas fa-eye"></i></span>
                            </div>
                            <div class="text-center mt-3">
                                @error('input_clave')
                                <div style="color:red;text-align:center">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="input_clave_repetir">Repetir contraseña:</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="input_clave_repetir" name="input_clave_repetir">
                                <span class="input-group-text btn btn-light" id="span_ver_clave_repetir" title="Mostrar Contraseña"><i class="fas fa-eye"></i></span>
                            </div>
                            <div class="text-center mt-3">
                                @error('input_clave_repetir')
                                <div style="color:red;text-align:center">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn nsb-btn nsb-btn-primario my-3" id="button_continuar" style="width:100%" >CONTINUAR</button>
                        </form>
                    @endif
                    <div class="text-center my-3">
                        @if(session('status'))
                            <div style="color:green;text-align:center">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('partials.footer')

<script>
    $("#span_ver_clave").on("click",function(){
        const inputClave = $('#input_clave');

        if (inputClave.attr('type') === 'password') {
            inputClave.attr('type', 'text');
        } else {
            inputClave.attr('type', 'password');
        }
    })
    $("#span_ver_clave_repetir").on("click",function(){
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
