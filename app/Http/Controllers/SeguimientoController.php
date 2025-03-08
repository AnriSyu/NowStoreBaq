<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Seguimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SeguimientoController extends Controller
{
    public function get(Request $request): \Illuminate\Http\JsonResponse
    {
        $response = ["estado" => "error", "mensaje" => "No se encontraron seguimientos", "data" => []];

        $seguimientos = Seguimiento::all()->sortByDesc('fecha_actualizacion');

        if ($seguimientos->count() > 0) {
            $response = ["estado" => "ok", "mensaje" => "Seguimientos encontrados", "data" => $seguimientos];
        }

        return response()->json($response);
    }

    public function insert(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'url_pedido' => 'required|string|exists:pedidos,url_pedido',
            'estado_seguimiento' => 'required|integer|exists:estado_seguimiento,id',
        ]);

        $response = ["estado" => "error", "mensaje" => "No se pudo insertar el seguimiento", "data" => []];

        $mensaje = $request->input('mensaje') == "" ? "Sin mensaje" : $request->input('mensaje');

        $pedido = Pedido::where('url_pedido', $request->input('url_pedido'))->first();

        if ($pedido->count() == 0) {
            return response()->json($response);
        }

        $idPedido = $pedido->id;

        $seguimiento = new Seguimiento();
        $seguimiento->id_pedido = $idPedido;
        $seguimiento->id_estado = $request->input('estado_seguimiento');
        $seguimiento->fecha_actualizacion = Carbon::parse($request->input('fecha'))->format('Y-m-d H:i:s');
        $seguimiento->mensaje = $mensaje;

        $seguimiento->save();

        $response = ["estado" => "ok", "mensaje" => "Seguimiento insertado", "data" => $seguimiento];

        return response()->json($response);
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'id' => 'required|integer|exists:seguimientos,id',
            'estado_seguimiento' => 'required|integer|exists:estado_seguimiento,id',
        ]);

        $response = ["estado" => "error", "mensaje" => "No se pudo actualizar el seguimiento", "data" => []];

        $seguimiento = Seguimiento::find($request->input('id'));

        if ($seguimiento->count() == 0) {
            return response()->json($response);
        }

        $seguimiento->id_estado = $request->input('estado_seguimiento');
        $seguimiento->fecha_actualizacion = Carbon::parse($request->input('fecha'))->format('Y-m-d H:i:s');
        $seguimiento->mensaje = $request->input('mensaje');

        $seguimiento->save();

        $response = ["estado" => "ok", "mensaje" => "Seguimiento actualizado", "data" => $seguimiento];

        return response()->json($response);
    }
}
