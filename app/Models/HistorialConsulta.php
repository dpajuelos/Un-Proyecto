<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialConsulta extends Model
{
    protected $fillable = [
        'user_id',
        'tipo_consulta',
        'detalle'
    ];

    protected $casts = [
        'detalle' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
