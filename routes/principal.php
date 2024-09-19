<?php


use App\Http\Controllers\CatalogoController;


/**
 * Rutas para el controlador de catalogo
 */


/**
 * Ruta para mostrar el catalogo de articulos
 * GET
 */
Route::get('/',[CatalogoController::class, 'mostrarCatalogo'])->name("catalogo");

/**
 * Ruta para mostrar el formulario de buscar articulos
 * GET
 */
Route::get('/buscar-articulo', function () {
    return view('principal.buscar_articulo');
});

/**
 * Ruta para mostrar el carrito de articulos
 * GET
 */
route::get('/carrito',function() {
    return view('principal.carrito_articulos');
})->name('carrito');






