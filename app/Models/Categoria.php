<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Eloquent;

/**
 * Categoria
 *
 * @property int $id
 * @property string $categoria
 * @property string|null $imagen
 * @property string|null $descripcion
 * @property string|null $url_externo
 * @property string|null $url_interno
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubCategoria> $subCategorias
 * @property-read int|null $sub_categorias_count
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereUrlExterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereUrlInterno($value)
 * @mixin Eloquent
 */
class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias_articulos';

    protected $fillable = [
        'categoria' ,
        'imagen',
        'descripcion',
        'url_externo',
        'url_interno'
    ];

    public function subCategorias()
    {
        return $this->hasMany(SubCategoria::class, 'id_categoria');
    }

}
