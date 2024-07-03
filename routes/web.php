<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\UsuarioController;
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
})->name("login");

Route::get('/perfil', [UsuarioController::class, 'mostrarPerfil'])->name('perfil')->middleware('auth:web');

Route::post('/articulo', [ArticuloController::class, 'buscarArticuloScrapper']);

route::post('/rginsc', [UsuarioController::class, 'registroIniciarSesion']);

Route::get('/verificar/{token}', [UsuarioController::class, 'verificarCuenta']);

