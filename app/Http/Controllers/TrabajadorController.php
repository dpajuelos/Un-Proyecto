<?php

namespace App\Http\Controllers;

use App\Models\VistaTrabajadoresDetalle;
use App\Models\Trabajador;
use App\Models\Trabajadore;
use App\Models\Cargo;
use App\Models\Especializacion;

// o usar DB si no creaste el modelo
// use Illuminate\Support\Facades\DB;

class TrabajadorController extends Controller
{
    public function index()
    {
        $trabajadores = VistaTrabajadoresDetalle::orderBy('apellidos')->paginate(10);
        $cargos = Cargo::all();
        $especializaciones = Especializacion::all();
        return view('trabajadores.index', compact('trabajadores', 'cargos', 'especializaciones'));
    }

    public function filtrarPorCargo($cargo)
    {
        $trabajadores = VistaTrabajadoresDetalle::where('nombre_cargo', $cargo)
            ->orderBy('apellidos')
            ->get();
            
        return view('trabajadores.filtrados', compact('trabajadores', 'cargo'));
    }

    public function show($id_trabajador)
    {
        $trabajador = VistaTrabajadoresDetalle::findOrFail($id_trabajador);
        return view('trabajadores.show', compact('trabajador'));
    }

    public function create()
    {
        return view('trabajadores.create');
    }

    public function ejemplo()
    {
        $trabajadores = Trabajadore::with(['usuario', 'cargo', 'especializacion'])->get();
        
        return view('trabajadores.ejemplo', compact('trabajadores'));
    }
}