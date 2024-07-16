<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias_articulos';

    protected $fillable = [
        'categoria' ,
        'imagen',
        'descripcion',
        'url_externo'
    ];

    public function subCategorias()
    {
        return $this->hasMany(SubCategoria::class, 'id_categoria');
    }

}
