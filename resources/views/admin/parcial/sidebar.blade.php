<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
    <div class="sidebar-brand-text mx-3">NowStore</div>
</a>

<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link {{ url()->current() == route('admin.panel') ? 'active' : '' }} " href="{{route('admin.panel')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Panel</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
{{--    <div class="sidebar-heading">--}}
{{--        Interface--}}
{{--    </div>--}}

<!-- Nav Item - Pages Collapse Menu -->
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">--}}
{{--            <i class="fas fa-fw fa-cog"></i>--}}
{{--            <span>Components</span>--}}
{{--        </a>--}}
{{--        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">--}}
{{--            <div class="bg-white py-2 collapse-inner rounded">--}}
{{--                <h6 class="collapse-header">Custom Components:</h6>--}}
{{--                <a class="collapse-item" href="buttons.html">Buttons</a>--}}
{{--                <a class="collapse-item" href="cards.html">Cards</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}



<!-- Nav Item - Charts -->
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link" href="charts.html">--}}
{{--            <i class="fas fa-fw fa-chart-area"></i>--}}
{{--            <span>Charts</span>--}}
{{--        </a>--}}
{{--    </li>--}}
{{--<li class="nav-item">--}}
{{--    <a class="nav-link {{ url()->current() == route('admin.usuarios') ? 'active' : '' }}" href="{{route('admin.usuarios')}}">--}}
{{--        <i class="fas fa-fw fa-user"></i>--}}
{{--        <span>Usuarios</span>--}}
{{--    </a>--}}
{{--</li>--}}
<li class="nav-item">
    <a class="nav-link {{ url()->current() == route('admin.pedidos') ? 'active' : '' }}    " href="{{route('admin.pedidos')}}">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Pedidos</span>
    </a>
</li>
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link" href="{{route('admin.ajustes-perfil')}}">--}}
{{--            <i class="fas fa-fw fa-user-cog"></i>--}}
{{--            <span>Perfil</span>--}}
{{--        </a>--}}
{{--    </li>--}}
<li class="nav-item">
    <a class="nav-link" href="/">
        <i class="fas fa-fw fa-home"></i>
        <span>Ir a NowStore</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{route('admin.cerrar-sesion')}}">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Cerrar Sesión</span>
    </a>
</li>

<!-- Divider -->
{{--    <hr class="sidebar-divider d-none d-md-block">--}}
