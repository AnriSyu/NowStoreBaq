<?php


use App\Http\Controllers\PersonaController;

Route::middleware('auth')->group(function(){
    Route::prefix('controlador/persona')->group(function(){
        Route::post('save', [PersonaController::class, 'save']);
    });
});
