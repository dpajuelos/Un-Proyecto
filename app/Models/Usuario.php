<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre_usuario',
        'contrasena_hash',
    ];

    protected $hidden = [
        'contrasena_hash',
    ];

    public function setContrasenaAttribute($value)
    {
        $this->attributes['contrasena_hash'] = Hash::make($value);
    }

    // Relación con trabajadores
    public function trabajadores()
    {
        return $this->hasMany(Trabajadore::class, 'id_usuario', 'id_usuario');
    }
}
