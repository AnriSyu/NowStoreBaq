<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CatalogoController;
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

route::get('/carrito',function() {
    return view('principal.carrito_articulos');
})->name('carrito');

Route::get('/buscar-articulo', function () {
    return view('principal.buscar_articulo');
});

route::get('/recuperar_cuenta',function() {
    return view('recuperacion_cuenta.recuperar_cuenta');
});


Route::get('/',[CatalogoController::class, 'mostrarCatalogo'])->name("catalogo");

Route::post('/articulo', [ArticuloController::class, 'buscarArticuloScrapper']);

Route::get('/ingresar',[UsuarioController::class,'mostrarIngresar'])->name("login");

Route::post('/genpedido',[ArticuloController::class,'generarPedido']);

Route::get('/pagar', [CarritoController::class, 'pagarPedido'])->name('pagar');

Route::post('/rginsc', [UsuarioController::class, 'registroIniciarSesion']);


Route::post('/reccun', [UsuarioController::class, 'recuperarCuenta']);
Route::post('/cbrclv', [UsuarioController::class, 'actualizarClave']);


Route::get('/verificar/{token}', [UsuarioController::class, 'verificarCuenta']);
Route::get('/cambiar_clave/{token}', [UsuarioController::class, 'cambiarClave']);

Route::get('/logout', [UsuarioController::class, 'cerrarSesion'])->name('logout');

//Route::get('/perfil', [UsuarioController::class, 'mostrarPerfil'])->name('perfil')->middleware('auth:web');



Route::post('/controlador/municipios/get', [ApiController::class, 'getMunicipios']);
