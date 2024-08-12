<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\SubCategoria;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class CatalogoController extends Controller
{
    public function mostrarCatalogo(){

        $categorias = Categoria::with('subcategorias')->get();

        return view("principal.catalogo",compact('categorias'));
    }
}
