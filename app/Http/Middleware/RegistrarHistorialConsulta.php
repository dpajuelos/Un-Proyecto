<?php

namespace App\Http\Middleware;

use App\Models\HistorialConsulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class RegistrarHistorialConsulta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $tipoConsulta = null): Response
    {
        $response = $next($request);

        // Verificar si el usuario está autenticado (sistema personalizado)
        if (session()->has('usuario')) {
            $this->registrarConsulta($request, $tipoConsulta);
        }

        return $response;
    }

    private function registrarConsulta($request, $tipoConsulta = null)
    {
        $usuarioSesion = session('usuario');
        $userId = is_array($usuarioSesion) ? $usuarioSesion['id'] : $usuarioSesion->id ?? 1;

        $detalle = [
            'url' => $request->fullUrl(),
            'metodo' => $request->method(),
            'parametros' => $request->except(['password', '_token']),
            'ruta' => $request->route() ? $request->route()->getName() : null
        ];

        if (!$tipoConsulta) {
            $tipoConsulta = $this->determinarTipoConsulta($request);
        }

        try {
            HistorialConsulta::create([
                'user_id' => $userId,
                'tipo_consulta' => $tipoConsulta,
                'detalle' => json_encode($detalle),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error registrando historial: ' . $e->getMessage());
        }
    }

    private function determinarTipoConsulta($request)
    {
        $ruta = $request->route() ? $request->route()->getName() : '';
        $path = $request->path();

        if (str_contains($ruta, 'citas') || str_contains($path, 'citas'))
            return 'citas';
        if (str_contains($ruta, 'representantes') || str_contains($path, 'representantes'))
            return 'representantes';
        if (str_contains($ruta, 'mineras') || str_contains($path, 'mineras'))
            return 'mineras';
        if (str_contains($ruta, 'personas') || str_contains($path, 'personas'))
            return 'personas';
        if (str_contains($ruta, 'trabajadores') || str_contains($path, 'trabajadores'))
            return 'trabajadores';

        return 'general';
    }
}
