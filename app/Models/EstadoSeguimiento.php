<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EstadoSeguimiento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstadoSeguimiento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstadoSeguimiento query()
 * @method static \Illuminate\Database\Eloquent\Builder|EstadoSeguimiento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstadoSeguimiento whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstadoSeguimiento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstadoSeguimiento whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstadoSeguimiento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EstadoSeguimiento extends Model
{
    use HasFactory;

    protected $table = 'estado_seguimiento';

    protected $fillable = ['nombre', 'descripcion'];

    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class, 'id_estado');
    }

}
