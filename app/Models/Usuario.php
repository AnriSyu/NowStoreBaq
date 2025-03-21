<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * 
 *
 * @property int $id
 * @property string $correo
 * @property string $clave
 * @property string|null $token_verificacion
 * @property bool $esta_verificado
 * @property \Illuminate\Support\Carbon|null $fecha_verificacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $fecha_expiracion_verificacion
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario query()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereClave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereEstaVerificado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereFechaExpiracionVerificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereFechaVerificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereTokenVerificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereUpdatedAt($value)
 * @property int|null $id_rol
 * @property string|null $token_cambio_clave
 * @property string|null $fecha_expiracion_cambio_clave
 * @property string|null $fecha_ultimo_cambio_clave
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereFechaExpiracionCambioClave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereFechaUltimoCambioClave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereIdRol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereTokenCambioClave($value)
 * @property string $estado_registro
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereEstadoRegistro($value)
 * @property-read \App\Models\Rol|null $rol
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pedido> $pedidos
 * @property-read int|null $pedidos_count
 * @property-read \App\Models\Persona|null $persona
 * @mixin \Eloquent
 */
class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'correo',
        'id_rol',
        'clave',
        'token_verificacion',
        'esta_verificado',
        'fecha_verificacion',
        'fecha_expiracion_verificacion',
        'id_persona'
    ];

    protected $hidden = [
        'clave',
        'token_verificacion',
    ];

    protected $casts = [
        'esta_verificado' => 'boolean',
        'fecha_verificacion' => 'datetime',
        'fecha_expiracion_verificacion' => 'datetime',
    ];

    public function persona()
    {
        return $this->hasOne(Persona::class, 'id_usuario');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_usuario');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function tieneRol($rol)
    {
        return $this->rol->rol == $rol;
    }

}
