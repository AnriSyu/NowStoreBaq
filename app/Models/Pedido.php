<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
 * @property string|null $url_pedido
 * @property string $total
 * @property string $descuento
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereDescuento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereUrlPedido($value)
 * @property string $mitad_total
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereMitadTotal($value)
 * @property string|null $fecha_cancelado
 * @property-read \App\Models\Departamento|null $departamento
 * @property-read \App\Models\Municipio|null $municipio
 * @property-read \App\Models\Persona|null $persona
 * @method static \Illuminate\Database\Eloquent\Builder|Pedido whereFechaCancelado($value)
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
        'fecha_cancelado',
        'estado_pedido',
        'carrito',
        'observacion',
        'estado_registro',
        'total',
        'mitad_total',
        'descuento',
        'url_pedido',
        'id_departamento',
        'id_municipio',
    ];

    public static function ObtenerFechaYColor(mixed $pedido)
    {
        $fecha = 'Sin fecha';
        $color = 'bg-warning';
        $estado = $pedido->estado_pedido;
        if ($pedido->fecha_entregado):
            $color = 'bg-success';
            $fecha = Carbon::parse($pedido->fecha_entregado)->format('Y-m-d');
        elseif ($pedido->fecha_cancelado):
            $color = 'bg-danger';
            $fecha = Carbon::parse($pedido->fecha_cancelado)->format('Y-m-d');
        endif;
        return ['color' => $color, 'fecha' => $fecha, 'estado' => $estado];
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function persona()
    {
        return $this->hasOneThrough(Persona::class, Usuario::class, 'id', 'id_usuario', 'id_usuario', 'id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio');
    }

    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class, 'id_pedido');
    }

    public static function getCarritoAttribute($value)
    {
        return json_decode($value);
    }

    public static function colorEstado($estado) {
        $color = '';
        switch ($estado) {
            case 'a pagar':
                $color = 'bg-info text-white';
                break;
            case 'pendiente':
                $color = 'bg-warning text-white';
                break;
            case 'en envio':
                $color = 'bg-primary text-white';
                break;
            case 'entregado':
                $color = 'bg-success text-white';
                break;
            case 'cancelado':
                $color = 'bg-danger text-white';
                break;
            default:
                $color = 'bg-secondary text-white';
                break;
        }
        return $color;
    }

    public static function formatearTotal($total) {
        return number_format($total, 2, '.', ',');
    }

    public static function formatearFecha($fecha) {
        if(!$fecha) {
            return '';
        }
        return Carbon::parse($fecha)->format('d-m-Y H:i:s');
    }

}
