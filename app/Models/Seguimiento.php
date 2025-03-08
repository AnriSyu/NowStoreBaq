<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $id_pedido
 * @property int $id_estado
 * @property string $mensaje
 * @property string $fecha_actualizacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EstadoSeguimiento $estado
 * @method static \Illuminate\Database\Eloquent\Builder|Seguimiento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seguimiento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seguimiento query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seguimiento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seguimiento whereFechaActualizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seguimiento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seguimiento whereIdEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seguimiento whereIdPedido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seguimiento whereMensaje($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seguimiento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Seguimiento extends Model
{
    use HasFactory;


    protected $table = 'seguimientos';

    protected $fillable = ['id_pedido', 'id_estado', 'mensaje', 'fecha_actualizacion'];

    public $timestamps = true;

    public function estado()
    {
        return $this->belongsTo(EstadoSeguimiento::class, 'id_estado');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}
