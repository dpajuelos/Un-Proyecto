<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cita
 *
 * @property int $id_cita
 * @property int $id_rep
 * @property int|null $id_rep_sus
 * @property Carbon $fecha
 * @property Carbon $hora
 * @property Carbon|null $fecha_nue
 * @property Carbon|null $hora_nue
 * @property string|null $estado
 *
 * @property Representante|null $representante
 *
 * @package App\Models
 */
class Cita extends Model
{
	protected $table = 'citas';
	protected $primaryKey = 'id_cita';
	public $timestamps = false;

	protected $casts = [
		'id_rep' => 'int',
		'id_rep_sus' => 'int',
		'fecha' => 'datetime',
		'hora' => 'datetime',
		'fecha_nue' => 'datetime',
		'hora_nue' => 'datetime',
	];

	protected $fillable = [
		'id_rep',
		'id_rep_sus',
		'fecha',
		'hora',
		'fecha_nue',
		'hora_nue',
		'estado',
		'descripcion'
	];

	public function representantePrincipal()
	{
		return $this->belongsTo(Representante::class, 'id_rep');
	}

	public function representanteSustituto()
	{
		return $this->belongsTo(Representante::class, 'id_rep_sus');
	}
}
