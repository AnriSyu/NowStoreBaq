<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ url()->current() == route('usuario.perfil') ? 'active' : '' }}" href="{{route('usuario.perfil')}}">Perfil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ url()->current() == route('usuario.pedidos') ? 'active' : '' }}" href="{{route('usuario.pedidos')}}" >Pedidos</a>
    </li>
</ul>
