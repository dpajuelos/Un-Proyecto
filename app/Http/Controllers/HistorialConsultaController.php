<?php

namespace App\Http\Controllers;

use App\Models\HistorialConsulta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistorialConsultaController extends Controller
{
    public function index(Request $request)
    {
        // Verificar autenticación personalizada
        if (!session()->has('usuario')) {
            return redirect('/login')->with('error', 'Debe iniciar sesión para ver el historial.');
        }

        // Obtener el ID del usuario de la sesión
        $usuarioSesion = session('usuario');
        $userId = is_array($usuarioSesion) ? $usuarioSesion['id'] : $usuarioSesion->id ?? 1;

        $query = HistorialConsulta::with('user')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc');

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

        // Obtener tipos de consulta
        $tiposConsulta = HistorialConsulta::where('user_id', $userId)
            ->distinct()
            ->pluck('tipo_consulta')
            ->filter();

        if ($tiposConsulta->isEmpty()) {
            $tiposConsulta = collect(['citas', 'personas', 'mineras', 'trabajadores', 'representantes', 'general']);
        }

        // Estadísticas
        $estadisticas = [
            'total_registros' => HistorialConsulta::where('user_id', $userId)->count(),
            'registros_hoy' => HistorialConsulta::where('user_id', $userId)
                ->whereDate('created_at', today())
                ->count(),
            'registros_semana' => HistorialConsulta::where('user_id', $userId)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ];

        return view('historial.index', compact('historial', 'tiposConsulta', 'estadisticas'));
    }

    public function show($id)
    {
        $registro = HistorialConsulta::findOrFail($id);

        return view('historial.show', compact('registro'));
    }

    public function destroy($id)
    {
        if (!session()->has('usuario')) {
            return redirect('/login')->with('error', 'Debe iniciar sesión.');
        }

        $usuarioSesion = session('usuario');
        $userId = is_array($usuarioSesion) ? $usuarioSesion['id'] : $usuarioSesion->id ?? 1;

        $consulta = HistorialConsulta::where('user_id', $userId)
            ->findOrFail($id);

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

        $usuarioSesion = session('usuario');
        $userId = is_array($usuarioSesion) ? $usuarioSesion['id'] : $usuarioSesion->id ?? 1;

        $dias = $request->input('dias', 30);

        $eliminados = HistorialConsulta::where('user_id', $userId)
            ->where('created_at', '<', now()->subDays($dias))
            ->count();

        HistorialConsulta::where('user_id', $userId)
            ->where('created_at', '<', now()->subDays($dias))
            ->delete();

        return redirect()
            ->route('historial.index')
            ->with('success', "Se eliminaron $eliminados registros anteriores a $dias días.");
    }

    public function estadisticas()
    {
        if (!session()->has('usuario')) {
            return redirect('/login')->with('error', 'Debe iniciar sesión.');
        }

        $usuarioSesion = session('usuario');
        $userId = is_array($usuarioSesion) ? $usuarioSesion['id'] : $usuarioSesion->id ?? 1;

        $estadisticas = [
            'total_consultas' => HistorialConsulta::where('user_id', $userId)->count(),
            'consultas_hoy' => HistorialConsulta::where('user_id', $userId)
                ->whereDate('created_at', today())
                ->count(),
            'consultas_semana' => HistorialConsulta::where('user_id', $userId)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'por_tipo' => HistorialConsulta::where('user_id', $userId)
                ->selectRaw('tipo_consulta, COUNT(*) as total')
                ->groupBy('tipo_consulta')
                ->pluck('total', 'tipo_consulta'),
            'actividad_reciente' => HistorialConsulta::where('user_id', $userId)
                ->selectRaw('DATE(created_at) as fecha, COUNT(*) as total')
                ->whereBetween('created_at', [now()->subDays(7), now()])
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->pluck('total', 'fecha')
        ];

        return view('historial.estadisticas', compact('estadisticas'));
    }

    // Método para debug
    public function debug()
    {
        if (!session()->has('usuario')) {
            return redirect('/login')->with('error', 'Debe iniciar sesión.');
        }

        $usuarioSesion = session('usuario');
        $userId = is_array($usuarioSesion) ? $usuarioSesion['id'] : $usuarioSesion->id ?? 1;

        $registros = HistorialConsulta::where('user_id', $userId)->get();
        $total = HistorialConsulta::count();

        dd([
            'session_usuario' => $usuarioSesion,
            'user_id' => $userId,
            'registros_usuario' => $registros->count(),
            'total_registros' => $total,
            'registros' => $registros->toArray()
        ]);
    }
}
