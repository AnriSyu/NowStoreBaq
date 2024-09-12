<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function pagarPedido()
    {
        if (empty(session('carrito'))) {
            return redirect()->route('carrito');
        }

        if (!auth()->check()) {
            return redirect()->route('carrito');
        }

        $departamentos = Departamento::all();

        $total = session('total');
        $descuento = session('descuento');
        $carrito = session('carrito');

        $totalFormato = "$" . number_format($total, 2, ',', '.');

        $descuentoFormato = "$" . number_format($descuento, 2, ',', '.');

        return view('principal.pagar', compact('departamentos', 'total', 'descuento', 'carrito', 'totalFormato', 'descuentoFormato'));
    }
}
