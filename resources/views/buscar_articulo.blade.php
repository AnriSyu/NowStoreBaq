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
<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="nsb-search-article-form flex-fill">
        <div class="container">
            <h1 class="nsb-titulo text-center">Compra el artículo que estás buscando de Shein</h1>
            <p class="nsb-parrafo my-5 text-center">Introduce el enlace del artículo que deseas comprar en Shein y nosotros te ayudamos a encontrarlo</p>
            <form  action="/articulo" method="post" id="form_buscar_articulo">
                @csrf
                <small class="nsb-texto-ayuda">¿cómo hacer esto?</small>
                <div class="input-group mt-1">
                    <input type="text" name="input_url_articulo" id="input_url_articulo" placeholder="Introduce el enlace del artículo" value="{{ old('input_url_articulo') }}">
                    <button type="submit" name="button_buscar" id="button_buscar">Buscar artículo</button>
                </div>
                <div class="alert alert-danger" role="alert" id="alert_mensaje_error">
                    <span id="span_texto_error"></span>
                </div>
            </form>
        </div>
    </main>

    @include('partials.footer')

    @if(session('error'))
    <div class="modal fade" id="modal_timeout" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body mt-5 mb-4">
                    <h1>¡Lo sentimos!</h1>
                    <span class="nsb-texto-solicitud">No se pudo hacer esta solicitud.</span>
                    @if(!empty($errorDetails))
                        <p>Detalles: {{ $errorDetails }}</p>
                    @endif
                </div>
                <div class="modal-footer" style="margin:auto">
                    <form action="/articulo" method="post">
                        @csrf
                        <input type="hidden" name="input_url_articulo" value="{{ old('input_url_articulo') }}">
                        <button type="submit" class="btn nsb-btn nsb-btn-primario" id="button_reintentar">Reintentar</button>
                    </form>
                    <button type="button" class="btn nsb-btn nsb-btn-cancelar" id="button_cancelar" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#modal_timeout').modal('show');
            $("#modal-loader").modal('hide');
        });
    </script>
    @endif

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal-loader" style="background-color:#000000bf">
        <div class="modal-dialog modal-dialog-centered">
            <div class="loader"></div>
        </div>
    </div>

    <script>
        $(function(){
            $("#alert_mensaje_error").hide();
            $("#button_buscar,#button_reintentar").click(function(){
                if($("#input_url_articulo").val() === "") {
                    $("#alert_mensaje_error").show();
                    $("#span_texto_error").text("Debes introducir el enlace del artículo en el campo de texto.")
                    return false;
                }
            })
            $("#form_buscar_articulo").submit(function(){
                $("#modal-loader").modal('show')
            })

            $("#nsb-texto-ayuda").click(function(){
            })

        })
    </script>

</body>
</html>
