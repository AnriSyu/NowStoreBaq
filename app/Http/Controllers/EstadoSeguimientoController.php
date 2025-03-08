<?php

namespace App\Http\Controllers;

use App\Models\EstadoSeguimiento;
use Illuminate\Http\Request;

class EstadoSeguimientoController extends Controller
{
    public function get(Request $request): \Illuminate\Http\JsonResponse
    {
        $response = ["estado" => "error", "mensaje" => "No se encontraron estados de seguimiento", "data" => []];

        $estados = EstadoSeguimiento::all();

        if ($estados->count() > 0) {
            $response = ["estado" => "ok", "mensaje" => "Estados de seguimiento encontrados", "data" => $estados];
        }

        return response()->json($response);
    }



}
