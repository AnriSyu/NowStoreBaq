<?php


use App\Http\Controllers\EstadoSeguimientoController as EstadoSeguimiento;


Route::middleware(['auth','admin'])->group(function(){

    Route::prefix('admin/controlador/estado_seguimiento')->group(function(){
        Route::get('get', [EstadoSeguimiento::class, 'get']);
        Route::post('insert', [EstadoSeguimiento::class, 'insert']);
        Route::post('update', [EstadoSeguimiento::class, 'update']);
    });


});
