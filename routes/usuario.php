<?php


use App\Http\Controllers\UsuarioController;


/**
 * Rutas para el controlador de usuario
 */

/**
 * Ruta para mostrar el formulario de registro o iniciar sesión
 * GET
 */
Route::get('/ingresar',[UsuarioController::class,'mostrarIngresar'])->name("login");

/**
 * Ruta para registrar o iniciar sesión al usuario
 * POST
 */
Route::post('/rginsc', [UsuarioController::class, 'registroIniciarSesion']);
Route::get('/rginsc', function () {
    return abort(404);
});

/**
 * Ruta para mostrar el formulario de recuperación de cuenta
 * GET
 */
route::get('/recuperar_cuenta',function() {
    return view('usuario.recuperar_cuenta');
});

/**
 * Ruta para cerrar sesión
 * GET
 */
Route::get('/logout', [UsuarioController::class, 'cerrarSesion'])->name('logout');

/**
 * Ruta para procesar el formulario de recuperación de cuenta
 * POST
 */
Route::post('/reccun', [UsuarioController::class, 'recuperarCuenta']);
Route::get('/reccun', function () {
    return abort(404);
});

/**
 * Ruta para procesar el formulario de cambio de clave
 * POST
 */
Route::post('/cbrclv', [UsuarioController::class, 'actualizarClave']);
Route::get('/cbrclv', function () {
    return abort(404);
});

/**
 * Ruta para verificar la cuenta
 * GET
 * {token} token de verificación, generado al solicitar la recuperación de cuenta, guardado en la tabla de usuarios, enviado por correo
 */
Route::get('/verificar/{token}', [UsuarioController::class, 'verificarCuenta']);

/**
 * Ruta para mostrar el formulario de cambio de clave
 * GET
 * {token} token de verificación, generado al solicitar la recuperación de cuenta, guardado en la tabla de usuarios, enviado por correo
 */
Route::get('/cambiar_clave/{token}', [UsuarioController::class, 'cambiarClave']);

