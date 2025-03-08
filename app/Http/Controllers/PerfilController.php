<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\EstadoSeguimiento;
use App\Models\Municipio;
use App\Models\Pedido;
use App\Models\Persona;
use App\Models\Seguimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function mostrarPerfil()
    {
        $usuario = Auth::user();

        $departamentos = Departamento::all();
        $municipios = Municipio::all();

        $persona = Persona::where('id_usuario', $usuario->id)->first();

        return view("usuario.perfil", compact('usuario', 'departamentos', 'municipios', 'persona'));
    }

    public function listaPedidos()
    {
        $usuario = Auth::user();

        $pedidos = Pedido::where("id_usuario",$usuario->id)->get();

        return view("usuario.pedidos", compact('pedidos'));
    }

    public function verCarrito(Request $request)
    {
        try{
            $pedido = Pedido::where('url_pedido', $request->id)->first();
            $carrito = json_decode($pedido->carrito);

            return response()->json(['carrito' => $carrito]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function verSeguimiento(Request $request)
    {
        try{
            $pedido = Pedido::where('url_pedido', $request->id)->first();
            $seguimientos = Seguimiento::where('id_pedido', $pedido->id)->orderBy('fecha_actualizacion', 'desc')->get();
            $estado_seguimiento = new EstadoSeguimiento();
            foreach($seguimientos as $seguimiento){
                $seguimiento->estado_seguimiento_nombre = $estado_seguimiento->find($seguimiento->id_estado)->nombre;
            }

            return response()->json(['seguimientos' => $seguimientos]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
