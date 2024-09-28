<?php

use App\Http\Controllers\PedidoController;


Route::middleware(['auth','admin'])->group(function(){

    Route::prefix('admin/controlador/pedidos')->group(function(){
        Route::get('get', [PedidoController::class, 'get']);
        Route::post('update', [PedidoController::class, 'update'])->name('pedidoController.update');
        Route::post('soft-delete', [PedidoController::class, 'softDelete']);
        Route::post('restore', [PedidoController::class, 'restore']);
        Route::post('pdf', [PedidoController::class, 'pdf']);
        Route::post('entregar', [PedidoController::class, 'entregar']);
        Route::post('cancelar', [PedidoController::class, 'cancelar']);
        Route::post('cambiar-estado', [PedidoController::class, 'cambiarEstado']);
    });


});
