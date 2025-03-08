<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeguimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estado_seguimiento')->insert([
            ['nombre' => 'Confirmado', 'descripcion' => 'El pedido ha sido confirmado por el vendedor.'],
            ['nombre' => 'Preparando', 'descripcion' => 'El pedido está siendo preparado para envío.'],
            ['nombre' => 'En camino', 'descripcion' => 'El pedido ha salido del almacén y está en proceso de entrega.'],
            ['nombre' => 'Intento de entrega', 'descripcion' => 'Hubo un intento de entrega, pero no se pudo completar.'],
            ['nombre' => 'Entregado', 'descripcion' => 'El pedido ha sido entregado al cliente.'],
            ['nombre' => 'Pago pendiente', 'descripcion' => 'El pedido requiere un pago pendiente antes del envío.'],
            ['nombre' => 'Pago completado', 'descripcion' => 'El pago del pedido ha sido recibido en su totalidad.'],
            ['nombre' => 'Cancelado', 'descripcion' => 'El pedido ha sido cancelado por el cliente o el vendedor.'],
            ['nombre' => 'Devuelto', 'descripcion' => 'El pedido ha sido devuelto al vendedor.'],
            ['nombre' => 'Reembolso procesado', 'descripcion' => 'El reembolso del pedido ha sido realizado con éxito.'],
        ]);
    }
}
