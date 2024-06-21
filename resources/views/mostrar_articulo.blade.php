<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title id="title_title">NowStoreBaq - {{$articulo['nombre']}}</title>
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
    <script src="{{asset('js/lib/notify.min.js')}}"></script>
</head>
<body>
@include('partials.navbar')
<div class="container-fluid nsb-articulo-contenedor">
    <a href="/" class="nsb-volver">
        <i class="fas fa-arrow-left"></i> Volver a buscar un artículo
    </a>

    <div class="row g-0">
        <!-- Product Images -->
        <div class="col-xl-6">
            <div class="nsb-articulo-imagenes">
                <div class="nsb-articulo-miniaturas">
                    @foreach($articulo['imagenes'] as $imagenes)
                        <img src="{{$imagenes}}" class="img_articulo_imagen_miniatura">
                    @endforeach
                </div>
                <img src="{{$articulo['imagen_principal']}}" class="img-fluid nsb-imagen-principal" id="img_principal">
            </div>
            <div class="alert alert-warning mt-3 alert_mensaje_advertencia alert-dismissible" role="alert" id="alert_mensaje_advertencia_imagenes" style="width: 80%;margin: auto">
                <span class="text-break" id="span_texto_advertencia">Las imágenes del artículo con este color no se cargarán, si necesitas verlas, introduce el enlace del artículo <a href="/">aquí</a> o vuelve a la página anterior</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-xl-6 nsb-articulo-detalles">
            <h1 class="nsb-articulo-titulo" id="h1_articulo_titulo">{{$articulo['nombre']}}</h1>
            <small class="nsb-articulo-sku" >SKU: <span id="small_articulo_sku">{{$articulo['sku']}}</span><i id="icon_copiar_sku" class="ms-3 fas fa-copy nsb-icono-copiar" title="copiar código"></i></small>
            <div class="d-flex align-items-center">
                <span class="nsb-articulo-precio-actual mt-3 ">Precio: <span class="@if($articulo['descuento']!=0) nsb-articulo-precio-descuento @endif" id="span_precio_actual">{{$articulo['precio_actual']}}</span></span>
                @if($articulo['precio_original']!=0)
                <del class="nsb-articulo-precio-borrado" id="span_precio_original">{{$articulo['precio_original']}}</del>
                @endif
                @if($articulo['descuento']!=0)
                <span class="nsb-articulo-descuento" id="span_descuento">{{$articulo['descuento']}}</span>
                @endif
            </div>
            <hr>


            @if($articulo['color']!==0)
            <p class="mt-4"><strong>Color: </strong><span id="span_articulo_color">{{$articulo['color']}}</span></p>
            @endif

            @if(count($articulo['colores'])!==0)
            <div class="nsb-articulo-colores">
                @foreach($articulo['colores'] as $color)
                    <div class="nsb-color-swatch div_color_swatch" data-code="{{$color['encriptado']}}" style="background: url('{{$color['color_imagen']}}')" title="{{$color['color_titulo']}}"></div>
                @endforeach
            </div>
           @endif

            @if (count($articulo['tallas'])!==0)

            <p class="mt-4">
                <strong id="strong_titulo_talla">{{$articulo['titulo_talla']}}:</strong>
                <small id="error_seleccionar_talla" style="color:red"></small>
            </p>
            <div class="nsb-tallas d-flex">
                @foreach($articulo['tallas'] as $talla)
                    <button class="btn nsb-btn-talla @if(count($articulo['tallas']) === 1) nsb-selected @endif" data-talla="{{$talla}}">{{$talla}}</button>
                @endforeach
            </div>
{{--            <div class="mt-3">--}}
{{--                <input type="text" class="form-control" placeholder="Escribe tu talla" style="width: 20%">--}}
{{--            </div>--}}
            <div class="mt-3">
                <a style="color:deepskyblue;cursor:pointer" id="span_guia_tallas" data-bs-toggle="modal" data-bs-target="#modal_guia_talla"><i class="fas fa-ruler-horizontal"></i> Guía de tallas</a>
            </div>
            <div role="alert" id="alert_mensaje_advertencia_tallas" style="width: 100%;margin: auto;" class="alert-dismissible alert_mensaje_advertencia alert alert-warning mt-3">
                <span class="text-break" id="span_texto_advertencia">Las tallas del artículo con este color no se cargarán, si necesitas verlas, introduce el enlace del artículo <a href="/">aquí</a> o vuelve a la página anterior</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="nsb-selector-cantidad mt-3">
                <label for="input_cantidad" class="mr-2">Cantidad:</label>
                <button type="button" class="btn btn-light" onclick="cambiarCantidad(-1)">-</button>
                <input type="text" class="mx-2" id="input_cantidad" value="1" readonly="">
                <button type="button" class="btn btn-light" onclick="cambiarCantidad(1)">+</button>
            </div>

            <button class="mt-4 btn nsb-btn nsb-btn-bolsa btn-lg mt-3" id="button_agregar_bolsa">Añadir a la bolsa</button>
            <div class="mt-4 nsb-descripcion">
                <button id="button_descripcion" class="btn" data-toggle="collapse" data-target="#div_articulo_descripcion">
                    Descripción
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse" id="div_articulo_descripcion">
                    <table class="table" id="table_descripcion">
                        @foreach($articulo['descripcion'] as $descripcion)
                            <tr>
                                <th>{{$descripcion['indice']}}</th>
                                <td>{{$descripcion['valor']}}</td>
                            </tr>
                        @endforeach
                    </table>
{{--                        @foreach($articulo['descripcion'] as $descripcion)--}}
{{--                            <li><strong>{{$descripcion['indice']}}</strong> {{$descripcion['valor']}}</li>--}}
{{--                        @endforeach--}}
                </div>
            </div>
            <div class="nsb-tienda">
                <button id="button_tienda" class="btn" data-toggle="collapse" data-target="#div_articulo_tienda">
                    Sobre la tienda
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse" id="div_articulo_tienda">
                    <div class="row align-items-center">
                        <div class="col-sm-2">
                            <img src="{{$articulo['tienda']['logo']}}" style="width: 100px">
                        </div>
                        <div class="col-sm">
                            <span class="fw-bolder">{{$articulo['tienda']['nombre']}}</span>
                            <p class="text-break">{{$articulo['tienda']['descripciones']}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-lg" id="modal_guia_talla" tabindex="-1" role="dialog" aria-labelledby="modal_guia_talla" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sizeGuideModalLabel">Guía de Tallas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('partials.guia_talla')
            </div>
        </div>
    </div>
</div>
@include('partials.footer')
<script src="{{asset('js/mostrar_articulo.js')}}"></script>
</body>
</html>
