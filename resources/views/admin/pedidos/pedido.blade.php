@php use App\Models\Pedido; @endphp
@extends('admin.layouts.panel')

@section('header')
    <h1 class="h3 text-gray-800">Pedido #{{ $pedido->url_pedido }}</h1>
@endsection

@section('titulo', 'Pedido #'.$pedido->url_pedido)

@section('contenido')
    <a class="btn btn-primary btn-sm" title="Descargar Informe" id="a_descargar_informe">
        Descargar informe
        <i class="fas fa-file-pdf"></i>
    </a>
    <div class="container mt-5">
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detalles del Pedido - {{$pedido->estado_pedido}}</h5>
                <div>
                    <span class="text-white me-2" style="cursor:pointer" title="Entregar Pedido" id="span_entregar_pedido">
                        <i class="fas fa-2x fa-check-circle"></i>
                    </span>
                    <span class="text-white" style="cursor:pointer" title="Cancelar Pedido" id="span_cancelar_pedido">
                        <i class="fas fa-2x fa-times-circle"></i>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Fecha de Creación:</strong> {{ Pedido::formatearFecha($pedido->fecha_ingreso) }}
                    </div>
                    <div class="col-md-6">
                        @if($pedido->fecha_entregado)
                            <strong>Fecha Entregado:</strong> {{ Pedido::formatearFecha($pedido->fecha_entregado) }}
                        @elseif($pedido->fecha_cancelado)
                            <strong>Fecha Cancelado:</strong> {{ Pedido::formatearFecha($pedido->fecha_cancelado) }}
                        @else
                            <strong>Fecha Entregado/Cancelado:</strong> Sin fecha
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Estado del Pedido:</strong>
                        <span class="badge p-2 ms-2 {{ Pedido::colorEstado($pedido->estado_pedido) }}">
                            {{ $pedido->estado_pedido }}
                        </span>
                        <button class="btn text-black btn-sm " title="Editar" id="button_editar_estado_pedido">
                            <i class="fas fa-edit"></i>
                        </button>

                    </div>
                    <div class="col-md-6">
                        <strong>Total:</strong> ${{ Pedido::formatearTotal($pedido->total) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Descuento:</strong> ${{ Pedido::formatearTotal($pedido->descuento) }}
                    </div>
                    <div class="col-md-6">
                        <strong>URL del Pedido:</strong> <a href="{{ $pedido->url_pedido }}" target="_blank">{{ $pedido->url_pedido }}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Observación:</strong>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 me-2" id="p_observacion">{{ $pedido->observacion ?? "Sin observación" }}</p>
                            @if($pedido->observacion)
                                <button class="btn text-black btn-sm " title="Editar" id="button_editar_observacion">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Datos del Cliente -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5>Detalles del Cliente - {{ $pedido->usuario->correo }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nombre:</strong> {{ $pedido->persona->nombres }} {{ $pedido->persona->apellidos }}
                    </div>
                    <div class="col-md-6">
                        <strong>Celular:</strong> {{ $pedido->persona->celular }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Código Postal:</strong> {{ $pedido->persona->codigo_postal }}
                    </div>
                    <div class="col-md-6">
                        <strong>Dirección:</strong> {{ $pedido->persona->direccion }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Departamento:</strong> {{ $pedido->persona->departamento->departamento }}
                    </div>
                    <div class="col-md-6">
                        <strong>Municipio:</strong> {{ $pedido->persona->municipio->municipio }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Referencias:</strong> <p>{{ $pedido->persona->referencias ?? "Sin referencias" }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Carrito de Compras</h5>
{{--                <div>--}}
{{--                    <a href="#" class="text-white me-2 a-cambiar-vista" title="Vista en Tarjeta" data-vista="tarjeta">--}}
{{--                        <i class="fas fa-th"></i>--}}
{{--                    </a>--}}
{{--                    <a href="#" class="text-white a-cambiar-vista" title="Vista en Tabla" data-vista="tabla">--}}
{{--                        <i class="fas fa-table"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
            <div class="card-body">
                <div class="row" id="carrito">
                    @foreach (json_decode($pedido->carrito) as $item)
                        <div class="col-md-6 col-lg-4 mb-3 tarjeta-item">
                            <div class="card h-100">
                                <img src="https:{{ $item->imagen }}" class="card-img-top" alt="{{ $item->nombre }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->nombre }}</h5>
                                    <p class="card-text">
                                        <strong>SKU:</strong> {{ $item->sku }}<br>
                                        <strong>Color:</strong> {{ $item->color }}<br>
                                        <strong>Talla:</strong> {{ $item->talla }}<br>
                                        <strong>Cantidad:</strong> {{ $item->cantidad }}<br>
                                        <strong>50/50 activo:</strong> {{ $item->fifty_fifty ? "Activado" : "Desactivado" }}
                                        <br>
                                        <strong>Mitad precio: </strong><span style="font-weight: bolder;color:#f27474">{{ $item->precio_mitad ? "$". number_format($item->precio_mitad,2) : "Sin mitad de precio" }}</span>
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted"><s>{{ $item->precio_original_con_simbolo }}</s></span>
                                        <span class="text-danger">{{ $item->descuento_con_simbolo }}</span>
                                        <span class="text-success">{{ $item->precio_venta_con_simbolo }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
{{--                <div class="table-responsive" id="carrito-tabla" style="display: none;">--}}
{{--                    <table class="table table-bordered">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>Producto</th>--}}
{{--                            <th>SKU</th>--}}
{{--                            <th>Color</th>--}}
{{--                            <th>Talla</th>--}}
{{--                            <th>Cantidad</th>--}}
{{--                            <th>Precio Original</th>--}}
{{--                            <th>Descuento</th>--}}
{{--                            <th>Precio Final</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @foreach (json_decode($pedido->carrito) as $item)--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <img src="https:{{ $item->imagen }}" alt="{{ $item->nombre }}" style="width: 50px; height: auto;"> {{ $item->nombre }}--}}
{{--                                </td>--}}
{{--                                <td>{{ $item->sku }}</td>--}}
{{--                                <td>{{ $item->color }}</td>--}}
{{--                                <td>{{ $item->talla }}</td>--}}
{{--                                <td>{{ $item->cantidad }}</td>--}}
{{--                                <td><s>{{ $item->precio_original_con_simbolo }}</s></td>--}}
{{--                                <td class="text-danger">{{ $item->descuento_con_simbolo }}</td>--}}
{{--                                <td class="text-success">{{ $item->precio_venta_con_simbolo }}</td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
            </div>
        </div>

    </div>
    <script src="{{asset("js/admin/pedido.js")}}"></script>
@endsection
