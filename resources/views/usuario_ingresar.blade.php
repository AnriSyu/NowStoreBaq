<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NowStoreBaq</title>
    <link rel="icon" type="image/png" href="{{asset('img/nowstorebaq_logo.png')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/usuario_ingresar.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="{{asset("js/lib/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("js/lib/all.min.js")}}"></script>
    <script src="{{asset('js/lib/jquery-3.7.1.min.js')}}"></script>
</head>
<body>
@include('partials.navbar')
<main class="container  vh-100">
    <div class="row justify-content-center my-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Regístrate / Iniciar sesión</h3>
                    <form action="/reg-insc">
                        <label for="input_correo">Correo electrónico:</label>
                        <input type="text" class="form-control mb-4">
                        <button type="button" class="btn nsb-btn nsb-btn-primario" style="width:100%" >CONTINUAR</button>
                    </form>
                    <hr>
                    <button type="button" class="btn nsb-btn" style="width: 100%;border:1px solid #e2e2e2"><i class="fab fa-google"></i> Continuar con Google</button>
                </div>
            </div>
        </div>
    </div>
</main>
@include('partials.footer')
</body>
</html>
