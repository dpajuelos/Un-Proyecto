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
        $query = Cita::with(['representantePrincipal.persona', 'representantePrincipal.minera', 'representanteSustituto.persona']);

        // Filtros
        if (request('estado')) {
            $query->where('estado', request('estado'));
        }

        if (request('fecha')) {
            $query->whereDate('fecha', request('fecha'));
        }

        if (request('buscar')) {
            $buscar = request('buscar');
            $query->where(function ($q) use ($buscar) {
                $q
                    ->where('id_rep', 'LIKE', "%{$buscar}%")
                    ->orWhere('id_rep_sus', 'LIKE', "%{$buscar}%");
            });
        }

        $citas = $query->orderBy('fecha', 'desc')->paginate(10);
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
        $validationRules = [
            'id_rep' => 'required|integer|exists:representantes,id_rep',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'estado' => 'required|in:pendiente,confirmada,cancelada,reprogramada',
            'descripcion' => 'nullable|string|max:1000'
        ];

        // Si se marca el checkbox del sustituto, validar sus campos
        if ($request->has('tiene_sustituto') && $request->tiene_sustituto) {
            $validationRules = array_merge($validationRules, [
                'nombre_sus' => 'required|string|max:255',
                'apellido_sus' => 'required|string|max:255',
                'dni_sus' => 'required|string|max:20',
                'cargo_sus' => 'required|string|max:255',
                'telefono_sus' => 'nullable|string|max:20',
                'correo_sus' => 'nullable|email|max:255',
            ]);
        }

        $request->validate($validationRules);

        $id_rep_sus = null;

        // Si tiene sustituto, crear o actualizar persona y representante
        if ($request->has('tiene_sustituto') && $request->tiene_sustituto) {
            $id_rep_sus = $this->crearOActualizarRepresentanteSustituto($request, $request->id_rep);
        }

        Cita::create([
            'id_rep' => $request->id_rep,
            'id_rep_sus' => $id_rep_sus,
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

        $validationRules = [
            'nombre_rep' => 'required|string|max:255',
            'apellido_rep' => 'required|string|max:255',
            'dni_rep' => 'required|string|max:20',
            'cargo_rep' => 'required|string|max:255',
            'fecha_nue' => 'nullable|date',
            'hora_nue' => 'nullable',
            'estado' => 'required|in:pendiente,confirmada,cancelada,reprogramada',
            'descripcion' => 'nullable|string|max:1000',
        ];

        // Si se marca el checkbox del sustituto, validar sus campos
        if ($request->has('tiene_sustituto') && $request->tiene_sustituto) {
            $validationRules = array_merge($validationRules, [
                'nombre_sus' => 'required|string|max:255',
                'apellido_sus' => 'required|string|max:255',
                'dni_sus' => 'required|string|max:20',
                'cargo_sus' => 'required|string|max:255',
                'telefono_sus' => 'nullable|string|max:20',
                'correo_sus' => 'nullable|email|max:255',
            ]);
        }

        $request->validate($validationRules);

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

        // Actualizar datos del representante principal
        $this->actualizarRepresentantePrincipal($cita, $request);

        // Manejar representante sustituto
        $id_rep_sus = null;
        if ($request->has('tiene_sustituto') && $request->tiene_sustituto) {
            $id_rep_sus = $this->crearOActualizarRepresentanteSustituto($request, $cita->id_rep, $cita->id_rep_sus);
        }

        // Actualizar la cita
        $cita->update([
            'id_rep_sus' => $id_rep_sus,
            'fecha_nue' => $request->fecha_nue,
            'hora_nue' => $request->hora_nue,
            'estado' => $estado,
            'descripcion' => $request->descripcion
        ]);

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

    /**
     * Actualizar representante principal
     */
    private function actualizarRepresentantePrincipal($cita, $request)
    {
        // Buscar si existe una persona con el DNI proporcionado
        $persona = Persona::where('dni', $request->dni_rep)->first();

        if ($persona) {
            // Si existe, actualizar sus datos
            $persona->update([
                'nombres' => $request->nombre_rep,
                'apellidos' => $request->apellido_rep,
                'telefono' => $request->telefono_rep ?? $persona->telefono,
                'correo' => $request->correo_rep ?? $persona->correo
            ]);
        } else {
            // Si no existe, crear nueva persona
            $persona = Persona::create([
                'dni' => $request->dni_rep,
                'nombres' => $request->nombre_rep,
                'apellidos' => $request->apellido_rep,
                'telefono' => $request->telefono_rep,
                'correo' => $request->correo_rep
            ]);
        }

        // Actualizar el representante para que use la persona correcta
        if ($cita->representantePrincipal) {
            $cita->representantePrincipal->update([
                'dni' => $request->dni_rep,
                'cargo' => $request->cargo_rep
            ]);
        }
    }

    /**
     * Crear o actualizar representante sustituto
     */
    private function crearOActualizarRepresentanteSustituto($request, $id_rep_principal, $id_rep_sus_actual = null)
    {
        // Buscar si existe una persona con el DNI proporcionado
        $persona = Persona::where('dni', $request->dni_sus)->first();

        if ($persona) {
            // Si existe, actualizar sus datos
            $persona->update([
                'nombres' => $request->nombre_sus,
                'apellidos' => $request->apellido_sus,
                'telefono' => $request->telefono_sus ?? $persona->telefono,
                'correo' => $request->correo_sus ?? $persona->correo
            ]);
        } else {
            // Si no existe, crear nueva persona
            $persona = Persona::create([
                'dni' => $request->dni_sus,
                'nombres' => $request->nombre_sus,
                'apellidos' => $request->apellido_sus,
                'telefono' => $request->telefono_sus,
                'correo' => $request->correo_sus
            ]);
        }

        // Buscar si ya existe un representante con este DNI
        $representante = Representante::where('dni', $request->dni_sus)->first();

        if ($representante) {
            // Si existe, actualizar sus datos
            $representante->update([
                'cargo' => $request->cargo_sus
            ]);
            return $representante->id_rep;
        } else {
            // Si no existe, crear nuevo representante
            $repPrincipal = Representante::findOrFail($id_rep_principal);

            $nuevoRepresentante = Representante::create([
                'id_minera' => $repPrincipal->id_minera,
                'dni' => $request->dni_sus,
                'cargo' => $request->cargo_sus
            ]);

            return $nuevoRepresentante->id_rep;
        }
    }
}
