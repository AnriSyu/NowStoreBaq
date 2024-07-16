<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogoController extends Controller
{
    public function mostrarCatalogo(){

        $categorias = Categoria::with('subcategorias')->get();

        return view("principal.catalogo",compact('categorias'));
    }
}
