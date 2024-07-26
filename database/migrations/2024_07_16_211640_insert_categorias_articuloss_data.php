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
        DB::table('categorias_articulos')->insert([
            [
                'id' => 1,
                'categoria' => 'Ropa de playa',
                'imagen' => 'uploads/categorias/vestido_bano.jpg',
                'url_externo'=> 'https://www.canva.com/design/DAFbZNON8t8/2XFKlxlfXXt-nUc6kgdARA/view?website#2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'categoria' => 'Ropa deportiva',
                'imagen' => 'uploads/categorias/ropa_deportiva.jpg',
                'url_externo'=> 'https://www.canva.com/design/DAFiXq1Jsw4/T_DuPpd_ITSFl5OG-x7r0g/view?website#2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'categoria' => 'Ropa Curvy Plus',
                'imagen' => 'uploads/categorias/curvy_plus.jpg',
                'url_externo'=> '',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'categoria' => 'Lencería',
                'imagen' => 'uploads/categorias/lenceria.jpg',
                'url_externo'=> '',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'categoria' => 'Pijamas',
                'imagen' => 'uploads/categorias/pijamas.jpg',
                'url_externo'=> '',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'categoria' => 'Accesorios',
                'imagen' => 'uploads/categorias/bolsos.jpg',
                'url_externo'=> 'https://www.canva.com/design/DAFbIXLhnII/nfXCH_JwH4z6dMiOSSPJQQ/view?website#2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 7,
                'categoria' => 'Tendencias',
                'imagen' => '',
                'url_externo'=> '',
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
        DB::table('categorias_articulos')->whereIn('id', [1, 2, 3,4,5,6,7])->delete();
    }
};
