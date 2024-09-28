<nav class="navbar navbar-expand-lg navbar-light nsb-navbar">
    <div class="container">
    <a class="navbar-brand" href="/">
        <img src="{{asset('img/nowstorebaq_logo.png')}}" alt="NowStoreColLogo" class="nsb-logo img-fluid">
    </a>

    <div class="nsb-icon-links order-lg-3">
        <a href="/carrito" class="nsb-icon-circle position-relative nsb-icon-links-a">
            <i class="fas fa-shopping-cart fa-2x"></i>
            <span id="span_cantidad_articulos_carrito_navbar" class="position-absolute top-0 start-100 translate-middle badge rounded-pill nsb-bg-primario"></span>
        </a>
        @auth
            <div class="dropdown">
                <a href="#" class="nsb-icon-circle dropdown-toggle nsb-icon-links-a" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-2x"></i>
                </a>
                <ul class="dropdown-menu nsb-dropdown-menu dropdown-menu-end dropdown-menu-lg-start" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item nsb-dropdown-item" href="/perfil">
                            <i class="fas fa-user"></i> Perfil
                        </a>
                    </li>
                    <li><a class="dropdown-item nsb-dropdown-item" href="/ajustes">
                            <i class="fas fa-cogs"></i> Ajustes
                        </a>
                    </li>
                    @if(Auth::user()->tieneRol('administrador'))
                        <li><a class="dropdown-item nsb-dropdown-item" href="/admin">
                                <i class="fas fa-shield"></i> Admin
                            </a>
                        </li>
                    @endif
                    <li><hr class="dropdown-divider nsb-divider"></li>
                    <li><a class="dropdown-item nsb-dropdown-item" href="/logout">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </a>
                    </li>
                </ul>
            </div>
        @else
            <a href="/ingresar" class="nsb-icon-circle nsb-icon-links-a">
                <i class="fas fa-user-circle fa-2x"></i>
            </a>
        @endauth
        <button class="navbar-toggler ms-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars fa-2x"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse order-lg-2" id="navbarContent">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/buscar-articulo">buscar artículo</a>
            </li>
{{--            @if(Route::is('catalogo'))--}}
{{--                <li class="nav-item">--}}
{{--                    <a id="a_menu_categoria" class="nav-link nsb-a-item-c">Categorías</a>--}}
{{--                </li>--}}
{{--            @endif--}}
        </ul>
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

        document.querySelector("#span_cantidad_articulos_carrito_navbar").innerHTML = cantidad_total.toString();
    })();
</script>
