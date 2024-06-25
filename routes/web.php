<?php

use App\Http\Controllers\ArticuloController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('buscar_articulo');
});

route::get('/carrito',function() {
    return view('carrito_articulos');
});

route::get('/ingresar',function(){
   return view('usuario_ingresar');
});

Route::post('/articulo', [ArticuloController::class, 'buscarArticuloScrapper']);
