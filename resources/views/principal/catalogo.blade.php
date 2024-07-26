<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title id="title_title">NowStoreBaq - Catálogo</title>
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
<div class="nsb-banner-pagocontraentrega">
    <span>PAGO <span class="highlight">CONTRAENTREGA</span></span>
</div>
<div class="container">
    <div class="my-3 nsb-seccion-categoria nsb-sc-ct-1">
        <h2 class="mb-4 pt-4 nsb-seccion-categoria-h2">Categorías</h2>
        <div class="row">
            @foreach ($categorias as $categoria)
                @if($categoria->url_externo !== "")
                <div class="col-6 col-md-2 text-center mb-3">
                    @php
                        $categoriaSlug = Str::slug($categoria->categoria, '-');
                        $href = $categoria->url_externo ?: url('catalogo/' . $categoriaSlug);
                    @endphp
                    @if($categoria->categoria !== "Tendencias")

                        <a class="nsb-card-categoria-a" href="{{$href}}">
                            <div class="nsb-card-categoria">
                                <img src="{{ asset('storage/'.$categoria->imagen) }}" alt="{{ $categoria->categoria }}">
                                <p class="nsb-card-categoria-p">{{ $categoria->categoria }}</p>
                            </div>
                        </a>
                    @endif
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="mt-5 mb-3 nsb-seccion-categoria nsb-sc-ct-2">
        <h2 class="mb-4 pt-4 nsb-seccion-categoria-h2">Tendencias</h2>
        <div class="row">
            @foreach ($categorias as $categoria)
                @if($categoria->subcategorias->isNotEmpty())
                    <div class="col-md-12">
                        <div class="row">
                            @foreach($categoria->subcategorias as $subcategoria)
                                @if($subcategoria->url_externo !== "")
                                <div class="col-6 col-md-2 text-center mb-3">
                                    @php
                                        $categoriaSlug = Str::slug($categoria->categoria, '-');
                                        $subcategoriaSlug = Str::slug($subcategoria->sub_categoria, '-');
                                        $href = $subcategoria->url_externo ?: url('catalogo/' . $categoriaSlug . '/' . $subcategoriaSlug);
                                    @endphp
                                    <a class="nsb-card-categoria-a" href="{{$href}}">
                                        <div class="nsb-card-categoria">
                                            <img src="{{ asset('storage/'.$subcategoria->imagen) }}" alt="{{ $subcategoria->sub_categoria }}">
                                            <p class="nsb-card-categoria-p">{{ $subcategoria->sub_categoria }}</p>
                                        </div>
                                    </a>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

</div>

@include('parcial.footer')
</body>
</html>