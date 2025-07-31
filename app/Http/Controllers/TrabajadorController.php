<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Especializacion;
use App\Models\Persona;
use App\Models\Trabajador;
use App\Models\Trabajadore;
use App\Models\TrabajadorTurno;
use App\Models\Turno;
use App\Models\Usuario;
use App\Models\VistaTrabajadoresDetalle;
use Illuminate\Http\Request;

// o usar DB si no creaste el modelo
// use Illuminate\Support\Facades\DB;

class TrabajadorController extends Controller
{
    public function index()
    {
        $trabajadores = Trabajadore::with([
            'persona',
            'usuario',
            'cargo',
            'especializacion',
            'trabajador_turnos.turno'
        ])->get();

        return view('trabajadores.index', compact('trabajadores'));
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
        $cargos = Cargo::all();
        $especializaciones = Especializacion::all();
        $turnos = Turno::all();
        $usuarios = Usuario::all();

        return view('trabajadores.create', compact('cargos', 'especializaciones', 'turnos', 'usuarios'));
    }

    public function edit($id)
    {
        $trabajador = Trabajadore::with([
            'persona',
            'usuario',
            'cargo',
            'especializacion',
            'trabajador_turnos'
        ])->findOrFail($id);

        $cargos = Cargo::all();
        $especializaciones = Especializacion::all();
        $turnos = Turno::all();

        return view('trabajadores.edit', compact('trabajador', 'cargos', 'especializaciones', 'turnos'));
    }

    public function ejemplo()
    {
        $trabajadores = Trabajadore::with(['usuario', 'cargo', 'especializacion'])->get();

        return view('trabajadores.ejemplo', compact('trabajadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Datos de la persona
            'dni' => 'required|string|max:20|unique:personas,dni|unique:trabajadores,dni',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            // Datos del usuario
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario',
            'contrasena' => 'required|string|min:6|confirmed',
            'contrasena_confirmation' => 'required|string|min:6',
            // Datos del trabajador
            'id_cargo' => 'required|exists:cargo,id_cargo',
            'id_espe' => 'required|exists:especializacion,id_espe',
            // Turnos opcionales
            'turnos' => 'nullable|array',
            'turnos.*' => 'exists:turnos,id_turno'
        ]);

        try {
            // 1. Crear la persona primero
            $persona = Persona::create([
                'dni' => $request->dni,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
            ]);

            // 2. Crear el usuario
            $usuario = Usuario::create([
                'nombre_usuario' => $request->nombre_usuario,
                'contrasena_hash' => bcrypt($request->contrasena),  // Cambiar aquí
            ]);

            // 3. Crear el trabajador
            $trabajador = Trabajadore::create([
                'dni' => $persona->dni,
                'id_usuario' => $usuario->id_usuario,
                'id_cargo' => $request->id_cargo,
                'id_espe' => $request->id_espe,
            ]);

            // 4. Asignar turnos si se seleccionaron
            if ($request->has('turnos') && !empty($request->turnos)) {
                foreach ($request->turnos as $turnoId) {
                    TrabajadorTurno::create([
                        'id_trabajador' => $trabajador->id_trabajador,
                        'id_turno' => $turnoId
                    ]);
                }
            }

            return redirect()
                ->route('trabajadores.index')
                ->with('success', 'Trabajador, persona y usuario creados exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el trabajador: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $trabajador = Trabajadore::with(['persona', 'usuario'])->findOrFail($id);

        $request->validate([
            // Excluir el DNI actual del trabajador en ambas tablas
            'dni' => 'required|string|max:20|unique:personas,dni,' . $trabajador->persona->dni . ',dni|unique:trabajadores,dni,' . $trabajador->dni . ',dni',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario,' . $trabajador->usuario->id_usuario . ',id_usuario',
            'contrasena' => 'nullable|string|min:6|confirmed',
            'contrasena_confirmation' => 'nullable|string|min:6',
            'id_cargo' => 'required|exists:cargo,id_cargo',
            'id_espe' => 'required|exists:especializacion,id_espe',
            'turnos' => 'nullable|array',
            'turnos.*' => 'exists:turnos,id_turno'
        ]);

        try {
            // Actualizar persona
            $trabajador->persona->update([
                'dni' => $request->dni,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
            ]);

            // Actualizar usuario
            $updateUsuario = [
                'nombre_usuario' => $request->nombre_usuario,
            ];

            // Solo actualizar contraseña si se proporcionó una nueva
            if ($request->filled('contrasena')) {
                $updateUsuario['contrasena_hash'] = bcrypt($request->contrasena);
            }

            $trabajador->usuario->update($updateUsuario);

            // Actualizar trabajador
            $trabajador->update([
                'dni' => $request->dni,  // También actualizar el DNI en la tabla trabajadores
                'id_cargo' => $request->id_cargo,
                'id_espe' => $request->id_espe,
            ]);

            // Actualizar turnos
            TrabajadorTurno::where('id_trabajador', $trabajador->id_trabajador)->delete();

            if ($request->has('turnos') && !empty($request->turnos)) {
                foreach ($request->turnos as $turnoId) {
                    TrabajadorTurno::create([
                        'id_trabajador' => $trabajador->id_trabajador,
                        'id_turno' => $turnoId
                    ]);
                }
            }

            return redirect()
                ->route('trabajadores.index')
                ->with('success', 'Trabajador actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el trabajador: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $trabajador = Trabajadore::with(['persona', 'usuario'])->findOrFail($id);

            // Guardar referencias antes de eliminar
            $persona = $trabajador->persona;
            $usuario = $trabajador->usuario;

            // 1. Eliminar relaciones trabajador_turno
            TrabajadorTurno::where('id_trabajador', $trabajador->id_trabajador)->delete();

            // 2. Eliminar trabajador
            $trabajador->delete();

            // 3. Eliminar usuario si existe
            if ($usuario) {
                $usuario->delete();
            }

            // 4. Eliminar persona si existe
            if ($persona) {
                $persona->delete();
            }

            return redirect()
                ->route('trabajadores.index')
                ->with('success', 'Trabajador, usuario y persona eliminados exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el trabajador: ' . $e->getMessage());
        }
    }
}
