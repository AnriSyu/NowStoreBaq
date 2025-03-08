<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $id_pedido
 * @property string|null $monto_pagado_parcial
 * @property string|null $monto_pagado_total
 * @property string|null $fecha_pago_parcial
 * @property string|null $fecha_pago_total
 * @property string $metodo_pago
 * @property string $estado_pago
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pedido $pedido
 * @method static \Illuminate\Database\Eloquent\Builder|Pago newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pago newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pago query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereEstadoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereFechaPagoParcial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereFechaPagoTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereIdPedido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereMetodoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereMontoPagadoParcial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereMontoPagadoTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pago whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'id_pedido',
        'monto_pagado_parcial',
        'monto_pagado_total',
        'fecha_pago_parcial',
        'fecha_pago_total',
        'metodo_pago',
        'estado_pago',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    public static function colorPago($estado): string
    {
        $color = '';
        switch ($estado) {
            case 'pendiente':
                $color = 'bg-warning text-white';
                break;
            case 'parcial':
                $color = 'bg-info text-white';
                break;
            case 'completo':
                $color = 'bg-success text-white';
                break;
            case 'cancelado':
                $color = 'danger';
                break;
        }
        return $color;
    }

}
