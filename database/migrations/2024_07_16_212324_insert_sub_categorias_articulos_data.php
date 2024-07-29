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
                'url_externo'=> 'https://www.canva.com/design/DAFZ-y7mj6k/vemYs0NXainjMAeuaUKPtw/view?website#2',
                'id_categoria'=> 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'sub_categoria' => 'Blusas',
                'imagen' => 'uploads/categorias/blusas.jpg',
                'url_externo'=> 'https://www.canva.com/design/DAFal1iOXwA/hAbuw87G90IWx_jgj8GUQg/view?website#2',
                'id_categoria'=> 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'sub_categoria' => 'Faldas',
                'imagen' => 'uploads/categorias/faldas.jpg',
                'url_externo'=> 'https://www.canva.com/design/DAGME-rLAaA/nWeq4n4dtFxZ_bnme0KlFQ/view',
                'id_categoria'=> 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'sub_categoria' => 'Pantalones y Shorts',
                'imagen' => 'uploads/categorias/pantalones.jpg',
                'url_externo'=> 'https://www.canva.com/design/DAFczM12uzk/zuSQfLOTHx__NzBahochSw/view',
                'id_categoria'=> 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'sub_categoria' => 'Monos',
                'imagen' => 'uploads/categorias/monos.jpg',
                'url_externo'=> 'https://www.canva.com/design/DAGME7fOVgQ/VZl30D9OhYtp-dChmyIHpA/view',
                'id_categoria'=> 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'sub_categoria' => 'Conjuntos',
                'imagen' => 'uploads/categorias/conjuntos.jpg',
                'url_externo'=> 'https://www.canva.com/design/DAGMEzl4LgI/esSK6hUtUrCJAgrFZLMf-w/view',
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
