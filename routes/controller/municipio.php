<?php

use App\Http\Controllers\MunicipioController;

/**
 * Rutas para el controlador de municipio
 */

/**
 * Ruta para obtener todos los municipios de la base de datos con el id del departamento al que pertenecen
 * post
 */
Route::post('/controlador/municipios/getByIdDepartamento', [MunicipioController::class, 'getByIdDepartamento']);
Route::get('/controlador/municipios/getByIdDepartamento', function () {
    return abort(404);
});
