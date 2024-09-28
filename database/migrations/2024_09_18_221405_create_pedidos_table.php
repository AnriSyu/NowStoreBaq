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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade');
            $table->timestamp('fecha_ingreso')->useCurrent();
            $table->timestamp('fecha_entregado')->nullable();
            $table->timestamp('fecha_cancelado')->nullable();
            $table->enum('estado_pedido', ['a pagar', 'pendiente', 'en envio', 'entregado','cancelado'])->default('pendiente');
            $table->json('carrito');
            $table->string('observacion')->nullable();
            $table->string('estado_registro')->default('activo');
            $table->string('url_pedido')->nullable();
            $table->decimal('total', 10, 2);
            $table->decimal('descuento', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
