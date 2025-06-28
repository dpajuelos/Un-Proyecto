<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property int $id_usuario
 * @property string $nombre_usuario
 * @property string $contrasena_hash
 * 
 * @property Collection|Trabajadore[] $trabajadores
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuarios';
	protected $primaryKey = 'id_usuario';
	public $timestamps = false;

	protected $fillable = [
		'nombre_usuario',
		'contrasena_hash'
	];

	public function trabajadores()
	{
		return $this->hasMany(Trabajadore::class, 'id_usuario');
	}
}
