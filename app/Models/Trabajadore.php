<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Trabajadore
 *
 * @property int $id_trabajador
 * @property string $dni
 * @property int $id_usuario
 * @property int $id_cargo
 * @property int $id_espe
 *
 * @property Persona $persona
 * @property Usuario $usuario
 * @property Cargo $cargo
 * @property Especializacion $especializacion
 * @property Collection|TrabajadorTurno[] $trabajador_turnos
 *
 * @package App\Models
 */
class Trabajadore extends Model
{
	protected $table = 'trabajadores';
	protected $primaryKey = 'id_trabajador';
	public $timestamps = false;

	protected $casts = [
		'id_usuario' => 'int',
		'id_cargo' => 'int',
		'id_espe' => 'int'
	];

	protected $fillable = [
		'dni',
		'id_usuario',
		'id_cargo',
		'id_espe'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'dni', 'dni');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
	}

	public function cargo()
	{
		return $this->belongsTo(Cargo::class, 'id_cargo', 'id_cargo');
	}

	public function especializacion()
	{
		return $this->belongsTo(Especializacion::class, 'id_espe', 'id_espe');
	}

	public function trabajador_turnos()
	{
		return $this->hasMany(TrabajadorTurno::class, 'id_trabajador');
	}
}
