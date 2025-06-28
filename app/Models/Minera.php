<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Minera
 * 
 * @property int $id_minera
 * @property string $nombre_minera
 * @property string $ruc
 * @property string|null $direccion
 * @property string|null $telefono_contacto
 * @property string|null $correo_contacto
 * 
 * @property Collection|Representante[] $representantes
 *
 * @package App\Models
 */
class Minera extends Model
{
	protected $table = 'mineras';
	protected $primaryKey = 'id_minera';
	public $timestamps = false;

	protected $fillable = [
		'nombre_minera',
		'ruc',
		'direccion',
		'telefono_contacto',
		'correo_contacto'
	];

	public function representantes()
	{
		return $this->hasMany(Representante::class, 'id_minera');
	}
}
