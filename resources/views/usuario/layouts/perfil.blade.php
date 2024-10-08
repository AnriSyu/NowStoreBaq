<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NowStoreCol - @yield('titulo')</title>
    <link rel="icon" type="image/png" href="{{asset('img/nowstorebaq_logo.png')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/usuario/perfil.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/select2.min.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"  rel="stylesheet">
    <script src="{{asset("js/lib/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("js/lib/all.min.js")}}"></script>
    <script src="{{asset('js/lib/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/lib/popper.min.js')}}"></script>
    <script src="{{asset('js/lib/select2.min.js')}}"></script>
    <script src="{{asset('js/lib/notify.min.js')}}"></script>
    <script src="{{asset("js/plantilla.js")}}"></script>

</head>
<body>
@include('parcial.navbar')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 nsb-usuario-sidebar p-3">
            @include('usuario.parcial.sidebar')
        </div>

        <div class="col-md-9 nsb-usuario-content">
            @yield('header')
            @yield('contenido')
        </div>
    </div>
</div>
@include('parcial.footer')
</body>
</html>
