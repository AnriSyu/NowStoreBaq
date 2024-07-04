<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('token_cambio_clave')->nullable();
            $table->timestamp('fecha_expiracion_cambio_clave')->nullable();
            $table->timestamp('fecha_ultimo_cambio_clave')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['token_cambio_clave', 'fecha_expiracion_cambio_clave', 'fecha_ultimo_cambio_clave']);
        });
    }
};
