<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    use HasFactory;

    protected $table = 'sub_categorias_articulos';

    protected $fillable = [
        'sub_categoria' .
        'imagen',
        'id_categoria',
        'descripcion',
        'url_externo'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

}
