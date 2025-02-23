<?php

use App\Http\Controllers\PagoController;


Route::middleware(['auth','admin'])->group(function(){
    Route::prefix('/admin/controlador/pago/')->group(function(){
        Route::post('getByUrl', [PagoController::class, 'getByUrl']);
        Route::post('pagar-parcial', [PagoController::class, 'pagarParcial']);
        Route::post('pagar-total', [PagoController::class, 'pagarTotal']);
        route::post('updateFechaMonto', [PagoController::class, 'updateFechaMonto']);
    });
});
