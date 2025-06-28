<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Turno
 * 
 * @property int $id_turno
 * @property string $descripcion
 * @property Carbon $hora_inicio
 * @property Carbon $hora_fin
 * @property string|null $tiem_aten
 * 
 * @property Collection|TrabajadorTurno[] $trabajador_turnos
 *
 * @package App\Models
 */
class Turno extends Model
{
	protected $table = 'turnos';
	protected $primaryKey = 'id_turno';
	public $timestamps = false;

	protected $casts = [
		'hora_inicio' => 'datetime',
		'hora_fin' => 'datetime'
	];

	protected $fillable = [
		'descripcion',
		'hora_inicio',
		'hora_fin',
		'tiem_aten'
	];

	public function trabajador_turnos()
	{
		return $this->hasMany(TrabajadorTurno::class, 'id_turno');
	}
}
