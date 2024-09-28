<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function mostrarPanel()
    {

        return view('admin.panel');
    }


    public function mostrarUsuarios()
    {
        $usuarios = Usuario::all();

        return view('admin.usuarios', compact('usuarios'));
    }


}
