<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialConsulta extends Model
{
    protected $fillable = [
        'user_id',
        'tipo_consulta',
        'detalle',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'detalle' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con usuarios (si tienes tabla users)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
