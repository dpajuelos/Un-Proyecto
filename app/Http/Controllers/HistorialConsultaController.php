<?php

namespace App\Http\Controllers;

use App\Models\HistorialConsulta;
use Illuminate\Http\Request;

class HistorialConsultaController extends Controller
{
    public function index(Request $request)
    {
        // Verificar autenticación personalizada
        if (!session()->has('usuario')) {
            return redirect('/login')->with('error', 'Debe iniciar sesión para ver el historial.');
        }

        // Obtener TODOS los registros sin filtrar por usuario
        $query = HistorialConsulta::orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('tipo_consulta')) {
            $query->where('tipo_consulta', $request->tipo_consulta);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $historial = $query->paginate(15);

        // Obtener todos los tipos de consulta sin filtrar por usuario
        $tiposConsulta = HistorialConsulta::distinct()
            ->pluck('tipo_consulta')
            ->filter();

        if ($tiposConsulta->isEmpty()) {
            $tiposConsulta = collect(['citas', 'personas', 'mineras', 'trabajadores', 'representantes', 'general']);
        }

        // Estadísticas de TODOS los registros
        $estadisticas = [
            'total_registros' => HistorialConsulta::count(),
            'registros_hoy' => HistorialConsulta::whereDate('created_at', today())->count(),
            'registros_semana' => HistorialConsulta::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return view('historial.index', compact('historial', 'tiposConsulta', 'estadisticas'));
    }

    public function show($id)
    {
        try {
            if (!session()->has('usuario')) {
                return response()->json(['error' => 'No autorizado'], 401);
            }

            $usuarioSesion = session('usuario');

            // Buscar el registro sin filtrar por usuario
            $registro = HistorialConsulta::find($id);

            if (!$registro) {
                return response()->json([
                    'success' => false,
                    'error' => 'Registro no encontrado'
                ], 404);
            }

            // Agregar información del usuario desde la sesión
            $registroArray = $registro->toArray();
            $registroArray['user'] = [
                'name' => $usuarioSesion['name'] ?? $usuarioSesion['nombre'] ?? 'N/A',
                'email' => $usuarioSesion['email'] ?? $usuarioSesion['correo'] ?? 'N/A'
            ];

            // Si es una petición AJAX, devolver JSON
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'registro' => $registroArray
                ]);
            }

            // Si no es AJAX, devolver vista (por compatibilidad)
            return view('historial.show', compact('registro'));
        } catch (\Exception $e) {
            \Log::error('Error en HistorialConsultaController@show: ' . $e->getMessage());

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Error interno del servidor: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al cargar el registro');
        }
    }

    public function destroy($id)
    {
        if (!session()->has('usuario')) {
            return redirect('/login')->with('error', 'Debe iniciar sesión.');
        }

        // Buscar el registro sin filtrar por usuario
        $consulta = HistorialConsulta::findOrFail($id);

        $consulta->delete();

        return redirect()
            ->route('historial.index')
            ->with('success', 'Registro eliminado del historial correctamente.');
    }

    public function limpiar(Request $request)
    {
        if (!session()->has('usuario')) {
            return redirect('/login')->with('error', 'Debe iniciar sesión.');
        }

        $dias = $request->input('dias', 30);

        // Eliminar registros de TODOS los usuarios
        $eliminados = HistorialConsulta::where('created_at', '<', now()->subDays($dias))->count();

        HistorialConsulta::where('created_at', '<', now()->subDays($dias))->delete();

        return redirect()
            ->route('historial.index')
            ->with('success', "Se eliminaron $eliminados registros anteriores a $dias días.");
    }

    public function estadisticas()
    {
        if (!session()->has('usuario')) {
            return redirect('/login')->with('error', 'Debe iniciar sesión.');
        }

        // Estadísticas de TODOS los registros
        $estadisticas = [
            'total_consultas' => HistorialConsulta::count(),
            'consultas_hoy' => HistorialConsulta::whereDate('created_at', today())->count(),
            'consultas_semana' => HistorialConsulta::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'por_tipo' => HistorialConsulta::selectRaw('tipo_consulta, COUNT(*) as total')
                ->groupBy('tipo_consulta')
                ->pluck('total', 'tipo_consulta'),
            'actividad_reciente' => HistorialConsulta::selectRaw('DATE(created_at) as fecha, COUNT(*) as total')
                ->whereBetween('created_at', [now()->subDays(7), now()])
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->pluck('total', 'fecha')
        ];

        return view('historial.estadisticas', compact('estadisticas'));
    }
}
