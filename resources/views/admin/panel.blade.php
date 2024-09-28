@php use App\Models\Pedido; @endphp
@extends('admin.layouts.panel')

@section('titulo','Panel de administración')

@section('header')
    <h1 class="h3 mb-0 text-gray-800">Panel de administración</h1>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-md">
            <div class="card text-black bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total de Pedidos</h5>
                    <p class="card-text">{{ $totalPedidos }}</p>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card text-black bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pedidos Pendientes</h5>
                    <p class="card-text">{{ $pedidosPendientes }}</p>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card text-black bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pedidos Entregados</h5>
                    <p class="card-text">{{ $pedidosEntregados }}</p>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card text-black bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pedidos Cancelados</h5>
                    <p class="card-text">{{ $pedidosCancelados }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header text-white">Últimos Pedidos</div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Fecha de Pedido</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ultimosPedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->persona->nombres }} {{ $pedido->persona->apellidos }}</td>
                        <td>{{ $pedido->fecha_ingreso }}</td>
                        <td>${{ number_format($pedido->total,2) }}</td>
                        <td><span class="badge {{ Pedido::colorEstado($pedido->estado_pedido) }}">{{ $pedido->estado_pedido }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
