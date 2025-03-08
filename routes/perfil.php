<?php

use App\Http\Controllers\PerfilController;

Route::middleware('auth')->group(function () {

    Route::prefix('usuario')->group(function () {

        /**
         * Ruta para mostrar el perfil del usuario
         * GET
         */
        Route::get('perfil', [PerfilController::class, 'mostrarPerfil'])->name('usuario.perfil');


        /**
         * Ruta para mostrar la lista de pedidos del usuario
         * GET
         */
        Route::get('pedidos', [PerfilController::class, 'listaPedidos'])->name('usuario.pedidos');

        Route::prefix('pedido')->group(function () {
            Route::post('ver-carrito', [PerfilController::class, 'verCarrito'])->name('usuario.pedidos.ver-carrito');
            Route::post('ver-seguimiento', [PerfilController::class, 'verSeguimiento'])->name('usuario.pedidos.ver-seguimiento');
        });

    });
});
