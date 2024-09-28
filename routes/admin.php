<?php




use App\Http\Controllers\AdminController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UsuarioController;


/**
 * Rutas para el controlador de administrador
 */


Route::middleware(['auth','admin'])->group(function(){

    /**
     * Ruta para mostrar el panel de administrador
     * GET
     */
    Route::get('admin', [AdminController::class, 'mostrarPanel'])->name('admin.panel');

    Route::prefix('admin')->group(function(){

        /**
         * Ruta para mostrar la lista de usuarios
         * GET
         */
        Route::get('lista-usuarios', [AdminController::class, 'mostrarUsuarios'])->name('admin.usuarios');

        /**
         * Ruta para mostrar la lista de pedidos
         * GET
         */
        Route::get('lista-pedidos', [PedidoController::class, 'mostrarPedidos'])->name('admin.pedidos');

        /**
         * Ruta para mostrar un pedido
         * GET
         * @param string $url_pedido: URL del pedido de la base de datos
         */
        Route::get('pedido/{url_pedido}', [PedidoController::class, 'mostrarPedido'])->name('admin.pedido');

        /**
         * Ruta para mostrar los ajustes de perfil
         * GET
         */
        Route::get('ajustes-perfil', [AdminController::class, 'mostrarAjustesPerfil'])->name('admin.ajustes-perfil');


        Route::get('cerrar-sesion', [UsuarioController::class, 'cerrarSesion'])->name('admin.cerrar-sesion');

    });

});
