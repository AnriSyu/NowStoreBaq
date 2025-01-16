<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function mostrarPedidos()
    {
        $pedidos = Pedido::orderBy('fecha_ingreso', 'desc')->paginate(35);

        return view('admin.pedidos.pedidos', compact('pedidos'));
    }

    public function mostrarPedido($url_pedido)
    {

        $pedido = Pedido::where('url_pedido', $url_pedido)->first();

        if(!$pedido):
            return redirect()->route('admin.pedidos');
        endif;


        return view('admin.pedidos.pedido', compact('pedido'));
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
            'observacion' => 'sometimes|string|max:255',
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

    public function entregar(Request $request)
    {
        $validatedData = $request->validate([
            'url_pedido' => 'required|exists:pedidos,url_pedido',
        ]);

        $pedido = Pedido::where('url_pedido', $request->url_pedido)->first();

        $pedido->estado_pedido = 'entregado';
        $pedido->fecha_entregado = now();
        $pedido->fecha_cancelado = null;

        $pedido->save();

        return response()->json(['message' => 'Pedido entregado correctamente']);
    }

    public function cancelar(Request $request)
    {
        $validatedData = $request->validate([
            'url_pedido' => 'required|exists:pedidos,url_pedido',
        ]);

        $pedido = Pedido::where('url_pedido', $request->url_pedido)->first();

        $pedido->estado_pedido = 'cancelado';
        $pedido->fecha_cancelado = now();
        $pedido->fecha_entregado = null;

        $pedido->save();

        return response()->json(['message' => 'Pedido cancelado correctamente']);
    }

    public function cambiarEstado(Request $request)
    {
        $validatedData = $request->validate([
            'url_pedido' => 'required|exists:pedidos,url_pedido',
            'estado_pedido' => 'required|string|in:a pagar,pendiente,en envio,entregado,cancelado',
        ]);
        if($request->estado_pedido == 'entregado'):
            return $this->entregar($request);
        elseif($request->estado_pedido == 'cancelado'):
            return $this->cancelar($request);
        endif;

        $pedido = Pedido::where('url_pedido', $request->url_pedido)->first();
        $pedido->estado_pedido = $request->estado_pedido;
        $pedido->fecha_entregado = null;
        $pedido->fecha_cancelado = null;

        $pedido->save();

        return response()->json(['message' => 'Estado del pedido actualizado correctamente']);
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

    public function pdf(Request $request)
    {
        $validatedData = $request->validate([
            'url_pedido' => 'required|exists:pedidos,url_pedido',
        ]);

        $pedido = Pedido::where('url_pedido', $request->url_pedido)->first();

        $pdf = PDF::loadView('pdfs.factura_pedido', compact('pedido'));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="factura-'.$pedido->url_pedido.'.pdf"');
    }


}
