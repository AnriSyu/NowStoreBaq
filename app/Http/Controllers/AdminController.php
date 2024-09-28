<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function mostrarPanel()
    {
        $totalPedidos = Pedido::count();

        $pedidosPendientes = Pedido::where('estado_pedido', 'pendiente')->count();

        $pedidosEntregados = Pedido::where('estado_pedido', 'entregado')->count();

        $pedidosCancelados = Pedido::where('estado_pedido', 'cancelado')->count();

        $ingresosTotales = Pedido::where('estado_pedido', 'entregado')->sum('total');

        $ultimosPedidos = Pedido::orderBy('fecha_ingreso', 'desc')->take(5)->get();

        $ingresosPorMes = Pedido::selectRaw('MONTH(fecha_ingreso) as mes, SUM(total) as total')
            ->whereYear('fecha_ingreso', Carbon::now()->year)
            ->groupBy('mes')
            ->pluck('total', 'mes');

        return view('admin.panel', compact('totalPedidos', 'pedidosPendientes', 'pedidosEntregados', 'ingresosTotales', 'ultimosPedidos', 'ingresosPorMes', 'pedidosCancelados'));
    }


    public function mostrarUsuarios()
    {
        $usuarios = Usuario::all();

        return view('admin.usuarios', compact('usuarios'));
    }


}
