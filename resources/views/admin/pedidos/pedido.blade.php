@php use App\Models\Pedido; use App\Models\Pago @endphp
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
                    <span class="text-white " style="cursor:pointer" title="Entregar Pedido" id="span_entregar_pedido">
                        <i class="fas fa-2x fa-check-circle"></i>
                    </span>
                    <span class="text-white" style="cursor:pointer" title="Cancelar Pedido" id="span_cancelar_pedido">
                        <i class="fas fa-2x fa-times-circle"></i>
                    </span>
                    <span class="text-white" style="cursor:pointer" title="Ver Pagos" data-bs-toggle="modal" id="span_ver_pagos" data-bs-target="#modal_ver_pagos">
                        <i class="fas fa-2x fa-money-bill-wave"></i>
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
                        <strong>URL del Pedido:</strong> <a href="{{ $pedido->url_pedido }}" target="_blank">{{ $pedido->url_pedido }}</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Total:</strong> ${{ Pedido::formatearTotal($pedido->total) }}
                    </div>
                    <div class="col-md-6">
                        <strong>Estado pago:</strong> <span class="badge p-2 ms-2 {{ Pago::colorPago($pago->estado_pago) }}">
                            {{ $pago->estado_pago }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Descuento:</strong> ${{ Pedido::formatearTotal($pedido->descuento) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>50/50:</strong> ${{ Pedido::formatearTotal($pedido->mitad_total) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Observación:</strong>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 me-2" id="p_observacion">{{ $pedido->observacion ?? "Sin observación" }}</p>
                            <button class="btn text-black btn-sm " title="Editar" id="button_editar_observacion">
                                <i class="fas fa-edit"></i>
                            </button>
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
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h5>Estado de Seguimiento del Pedido</h5>
                <div>
                    <span class="text-white " style="cursor:pointer" title="Agregar seguimiento" id="span_agregar_seguimiento">
                        <i class="fas fa-2x fa-plus-circle"></i>
                    </span>
{{--                    <span class="text-white " style="cursor:pointer" title="Seguir seguimiento por orden" id="span_seguir_seguimiento">--}}
{{--                        <i class="fas fa-2x fa-arrow-circle-right"></i>--}}
{{--                    </span>--}}
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tabla_seguimiento">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Estado</th>
                        <th>Mensaje</th>
                        <th>Fecha de Actualización</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody id="tbody_seguimiento">
                    @foreach ($seguimientos as $seguimiento)
                        <tr>
                            <td>{{ $seguimiento->id }}</td>
                            <td>{{ $seguimiento->estado->nombre }}</td>
                            <td>{{ $seguimiento->mensaje }}</td>
                            <td>{{ Pedido::formatearFecha($seguimiento->fecha_actualizacion) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm button_editar_seguimiento" title="Editar"  data-id="{{ $seguimiento->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
    <div class="modal fade" id="modal_ver_pagos" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" >Pagos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Estado del pago:</strong> <span id="span_estado_pago"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Método del pago:</strong> <span id="span_metodo_pago"></span>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="align-middle">Pago parcial</th>
                                <th>
                                    <button class="btn btn-primary btn" id="button_pagar_parcial" title="Pagar Parcial">
                                        <i class="fa-solid fa-clock fa-2x"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Monto Pagado Parcial
                                    <button class="btn text-black btn-sm button-editar" data-target-type="text" data-target="#td_monto_pagado_parcial" data-button-save="#tfoot_guardar_cambios_parcial" title="Editar" id="button_editar_monto_parcial">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td>Fecha Pago Parcial
                                    <button class="btn text-black btn-sm button-editar" data-target-type="date" data-target="#td_fecha_pago_parcial" data-button-save="#tfoot_guardar_cambios_parcial" title="Editar" id="button_editar_fecha_parcial">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td id="td_monto_pagado_parcial"></td>
                                <td id="td_fecha_pago_parcial"></td>
                            </tr>
                        </tbody>
                        <tfoot class="tfoot-guardar" id="tfoot_guardar_cambios_parcial">
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-primary button-guardar" id="button_guardar_cambios_parcial" data-monto-target="#td_monto_pagado_parcial" data-fecha-target="#td_fecha_pago_parcial" data-save-type="parcial">
                                        Guardar Cambios
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="align-middle">
                                    Pago total
                                </th>
                                <th>
                                    <button class="btn btn-primary btn" id="button_pagar_total" title="Pagar Total">
                                        <i class="fa-solid fa-check fa-2x"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Monto Pagado Total
                                    <button class="btn text-black btn-sm button-editar" data-button-save="#tfoot_guardar_cambios_total"  data-target-type="text" data-target="#td_monto_pagado_total" title="Editar" id="button_editar_monto_total">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td>Fecha Pago Total
                                    <button class="btn text-black btn-sm button-editar" data-button-save="#tfoot_guardar_cambios_total" data-target-type="date" data-target="#td_fecha_pago_total" title="Editar" id="button_editar_fecha_total">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td id="td_monto_pagado_total"></td>
                                <td id="td_fecha_pago_total"></td>
                            </tr>
                        </tbody>
                        <tfoot class="tfoot-guardar" id="tfoot_guardar_cambios_total">
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-primary button-guardar" id="button_guardar_cambios_total" data-save-type="total" data-monto-target="#td_monto_pagado_total" data-fecha-target="#td_fecha_pago_total">
                                        Guardar Cambios
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
