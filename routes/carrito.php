<?php


use App\Http\Controllers\CarritoController;


/**
 * Rutas para el controlador de carrito
 */


Route::middleware('auth')->group(function(){

    /**
     * Ruta para mostrar el formulario de registro de la persona que va a pagar el pedido y la tarjeta de pago
     * GET
     */

    Route::get('/pagar', [CarritoController::class, 'mostrarPagar'])->name('pagar');


    Route::prefix('carrito')->group(function(){

        /**
         * Ruta para guardar la persona que va a pagar el pedido
         * POST
         */
        Route::post('guardar-persona', [CarritoController::class, 'guardarPersona']);
        Route::get('guardar-persona', function () {
            return abort(404);
        });

        /**
         * Ruta para pagar el pedido
         * POST
         */
        Route::post('pagar', [CarritoController::class, 'pagarPedido']);
        Route::get('pagar', function () {
            return abort(404);
        });


    });


});







