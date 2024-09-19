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
        Schema::create('sub_categorias_articulos', function (Blueprint $table) {
            $table->id();
            $table->string('sub_categoria');
            $table->foreignId('id_categoria')->constrained('categorias_articulos')->onDelete('cascade');
            $table->text('descripcion')->nullable();
            $table->string('estado_registro')->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categorias_articulos');
    }
};
