<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Persona
 * 
 * @property string $dni
 * @property string $nombres
 * @property string $apellidos
 * @property string|null $telefono
 * @property string|null $correo
 * 
 * @property Collection|Representante[] $representantes
 * @property Collection|Trabajadore[] $trabajadores
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'personas';
	protected $primaryKey = 'dni';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'nombres',
		'apellidos',
		'telefono',
		'correo'
	];

	public function representantes()
	{
		return $this->hasMany(Representante::class, 'dni');
	}

	public function trabajadores()
	{
		return $this->hasMany(Trabajadore::class, 'dni');
	}
}
