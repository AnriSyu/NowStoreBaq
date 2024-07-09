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
    return view('principal.buscar_articulo');
});

route::get('/carrito',function() {
    return view('principal.carrito_articulos');
});

route::get('/recuperar_cuenta',function() {
    return view('recuperacion_cuenta.recuperar_cuenta');
});

Route::post('/articulo', [ArticuloController::class, 'buscarArticuloScrapper']);


route::get('/ingresar',[UsuarioController::class,'mostrarIngresar'])->name("login");

Route::get('/perfil', [UsuarioController::class, 'mostrarPerfil'])->name('perfil')->middleware('auth:web');

route::post('/rginsc', [UsuarioController::class, 'registroIniciarSesion']);

route::post('/reccun', [UsuarioController::class, 'recuperarCuenta']);

route::post('/cbrclv', [UsuarioController::class, 'actualizarClave']);

Route::get('/verificar/{token}', [UsuarioController::class, 'verificarCuenta']);

Route::get('/cambiar_clave/{token}', [UsuarioController::class, 'cambiarClave']);

