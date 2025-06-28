<?php

namespace App\Http\Controllers;

use App\Models\HistorialConsulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    protected $fillable = ['user_id', 'tipo_consulta', 'detalle'];

    public function solicitarConsulta(Request $request)
    {
        // Lógica de la consulta...

        HistorialConsulta::create([
            'user_id' => Auth::id(),
            'tipo_consulta' => 'Consulta Minera Virtual',
            'detalle' => 'El usuario solicitó una consulta virtual.',
        ]);

        // ...resto del código...
    }
}

class HistorialController extends Controller
{
    public function index()
    {
        $historial = HistorialConsulta::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('historial.index', compact('historial'));
    }
}

\App\Models\HistorialConsulta::create([
    'user_id' => 1, // Cambia por el ID de tu usuario
    'tipo_consulta' => 'Prueba',
    'detalle' => 'Esto es una prueba'
]);