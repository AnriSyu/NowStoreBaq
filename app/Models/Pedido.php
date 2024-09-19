<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $id_usuario
 * @property string $fecha_ingreso
 * @property string|null $fecha_entregado
 * @property string $estado_pedido
 * @property string $carrito
 * @property string|null $observacion
 * @property string $estado_registro
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Usuario $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereCarrito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereEstadoPedido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereEstadoRegistro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereFechaEntregado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereIdUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'id_usuario',
        'fecha_ingreso',
        'fecha_entregado',
        'estado_pedido',
        'carrito',
        'observacion',
        'estado_registro'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

}
