<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $nombres
 * @property string $apellidos
 * @property string $celular
 * @property string $codigo_postal
 * @property string $direccion
 * @property string|null $referencias
 * @property int $id_usuario
 * @property int $id_departamento
 * @property int $id_ciudad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Persona newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona query()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereApellidos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereCelular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereCodigoPostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereIdCiudad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereIdDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereIdUsuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereNombres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereReferencias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereUpdatedAt($value)
 * @property int $id_municipio
 * @property-read \App\Models\Departamento $departamento
 * @property-read \App\Models\Municipio $municipio
 * @property-read \App\Models\Usuario $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereIdMunicipio($value)
 * @mixin \Eloquent
 */
class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'nombres',
        'apellidos',
        'celular',
        'codigo_postal',
        'direccion',
        'referencias',
        'id_usuario',
        'id_departamento',
        'id_ciudad'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

}
