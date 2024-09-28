<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function mostrarPedidos()
    {

        $pedidos = Pedido::paginate(35);

        return view('admin.pedidos.pedidos', compact('pedidos'));
    }

    public function mostrarPedido($url_pedido)
    {
        //verificar que el pedido exista

        $pedido = Pedido::where('url_pedido', $url_pedido)->first();

        if(!$pedido):
            return redirect()->route('admin.pedidos');
        endif;

        return view('admin.pedidos.pedido', compact('url_pedido'));
    }

    public function get(Request $request)
    {
        $request->validate([
            'input_nombre' => 'nullable|string|max:255',
            'select_estado_pedido' => 'nullable|in:a pagar,pendiente,en envio,entregado,cancelado',
            'input_fecha_ingreso' => 'nullable|date',
            'input_fecha_entregado' => 'nullable|date|after_or_equal:input_fecha_ingreso',
        ]);

        $query = Pedido::with('usuario.persona');


        $nombre = $request->input('input_nombre');
        $estado_pedido = $request->input('select_estado_pedido');
        $fecha_ingreso = $request->input('input_fecha_ingreso');
        $fecha_entregado = $request->input('input_fecha_entregado');


        $query->when($nombre, function ($q) use ($nombre) {
            $q->whereHas('usuario.persona', function ($q) use ($nombre) {
                $q->where(function ($query) use ($nombre) {
                    $query->where('nombres', 'like', "%{$nombre}%")
                        ->orWhere('apellidos', 'like', "%{$nombre}%");
                });
            });
        });

        if($estado_pedido):
            $query->where('estado_pedido', $estado_pedido);
        endif;

        if($fecha_ingreso):
            $query->where('fecha_ingreso', $fecha_ingreso);
        endif;

        if($fecha_entregado):
            $query->where('fecha_entregado', $fecha_entregado);
        endif;


        $pedidos = $query->paginate(35);


        return response()->json($pedidos);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'url_pedido' => 'required|exists:pedidos,url_pedido',
            'estado_pedido' => 'sometimes|string|in:a pagar,pendiente,en envio,entregado,cancelado',
        ]);

        $pedido = Pedido::where('url_pedido', $request->url_pedido)->first();

        foreach ($request->except('url_pedido') as $key => $value) {
            if (in_array($key, $pedido->getFillable())) {
                $pedido->$key = $value;
            }
        }

        $pedido->save();

        return response()->json(['message' => 'Pedido actualizado correctamente']);
    }

    public function softDelete(Request $request)
    {
        $validatedData = $request->validate([
            'url_pedido' => 'required|exists:pedidos,url_pedido',
        ]);

        $pedido = Pedido::where('url_pedido', $request->url_pedido)->first();

        $pedido->estado_registro = 'inactivo';

        $pedido->save();

        return response()->json(['message' => 'Pedido eliminado correctamente']);

    }

    public function restore(Request $request)
    {
        $validatedData = $request->validate([
            'url_pedido' => 'required|exists:pedidos,url_pedido',
        ]);

        $pedido = Pedido::where('url_pedido', $request->url_pedido)->first();

        $pedido->estado_registro = 'activo';

        $pedido->save();

        return response()->json(['message' => 'Pedido restaurado correctamente']);

    }


}
