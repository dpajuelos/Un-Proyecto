<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Especializacion
 * 
 * @property int $id_espe
 * @property string $especializacion
 * 
 * @property Collection|Trabajadore[] $trabajadores
 *
 * @package App\Models
 */
class Especializacion extends Model
{
	protected $table = 'especializacion';
	protected $primaryKey = 'id_espe';
	public $timestamps = false;

	protected $fillable = [
		'especializacion'
	];

	public function trabajadores()
	{
		return $this->hasMany(Trabajadore::class, 'id_espe');
	}
}
