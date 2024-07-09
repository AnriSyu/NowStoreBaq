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
                    <h3 class="card-title text-center mb-4">Recuperar cuenta</h3>
                    <div class="text-center py-4">
                        <span>Se te enviará una instrucción para restablecer tu contraseña.</span>
                    </div>
                    <form method="post" action="/reccun" id="form_reccun">
                        @csrf
                        <label for="input_correo">Correo electrónico:</label>
                        <input type="text" class="form-control mb-3" id="input_correo" name="input_correo">
                        <button type="submit" class="btn nsb-btn nsb-btn-primario my-3" id="button_continuar"
                                style="width:100%">CONTINUAR
                        </button>
                        <div class="text-center my-3">
                            @if(session('status'))
                                <div class="alert alert-success" role="alert">
                                    <span>{{ session('status') }}</span>
                                </div>
                            @endif
                            @error('input_correo')
                                <div class="alert alert-danger" role="alert">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@include('parcial.footer')
</body>
</html>
