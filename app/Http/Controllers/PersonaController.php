<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonaController extends Controller
{
    public function save(Request $request){
        $reglas = [
            'input_nombres' => 'required|string|max:255',
            'input_apellidos' => 'required|string|max:255',
            'input_direccion' => 'required|string|max:255',
            'input_celular' => 'required|digits:10',
            'input_codigo_postal' => 'required|digits:6',
            'input_referencias' => 'nullable|string|max:255',
            'select_departamento' => 'required|exists:departamentos,id',
            'select_municipio' => 'required|exists:municipios,id',
        ];

        $mensajes = [
            'input_nombres.required' => 'El campo nombres es obligatorio.',
            'input_nombres.string' => 'El campo nombres debe ser una cadena de texto.',
            'input_nombres.max' => 'El campo nombres no puede tener más de 255 caracteres.',
            'input_apellidos.required' => 'El campo apellidos es obligatorio.',
            'input_apellidos.string' => 'El campo apellidos debe ser una cadena de texto.',
            'input_apellidos.max' => 'El campo apellidos no puede tener más de 255 caracteres.',
            'input_direccion.required' => 'El campo dirección es obligatorio.',
            'input_direccion.string' => 'El campo dirección debe ser una cadena de texto.',
            'input_direccion.max' => 'El campo dirección no puede tener más de 255 caracteres.',
            'input_celular.required' => 'El campo celular es obligatorio.',
            'input_celular.digits' => 'El campo celular debe tener exactamente 10 dígitos.',
            'select_departamento.required' => 'El campo departamento es obligatorio.',
            'select_departamento.exists' => 'El departamento seleccionado no es válido.',
            'select_municipio.required' => 'El campo municipio es obligatorio.',
            'select_municipio.exists' => 'El municipio seleccionado no es válido.',
            'input_codigo_postal.required' => 'El campo código postal es obligatorio.',
            'input_codigo_postal.digits' => 'El campo código postal debe tener exactamente 6 dígitos.',
            'input_referencias.string' => 'El campo referencias debe ser una cadena de texto.',
            'input_referencias.max' => 'El campo referencias no puede tener más de 255 caracteres.',
        ];

        $validator = Validator::make($request->all(), $reglas, $mensajes);

        if ($validator->fails()):
            return response()->json(['errors' => $validator->errors()], 422);
        endif;

        $usuario = auth()->user();

        $personaData = [
            'id_usuario' => $usuario->id,
            'nombres' => $request->input_nombres,
            'apellidos' => $request->input_apellidos,
            'direccion' => $request->input_direccion,
            'celular' => $request->input_celular,
            'codigo_postal' => $request->input_codigo_postal,
            'referencias' => $request->input_referencias,
            'id_departamento' => $request->select_departamento,
            'id_municipio' => $request->select_municipio,
        ];

        $personaM = Persona::updateOrCreate(['id_usuario' => $usuario->id], $personaData);

        return response()->json(['estado' => 'ok', 'mensaje' => 'Datos guardados correctamente.']);
    }
}
