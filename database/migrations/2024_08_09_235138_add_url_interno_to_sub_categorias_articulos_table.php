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
        Schema::table('sub_categorias_articulos', function (Blueprint $table) {
            $table->string('url_interno')->nullable()->after('url_externo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_categorias_articulos', function (Blueprint $table) {
            $table->dropColumn('url_interno');
        });
    }
};