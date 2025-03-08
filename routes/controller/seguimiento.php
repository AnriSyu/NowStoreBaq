<?php

use App\Http\Controllers\SeguimientoController as Seguimiento;


Route::middleware(['auth','admin'])->group(function(){

    Route::prefix('admin/controlador/seguimiento')->group(function(){
        Route::get('get', [Seguimiento::class, 'get']);
        Route::post('insert', [Seguimiento::class, 'insert']);
        Route::post('update', [Seguimiento::class, 'update']);
    });


});
