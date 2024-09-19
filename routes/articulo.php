<?php


use App\Http\Controllers\ArticuloController;


/**
 * Rutas para el controlador de articulo
 */


/**
 * Ruta para buscar un articulo, se hace scrapping a la página de la tienda, se obtiene la información del articulo y se guarda en la base de datos
 * POST
 */
Route::post('/articulo', [ArticuloController::class, 'buscarArticuloScrapper']);
Route::get('/articulo', function () {
    return abort(404);
});

/**
 * Ruta para generar el pedido de los articulos
 * POST
 */
Route::post('/genpedido',[ArticuloController::class,'generarPedido']);
Route::get('/genpedido', function () {
    return abort(404);
});
