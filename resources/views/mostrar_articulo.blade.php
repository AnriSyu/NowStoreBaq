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
    <link rel="stylesheet" href="{{asset('css/mostrar_articulo.css')}}">
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
<main>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="row g-0">
                    <div class="col-lg-3">
                        <div class="d-flex flex-column align-items-center">
                            @foreach($articulo['imagenes'] as $imagen)
                                <img src="{{$imagen}}" class="product-images" alt="Product Image">
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg ms-1">
                        <img src="{{$articulo['imagenes'][0]}}" class="main-image" alt="Product Image">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-details">
                    <h2 class="product-title">{{$articulo['nombre']}}</h2>
                    <p class="product-sku">{{$articulo['sku']}}</p>
                    <div class="product-price">
                        <p class="price">${{$articulo['precio_original']}}</p>
                    <div class="product-colors">
                        <p>Color {{$articulo['color']}}</p>
                        <div class="color-swatch" style="background-color: #000;"></div>
                        <div class="color-swatch" style="background-color: #ff69b4;"></div>
                        <div class="color-swatch" style="background-color: #808080;"></div>
                        <div class="color-swatch" style="background-color: #f5deb3;"></div>
                        <div class="color-swatch" style="background-color: #fff;"></div>
                    </div>
                    <div class="product-sizes">
                        <p>Talla:</p>
                        <button class="btn btn-outline-dark size-button">S</button>
                        <button class="btn btn-outline-dark size-button">M</button>
                        <button class="btn btn-outline-dark size-button">L</button>
                        <button class="btn btn-outline-dark size-button">XL</button>
                    </div>
                    <button class="btn btn-primary btn-lg mt-3">AÑADIR A LA BOLSA</button>
                    <p class="mt-3">Gana hasta <strong>19 puntos SHEIN</strong> calculados al finalizar la compra.</p>
                </div>
            </div>
        </div>
    </div>
</main>
@include('partials.footer')
</body>
</html>
