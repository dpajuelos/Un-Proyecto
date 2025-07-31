<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TrabajadorTurno
 *
 * @property int $id_trabajador
 * @property int $id_turno
 *
 * @property Trabajadore $trabajadore
 * @property Turno $turno
 *
 * @package App\Models
 */
class TrabajadorTurno extends Model
{
	protected $table = 'trabajador_turno';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'id_trabajador',
		'id_turno'
	];

	protected $casts = [
		'id_trabajador' => 'int',
		'id_turno' => 'int'
	];

	public function trabajadore()
	{
		return $this->belongsTo(Trabajadore::class, 'id_trabajador');
	}

	public function turno()
	{
		return $this->belongsTo(Turno::class, 'id_turno');
	}
}
