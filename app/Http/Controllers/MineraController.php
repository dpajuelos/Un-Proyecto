<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Minera;

class MineraController extends Controller
{
   // MineraController.php
public function index()
{
    $mineras = DB::table('mineras')->get(); // O usa tu modelo si tienes uno
    return view('mineras.index', compact('mineras'));
} //
public function edit($id)
{
    $minera = Minera::findOrFail($id);
    return view('mineras.edit', compact('minera'));
}
public function update(Request $request, $id)
{
    $minera = Minera::findOrFail($id);
    $minera->nombre_minera = $request->nombre_minera;
    $minera->ruc = $request->ruc;
    $minera->direccion = $request->direccion;
    // Agrega validaciones si es necesario

    if ($minera->save()) {
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false], 500);
    }
}
public function store(Request $request)
{
    $request->validate([
        'nombre_minera' => 'required|string|max:255',
        'ruc' => 'required|string|max:20',
        'direccion' => 'required|string|max:255',
        'telefono_contacto' => 'required|string|max:20',
        'correo_contacto' => 'required|email|max:255',
    ]);

    Minera::create($request->all());

    return redirect()->route('mineras.index')->with('success', 'Minera creada correctamente.');
}
public function destroy($id)
{
    $minera = Minera::findOrFail($id);
    $minera->delete();

    return redirect()->route('mineras.index')->with('success', 'Minera eliminada correctamente.');
}
}

