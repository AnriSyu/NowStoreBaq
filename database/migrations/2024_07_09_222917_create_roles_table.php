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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('rol')->unique();
            $table->string('descripcion')->nullable();
            $table->string('estado_registro')->default('activo');
            $table->timestamps();
        });
        DB::table('roles')->insert([
            [
                'id' => 1,
                'rol' => 'cliente',
                'descripcion' => 'Rol predeterminado de usuarios',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'rol' => 'administrador',
                'descripcion' => 'Rol con permisos administrativos, toda la aplicación',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
