<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $sub_categoria
 * @property string|null $imagen
 * @property int $id_categoria
 * @property string|null $descripcion
 * @property string|null $url_externo
 * @property string|null $url_interno
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Categoria $categoria
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria whereIdCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria whereImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria whereSubCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria whereUrlExterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria whereUrlInterno($value)
 * @property string $estado_registro
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategoria whereEstadoRegistro($value)
 * @mixin \Eloquent
 */
class SubCategoria extends Model
{
    use HasFactory;

    protected $table = 'sub_categorias_articulos';

    protected $fillable = [
        'sub_categoria' .
        'imagen',
        'id_categoria',
        'descripcion',
        'url_externo',
        'url_interno'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

}
