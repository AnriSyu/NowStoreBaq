@php
    use \Carbon\Carbon;
    use Illuminate\Support\Str;
    use App\Models\Pedido;
@endphp
@extends('usuario.layouts.perfil')

@section('titulo','Mis Pedidos')

@section('header')
    <h2>MIS PEDIDOS</h2>
@endsection

@section('contenido')
    <div class="card shadow-sm my-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Lista de Pedidos</h5>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @foreach ($pedidos as $pedido)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                            <div class="nsb-card-pedido-detalle shadow-sm border-light rounded">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate">Pedido #{{ $pedido->url_pedido }}</h5>
                                    <p class="card-text">
                                        <strong>Fecha de ingreso:</strong> {{ Carbon::parse($pedido->fecha_ingreso)->format('Y-m-d') }}<br>
                                        @php
                                            $resultado = Pedido::ObtenerFechaYColor($pedido);
                                        @endphp
                                        <strong>Fecha {{$resultado['estado']}}:</strong>
                                        <span class="badge p-2 {{$resultado['color']}}">{{ $resultado['fecha'] }}</span>
                                    </p>
                                    <p class="card-text">
                                        <strong>Estado:</strong>
                                        <span class="badge p-2 {{ Pedido::colorEstado($pedido->estado_pedido) }}">{{ $pedido->estado_pedido }}</span>
                                    </p>
                                    <p class="card-text">
                                        <strong>Total:</strong> ${{ number_format($pedido->total, 2) }}<br>
                                        <strong>Descuento:</strong> ${{ number_format($pedido->descuento, 2) }}
                                    </p>
                                    <button class="btn btn-outline-info button_ver_carrito" title="Ver carrito del pedido" data-id="{{$pedido->url_pedido}}">
                                        <i class="fas fa-eye"></i> Ver carrito
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/usuario/pedidos.js') }}"></script>
@endsection

