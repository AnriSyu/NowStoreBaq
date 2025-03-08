<?php

namespace App\Http\Controllers;

use App\Models\EstadoSeguimiento;
use App\Models\Pedido;
use App\Models\Seguimiento;
use Illuminate\Http\Request;
use App\Models\Pago;

class PagoController extends Controller
{
    public function getByUrl(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'url_pedido' => 'required|string|exists:pedidos,url_pedido',
        ]);

        $response = ["estado" => "error", "mensaje" => "No se encontraron pagos", "data" => []];

        $url_pedido = $request->input('url_pedido');

        $pedido = Pedido::where('url_pedido', $url_pedido)->get();

        if ($pedido->count() == 0) {
            return response()->json($response);
        }
        $pagos = Pago::where('id_pedido', $pedido[0]->id)->get();

        if ($pagos->count() > 0) {
            $response = ["estado" => "ok", "mensaje" => "Pagos encontrados", "data" => $pagos];
        }

        return response()->json($response);
    }

    public function pagarParcial(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'url_pedido' => 'required|string|exists:pedidos,url_pedido',
        ]);

        $response = ["estado" => "error", "mensaje" => "No se pudo realizar el pago", "data" => []];

        $url_pedido = $request->input('url_pedido');

        $pedido = Pedido::where('url_pedido', $url_pedido)->first();

        if ($pedido->count() == 0) {
            return response()->json($response);
        }

        $montoMitad = $pedido->mitad_total;

        $pago = Pago::where('id_pedido', $pedido->id)->update([
            'monto_pagado_parcial' => $montoMitad,
            'fecha_pago_parcial' => date('Y-m-d H:i:s'),
            'estado_pago' => 'parcial'
        ]);

        $segui = new Seguimiento();
        $estadoSeguimiento = EstadoSeguimiento::where('nombre', 'Pago pendiente')->first();

        $segui->id_pedido = $pedido->id;
        $segui->id_estado = $estadoSeguimiento->id;
        $segui->fecha_actualizacion = now();
        $segui->mensaje = 'Pago parcial realizado';

        $segui->save();

        $response = ["estado" => "ok", "mensaje" => "Pago realizado", "data" => $pago];

        return response()->json($response);
    }

    public function pagarTotal(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'url_pedido' => 'required|string|exists:pedidos,url_pedido',
        ]);

        $response = ["estado" => "error", "mensaje" => "No se pudo realizar el pago", "data" => []];

        $url_pedido = $request->input('url_pedido');

        $pedido = Pedido::where('url_pedido', $url_pedido)->get();

        if ($pedido->count() == 0) {
            return response()->json($response);
        }

        $montoTotal = $pedido[0]->total;
        $montoMitad = $pedido[0]->mitad_total;

        if ($montoTotal == $montoMitad) {
            return response()->json($response);
        }

        $montoTotal = $montoTotal - $montoMitad;

        $pago = Pago::where('id_pedido', $pedido[0]->id)->update([
            'monto_pagado_total' => $montoTotal,
            'fecha_pago_total' => date('Y-m-d H:i:s'),
            'estado_pago' => 'completo'
        ]);

        $segui = new Seguimiento();
        $estadoSeguimiento = EstadoSeguimiento::where('nombre', 'Pago completado')->first();

        $segui->id_pedido = $pedido->id;
        $segui->id_estado = $estadoSeguimiento->id;
        $segui->fecha_actualizacion = now();
        $segui->mensaje = 'Pago total realizado';

        $segui->save();

        $response = ["estado" => "ok", "mensaje" => "Pago realizado", "data" => $pago];

        return response()->json($response);
    }

    public function updateFechaMonto(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'url_pedido' => 'required|string|exists:pedidos,url_pedido',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'tipo' => 'required|in:parcial,total'
        ]);

        $response = ["estado" => "error", "mensaje" => "No se pudo realizar la actualización", "data" => []];

        $url_pedido = $request->input('url_pedido');

        $pedido = Pedido::where('url_pedido', $url_pedido)->get();

        if ($pedido->count() == 0) {
            return response()->json($response);
        }

        $monto = $request->input('monto');

        $fecha = $request->input('fecha');

        $tipo = $request->input('tipo');

        $monto = $monto == 'nada' || $monto == '' ? $pedido[0]->mitad_total : $monto;

        $fecha = $fecha == 'nada' || $fecha == '' ? $pedido[0]->fecha_ingreso : $fecha;

        if($fecha != $pedido[0]->fecha_ingreso):
            $fecha = date('Y-m-d H:i:s', strtotime($fecha));
        endif;


        if ($tipo == 'parcial') {
            $pago = Pago::where('id_pedido', $pedido[0]->id)->update([
                'monto_pagado_parcial' => $monto,
                'fecha_pago_parcial' => $fecha,
                'estado_pago' => 'parcial'
            ]);
        } else {
            $pago = Pago::where('id_pedido', $pedido[0]->id)->update([
                'monto_pagado_total' => $monto,
                'fecha_pago_total' => $fecha,
                'estado_pago' => 'completo'
            ]);
        }

        $response = ["estado" => "ok", "mensaje" => "Actualización realizada", "data" => $pago];

        return response()->json($response);
    }

}
