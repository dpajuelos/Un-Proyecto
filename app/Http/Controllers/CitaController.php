<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Persona;
use App\Models\Representante;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with(['representantePrincipal.persona', 'representantePrincipal.minera', 'representanteSustituto.persona'])
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        $representantes = Representante::with('persona')->get();

        return view('citas.index', compact('citas', 'representantes'));
    }

    public function create()
    {
        $representantes = Representante::with('persona')->get();
        return view('citas.create', compact('representantes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rep' => 'required|integer|exists:representantes,id_rep',
            'id_rep_sus' => 'nullable|integer|exists:representantes,id_rep',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'estado' => 'required|in:pendiente,confirmada,cancelada,reprogramada',
            'descripcion' => 'nullable|string|max:1000'
        ]);

        Cita::create([
            'id_rep' => $request->id_rep,
            'id_rep_sus' => $request->id_rep_sus,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => $request->estado,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita creada exitosamente.');
    }

    public function show(Request $request)
    {
        $id = $request->input('buscar');
        $cita = Cita::with(['representantePrincipal.persona', 'representantePrincipal.minera', 'representanteSustituto.persona'])
            ->findOrFail($id);
        return view('citas.show', compact('cita'));
    }

    public function edit($id)
    {
        $cita = Cita::with(['representantePrincipal.persona', 'representanteSustituto.persona'])
            ->findOrFail($id);
        return view('citas.edit', compact('cita'));
    }

    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);

        $request->validate([
            'id_rep' => 'required|integer|exists:representantes,id_rep',
            'id_rep_sus' => 'nullable|integer|exists:representantes,id_rep',
            'fecha' => 'required|date',
            'hora' => 'required',
            'fecha_nue' => 'nullable|date|after:fecha',
            'hora_nue' => 'nullable',
            'estado' => 'required|in:pendiente,confirmada,cancelada,reprogramada',
            'descripcion' => 'nullable|string|max:1000',
            'nombre_rep' => 'required|string',
            'apellido_rep' => 'required|string',
            'dni_rep' => 'required|string',
            'nombre_sus' => 'nullable|string',
            'apellido_sus' => 'nullable|string',
            'dni_sus' => 'nullable|string',
        ]);

        // Si se estableció una nueva fecha pero no nueva hora, o viceversa
        if (($request->fecha_nue && !$request->hora_nue) || (!$request->fecha_nue && $request->hora_nue)) {
            return redirect()->back()->withErrors([
                'fecha_nue' => 'Si reprograma la cita, debe especificar tanto la nueva fecha como la nueva hora.'
            ])->withInput();
        }

        // Si se reprograma, cambiar automáticamente el estado a reprogramada
        $estado = $request->estado;
        if ($request->fecha_nue && $request->hora_nue) {
            $estado = 'reprogramada';
        }

        // Actualizar solo los campos editables (NO las fechas/horas originales)
        $cita->update([
            'id_rep' => $request->id_rep,
            'id_rep_sus' => $request->id_rep_sus,
            'fecha_nue' => $request->fecha_nue,
            'hora_nue' => $request->hora_nue,
            'estado' => $estado,
            'descripcion' => $request->descripcion
        ]);

        // Actualizar datos del representante principal
        if ($cita->representantePrincipal && $cita->representantePrincipal->persona) {
            $cita->representantePrincipal->persona->update([
                'nombres' => $request->nombre_rep,
                'apellidos' => $request->apellido_rep,
                'dni' => $request->dni_rep
            ]);
        }

        // Actualizar datos del sustituto si existe
        if ($request->id_rep_sus && $cita->representanteSustituto && $cita->representanteSustituto->persona) {
            $cita->representanteSustituto->persona->update([
                'nombres' => $request->nombre_sus,
                'apellidos' => $request->apellido_sus,
                'dni' => $request->dni_sus
            ]);
        }

        $mensaje = $request->fecha_nue
            ? 'Cita reprogramada exitosamente.'
            : 'Cita actualizada exitosamente.';

        return redirect()->route('citas.index')->with('success', $mensaje);
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return redirect()->route('citas.index')->with('success', 'Cita eliminada exitosamente.');
    }
}
