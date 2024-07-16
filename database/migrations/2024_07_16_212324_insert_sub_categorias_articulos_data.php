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
        DB::table('sub_categorias_articulos')->insert([
            [
                'id' => 1,
                'sub_categoria' => 'Vestidos',
                'imagen' => 'uploads/categorias/vestidos.jpg',
                'url_externo'=> '',
                'id_categoria'=> 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'sub_categoria' => 'Blusas',
                'imagen' => 'uploads/categorias/blusas.jpg',
                'url_externo'=> '',
                'id_categoria'=> 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'sub_categoria' => 'Shorts',
                'imagen' => 'uploads/categorias/shorts.jpg',
                'url_externo'=> '',
                'id_categoria'=> 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'sub_categoria' => 'Pantalones',
                'imagen' => 'uploads/categorias/pantalones.jpg',
                'url_externo'=> '',
                'id_categoria'=> 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'sub_categoria' => 'Monos',
                'imagen' => 'uploads/categorias/monos.jpg',
                'url_externo'=> '',
                'id_categoria'=> 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'sub_categoria' => 'Conjuntos',
                'imagen' => 'uploads/categorias/conjuntos.jpg',
                'url_externo'=> '',
                'id_categoria'=> 7,
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
        DB::table('sub_categorias_articulos')->whereIn('id', [1, 2, 3,4,5,6])->delete();
    }
};
