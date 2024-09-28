<?php

use App\Http\Controllers\PedidoController;


Route::middleware(['auth','admin'])->group(function(){

    Route::prefix('admin/controlador/pedidos')->group(function(){
        Route::get('get', [PedidoController::class, 'get']);
        Route::post('update', [PedidoController::class, 'update']);
        Route::post('soft-delete', [PedidoController::class, 'softDelete']);
        Route::post('restore', [PedidoController::class, 'restore']);
    });


});
