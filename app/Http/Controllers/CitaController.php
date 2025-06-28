<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Models\Persona; 
use App\Models\Representante;

class CitaController extends Controller
{
    public function index()
    {
         $citas = Cita::with(['representantePrincipal.persona', 'representanteSustituto.persona'])
                    ->orderBy('fecha', 'desc')
                    ->paginate(10);
        
        $representantes = Representante::with('persona')->get();
        
        return view('citas.index', compact('citas', 'representantes'));
    }

    public function create()
    {
        $representantes = \App\Models\Representante::all(); // Ajusta el modelo si es necesario
        return view('citas.create', compact('representantes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rep' => 'required|integer',
            'id_rep_sus' => 'nullable|integer',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'estado' => 'required|in:pendiente,confirmada,cancelada,reprogramada'
        ]);

        Cita::create($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita creada exitosamente.');
    }

    public function show(Request $request)
    {
        $id = $request->input('buscar');
        $cita = Cita::findOrFail($id);
        return view('citas.show', compact('cita'));
    }

    public function edit($id)
    {
        $cita = Cita::findOrFail($id);
        return view('citas.edit', compact('cita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_rep' => 'required|integer',
            'id_rep_sus' => 'nullable|integer',
            'fecha' => 'required|date',
            'hora' => 'required',
            'fecha_nue' => 'nullable|date',
            'hora_nue' => 'nullable',
            'estado' => 'required|in:pendiente,confirmada,cancelada,reprogramada',
            'nombre_rep' => 'required|string',
            'apellido_rep' => 'required|string',
            'dni_rep' => 'required|string',
            'nombre_sus' => 'nullable|string',
            'apellido_sus' => 'nullable|string',
            'dni_sus' => 'nullable|string',
        ]);

        $cita = Cita::findOrFail($id);
        $cita->update($request->only(['id_rep', 'id_rep_sus', 'fecha', 'hora', 'fecha_nue', 'hora_nue', 'estado']));

        // Actualizar datos del representante principal
        if ($cita->representantePrincipal && $cita->representantePrincipal->persona) {
            $cita->representantePrincipal->persona->nombres = $request->nombre_rep;
            $cita->representantePrincipal->persona->apellidos = $request->apellido_rep;
            $cita->representantePrincipal->persona->dni = $request->dni_rep;
            $cita->representantePrincipal->persona->save();
        }

        // Actualizar datos del sustituto si existe
        if ($request->id_rep_sus && $cita->representanteSustituto && $cita->representanteSustituto->persona) {
            $cita->representanteSustituto->persona->nombres = $request->nombre_sus;
            $cita->representanteSustituto->persona->apellidos = $request->apellido_sus;
            $cita->representanteSustituto->persona->dni = $request->dni_sus;
            $cita->representanteSustituto->persona->save();
        }

        return redirect()->route('citas.index')->with('success', 'Cita actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return redirect()->route('citas.index')->with('success', 'Cita eliminada exitosamente.');
    }
}