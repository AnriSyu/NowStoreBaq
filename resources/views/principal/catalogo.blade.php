<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title id="title_title">NowStoreCol - Catálogo</title>
    <link rel="icon" type="image/png" href="{{asset('img/nowstorebaq_logo.png')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/catalogo.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="{{asset("js/lib/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("js/lib/all.min.js")}}"></script>
    <script src="{{asset('js/lib/jquery-3.7.1.min.js')}}"></script>
{{--    <script src="{{asset("js/catalogo.js")}}"></script>--}}
</head>
<body>
@include('parcial.navbar')
<div class="container-fluid d-flex align-items-center ">
    <ul class="d-flex mb-0 nav nsb-catgeoria-nav">
        <li class="nav-item">
            <a id="a_menu_categoria" class="nav-link nsb-a-item-c nsb-categoria-nav-link"><small>Categorías</small></a>
        </li>
        @foreach ($categorias as $categoria)
            @php
                $categoriaSlug = Str::slug($categoria->categoria, '-');
                $href = $categoria->url_externo ?: url('catalogo/' . $categoriaSlug);
            @endphp
            @if($categoria->categoria !== 'Tendencias')
                <li class="nav-item">
                    <a class="nav-link nsb-categoria-nav-link" href="{{$href}}"><small>{{$categoria->categoria}}</small></a>
                </li>
            @endif
        @endforeach
    </ul>
{{--    <div class="d-flex align-items-center">--}}
{{--        <span id="span_categoria_flecha_izquierda" class="nsb-categoria-nav-link"><i class="fas fa-chevron-left me-4"></i></span>--}}
{{--        <span id="span_categoria_flecha_derecha" class="nsb-categoria-nav-link"><i class="fas fa-chevron-right ms-2"></i></span>--}}
{{--    </div>--}}
</div>
<div class="nsb-banner-pagocontraentrega">
    <span>PAGO <span class="highlight">CONTRAENTREGA</span></span>
</div>
<div class="container-fluid nsb-container-categorias">
    <div class="my-3 nsb-seccion-categoria nsb-sc-ct-1 text-center">
        <h2 class="mb-4 pt-4 nsb-seccion-categoria-h2">Categorías</h2>
        <div class="row">
            @foreach ($categorias as $categoria)
                @if($categoria->url_externo !== "")
                    @php
                        $categoriaSlug = Str::slug($categoria->categoria, '-');
                        $href = $categoria->url_externo ?: url('catalogo/' . $categoriaSlug);
//                        $href =  url('catalogo/' . $categoria->url_interno);
                    @endphp
                    @if($categoria->categoria !== "Tendencias")
                        <div class="col-md-4 mb-4">
                            <a class="nsb-card-categoria-a" href="{{$href}}" target="_blank">
                                <div class="nsb-card-categoria text-center">
                                    <img src="{{ asset('storage/'.$categoria->imagen) }}" class="nsb-card-img-categoria" alt="{{ $categoria->categoria }}">
                                    <div class="nsb-card-body-categoria">
                                        <h5 class="nsb-card-title-categoria">{{ $categoria->categoria }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>

    <div class="mt-5 mb-3 nsb-seccion-categoria nsb-sc-ct-2 text-center">
        <h2 class="mb-4 pt-4 nsb-seccion-categoria-h2">Tendencias</h2>
        <div class="row">
            @foreach ($categorias as $categoria)
                @if($categoria->subcategorias->isNotEmpty())
                    @foreach($categoria->subcategorias as $subcategoria)
                        @if($subcategoria->url_externo !== "")
                        @php
                            $categoriaSlug = Str::slug($categoria->categoria, '-');
                            $subcategoriaSlug = Str::slug($subcategoria->sub_categoria, '-');
                            $href = $subcategoria->url_externo ?: url('catalogo/' . $categoriaSlug . '/' . $subcategoriaSlug);
//                                  $href = url('catalogo/' . $categoria->url_interno . '/' . $subcategoria->url_interno);
                        @endphp
                        <div class="col-md-4 mb-4">
                            <a class="nsb-card-categoria-a" href="{{$href}}" target="_blank">
                                <div class="nsb-card-categoria">
                                    <img src="{{ asset('storage/'.$subcategoria->imagen) }}" alt="{{ $subcategoria->sub_categoria }}"  class="nsb-card-img-categoria">
                                    <div class="nsb-card-body-categoria">
                                        <h5 class="nsb-card-title-categoria">{{ $subcategoria->sub_categoria }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>

</div>

@include('parcial.footer')
</body>
</html>
