<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cargo
 * 
 * @property int $id_cargo
 * @property string $nombre_cargo
 * 
 * @property Collection|Trabajadore[] $trabajadores
 *
 * @package App\Models
 */
class Cargo extends Model
{
	protected $table = 'cargo';
	protected $primaryKey = 'id_cargo';
	public $timestamps = false;

	protected $fillable = [
		'nombre_cargo'
	];

	public function trabajadores()
	{
		return $this->hasMany(Trabajadore::class, 'id_cargo');
	}
}
