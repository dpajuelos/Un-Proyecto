<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VistaTrabajadoresDetalle extends Model
{
    protected $table = 'vista_trabajadores_detalle';
    
    protected $primaryKey = 'id_trabajador'; // Clave primaria de la tabla
    
    // Si la vista no tiene una columna 'id' como clave primaria
    public $incrementing = false;
    
    // Deshabilitar timestamps si no existen en la vista
    public $timestamps = false;
    
    // Definir campos asignables masivamente si es necesario
    protected $fillable = [
        'id_trabajador',
        'dni',
        'nombres',
        'apellidos',
        'telefono',
        'correo',
        'nombre_usuario',
        'nombre_cargo',
        'especializacion'
    ];
}