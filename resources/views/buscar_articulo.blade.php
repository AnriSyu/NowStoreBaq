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
    <link rel="stylesheet" href="{{asset('css/buscar_articulo.css')}}">
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
    <main class="nsb-search-article-form">
        <div class="container text-center">
            <h1 class="nsb-titulo">Compra el artículo que estás buscando de Shein</h1>
            <p class="nsb-parrafo my-5">Introduce el enlace del artículo que deseas comprar en Shein y nosotros te ayudamos a encontrarlo</p>
            <form action="/articulo" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" name="url_articulo" placeholder="Introduce el enlace del artículo">
                    <button type="submit">Buscar artículo</button>
                </div>
            </form>
        </div>
    </main>
    <div class="fixed-bottom">
    @include('partials.footer')
    </div>
</body>
</html>