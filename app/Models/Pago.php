<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
