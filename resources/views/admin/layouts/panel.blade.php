<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NowStoreCol - @yield('titulo')</title>
    <link rel="icon" type="image/png" href="{{asset('img/nowstorebaq_logo.png')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/panel.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/panel_Object.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/minimal.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/hint.min.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="{{asset("js/lib/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("js/lib/all.min.js")}}"></script>
    <script src="{{asset('js/lib/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/lib/sweetalert2.min.js')}}"></script>
    <script src="{{asset('js/lib/notify.min.js')}}"></script>
    <script src="{{asset('js/plantilla.js')}}"></script>

</head>
<body id="page-top">
<div id="wrapper">
    <ul class="navbar-nav sidebar accordion" id="accordionSidebar">
        @include('admin.parcial.sidebar')
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                @include('admin.parcial.nabvar')
            </nav>
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    @yield('header')
{{--                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i--}}
{{--                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>--}}
                </div>
                @yield('contenido')
            </div>
        </div>

    </div>
</div>
<script src="{{asset("js/admin/panel.js")}}"></script>
</body>
</html>
