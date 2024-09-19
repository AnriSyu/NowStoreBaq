<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public function getByIdDepartamento(Request $request)
    {
        $response = ["estado" => "error", "mensaje" => "No se encontraron municipios", "data" => []];
        $idDepartamento = $request->input('idDepartamento');
        $municipios = Municipio::where('id_departamento', $idDepartamento)->get();
        if ($municipios->count() > 0) {
            $response = ["estado" => "ok", "mensaje" => "Municipios encontrados", "data" => $municipios];
        }
        return response()->json($response);
    }
}
