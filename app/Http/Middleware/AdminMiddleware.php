<?php

namespace App\Http\Middleware;

use App\Models\Rol;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = Auth::user();
        $rol = Rol::where('id',$usuario->id_rol)->first();
        if (Auth::check() && $rol->rol === "administrador") {
            return $next($request);
        }
        abort(Response::HTTP_NOT_FOUND);
    }
}
