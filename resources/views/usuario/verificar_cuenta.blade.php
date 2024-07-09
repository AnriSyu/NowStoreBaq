<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{asset("css/Object.css")}}">
    <link rel="stylesheet" href="{{asset('css/lib/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/verificar_cuenta.css')}}">
    <script src="{{asset("js/lib/all.min.js")}}"></script>
    <script src="{{asset("js/lib/bootstrap.bundle.min.js")}}"></script>

</head>
<body>
@include('parcial.navbar')
<main class="container">
    <div class="row align-items-center">
        <div class="col-lg-12">
            <div class="nsb-card-confirmar-cuenta">
                <div class="nsb-card-header-confirmar-cuenta">
                    <h1 class="nsb-title-confirmar-cuenta ">Activación de cuenta</h1>
                </div>
                <div class="nsb-card-body-confirmar-cuenta text-center">
                    <p class="nsb-text-confirmar-cuenta my-4">{{ $mensaje }}</p>
                    <div class="mt-3">
                        <a href="/ingresar" class="nsb-btn-confirmar-cuenta text-decoration-none">Volver al ingreso</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('parcial.footer')
</body>
