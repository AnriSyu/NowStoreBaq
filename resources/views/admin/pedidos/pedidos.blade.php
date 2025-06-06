@php
    use \Carbon\Carbon;
    use Illuminate\Support\Str;
    use App\Models\Pedido;
@endphp
@extends('admin.layouts.panel')

@section('header')
    <h1 class="h3 mb-0 text-gray-800">Lista de Pedidos</h1>
@endsection

@section('titulo', 'Lista de Pedidos')

@section('contenido')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm my-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Filtrar Pedidos</h5>
                </div>
                <div class="card-body">
                    <form method="GET"  class="row g-3" id="form_filtro_pedido">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md">
                                <label for="input_nombre" class="form-label">Nombre del cliente</label>
                                <input type="text" id="input_nombre" name="input_nombre" class="form-control" value="{{ request('nombre') }}" placeholder="Nombre del cliente">
                            </div>

                            <div class="col-md">
                                <label for="select_estado_pedido" class="form-label">Estado del Pedido</label>
                                <select id="select_estado_pedido" name="select_estado_pedido" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="a pagar" {{ request('estado') == 'a pagar' ? 'selected' : '' }}>A pagar</option>
                                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="en envio" {{ request('estado') == 'en envio' ? 'selected' : '' }}>En envio</option>
                                    <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                    <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md">
                                <label for="input_fecha_ingreso" class="form-label">Fecha de creación</label>
                                <input type="date" id="input_fecha_ingreso" name="input_fecha_ingreso" class="form-control" value="{{ request('fecha') }}">
                            </div>
                            <div class="col-md">
                                <label for="input_fecha_entregado" class="form-label">Fecha entregado</label>
                                <input type="date" id="input_fecha_entregado" name="input_fecha_entregado" class="form-control" value="{{ request('fecha') }}">
                            </div>
                        </div>

                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary" id="button_buscar_filtro">Buscar</button>
                            <button type="reset" class="btn btn-outline-secondary" id="button_limpiar_filtro">Limpiar</button>
                        </div>

                        <div class="col-md-12" id="div_alerta_error">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong></strong> <span id="span_mensaje_error"></span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm my-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Lista de Pedidos</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="thead-light">
                <tr>
                    <th scope="col"># Pedido</th>
                    <th scope="col">Fecha de ingreso</th>
                    <th scope="col">Fecha entregado / cancelado</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Observación</th>
                    <th scope="col" class="text-end">Total</th>
                    <th scope="col" class="text-end">Descuento</th>
                    <th>50/50 <i class="fas fa-info-circle nsb-info-5050" id="i_info_5050" data-toggle="tooltip" title="Muestra el total de los productos seleccionados para el 50/50 dividido a la mitad."></i></th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody id="tbody_pedidos">
                @foreach ($pedidos as $pedido)
                    <tr class="{{ $pedido->estado_registro == 'inactivo' ? 'table-secondary' : '' }}">

                        <td>{{ $pedido->url_pedido }}</td>
                        <td>{{ Carbon::parse($pedido->fecha_ingreso)->format('Y-m-d')}}</td>
                        @php
                            $resultado = Pedido::ObtenerFechaYColor($pedido);
                        @endphp
                        <td class="{{ $resultado['color'] }}">{{ $resultado['fecha'] }}</td>
                        <td>{{ "{$pedido->persona->nombres} {$pedido->persona->apellidos}" }}</td>
                        <td>
                            <span class="badge p-2 ms-2 {{ Pedido::colorEstado($pedido->estado_pedido) }}">{{ $pedido->estado_pedido }}</span>
                        </td>
                        <td>
                            @if($pedido->observacion)
                                <a style="cursor:pointer" class="a_ver_observacion" data-id="{{$pedido->observacion}}">
                                    {{ Str::limit($pedido->observacion, 20, '...') }}
                                </a>
                            @else
                                <span>Sin observación</span>
                            @endif
                        </td>
                        <td class="text-end">${{ number_format($pedido->total, 2) }}</td>
                        <td class="text-end">${{ number_format($pedido->descuento, 2) }}</td>
                        <td class="text-end">${{ number_format($pedido->mitad_total, 2) }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.pedido',$pedido->url_pedido) }}" class="btn btn-sm btn-info" title="Ver detalles del pedido">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-warning button_cambiar_estado" title="Cambiar estado" data-id="{{ $pedido->url_pedido }}">
                                <i class="fas fa-exchange-alt"></i>
                            </button>
{{--                            @if($pedido->estado_registro == 'activo')--}}
{{--                                <button class="btn btn-sm btn-danger button_eliminar_registro" title="Eliminar pedido" data-id="{{ $pedido->url_pedido }}">--}}
{{--                                    <i class="fas fa-trash"></i>--}}
{{--                                </button>--}}
{{--                            @else--}}
{{--                                <button class="btn btn-sm btn-success button_activar_registro" title="Activar pedido" data-id="{{ $pedido->url_pedido }}">--}}
{{--                                    <i class="fas fa-check"></i>--}}
{{--                                </button>--}}
{{--                            @endif--}}
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $pedidos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    <script src="{{asset("js/admin/pedidos.js")}}"></script>
@endsection

