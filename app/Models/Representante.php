<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Representante
 * 
 * @property int $id_rep
 * @property int $id_minera
 * @property string|null $dni
 * @property string|null $cargo
 * 
 * @property Persona|null $persona
 * @property Minera $minera
 * @property Collection|Cita[] $citas
 *
 * @package App\Models
 */
class Representante extends Model
{
	protected $table = 'representantes';
	protected $primaryKey = 'id_rep';
	public $timestamps = false;

	protected $casts = [
		'id_minera' => 'int'
	];

	protected $fillable = [
		'id_minera',
		'dni',
		'cargo'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'dni');
	}

	public function minera()
	{
		return $this->belongsTo(Minera::class, 'id_minera');
	}

	public function citas()
	{
		return $this->hasMany(Cita::class, 'id_rep_sus');
	}
}
