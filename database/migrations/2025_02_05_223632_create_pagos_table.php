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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pedido')->constrained('pedidos')->onDelete('cascade');
            $table->decimal('monto_pagado_parcial', 10, 2)->nullable();
            $table->decimal('monto_pagado_total', 10, 2)->nullable();
            $table->dateTime('fecha_pago_parcial')->nullable();
            $table->dateTime('fecha_pago_total')->nullable();
            $table->string('metodo_pago', 50)->default('whatsapp');
            $table->enum('estado_pago', ['pendiente', 'parcial', 'completo'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
