<nav class="navbar navbar-expand-lg nsb-navbar" style="background-color:#fff">
    <div class="container">
        <a class="navbar-brand" href="/catalogo">
            <img src="{{asset('img/nowstorebaq_logo.png')}}" alt="NowStoreBaq" class="nsb-logo img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav" style="margin:auto">
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link nsb-a-item" href="/">Inicio</a>--}}
{{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link nsb-a-item" href="/catalogo">Catálogo</a>
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link nsb-a-item" href="/">Buscar artículo</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link nsb-a-item" href="/contacto">Contacto</a>--}}
{{--                </li>--}}
                @if(Route::is('catalogo'))
                    <li class="nav-item">
                        <a id="a_menu_categoria" class="nav-link nsb-a-item nsb-a-item-c">Categorías</a>
                    </li>
                @endif
            </ul>
{{--            <div class="d-flex" style="margin-left: auto">--}}
{{--                <ul class="nav">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link nsb-a-item" href="/ingresar">--}}
{{--                            <i class="fas fa-user-circle fa-2x"></i>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link nsb-a-item" href="/carrito">--}}
{{--                            <i class="fas fa-shopping-cart fa-2x"></i>--}}
{{--                            <span id="span_cantidad_articulos_carrito_navbar" style="font-weight: bolder"></span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
        </div>
    </div>
</nav>
@if(Route::is('catalogo'))
    @include('parcial.categorias_articulos')
@endif
<script>
    (function() {

        let carrito = localStorage.getItem('carrito');
        carrito = carrito ? JSON.parse(carrito) : [];

        let cantidad_total = 0;

        carrito.forEach(item => {
            cantidad_total += item.cantidad;
        });

        //document.querySelector("#span_cantidad_articulos_carrito_navbar").innerHTML = cantidad_total.toString();
    })();
</script>
