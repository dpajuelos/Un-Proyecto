@php
    function getTipoBadgeColor($tipo)
    {
        return match ($tipo) {
            'citas' => 'citas',
            'representantes' => 'representantes',
            'mineras' => 'mineras',
            'personas' => 'personas',
            'trabajadores' => 'trabajadores',
            default => 'general',
        };
    }
@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Consultas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .main-container {
            backdrop-filter: blur(20px);
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow:
                0 8px 32px rgba(31, 38, 135, 0.37),
                0 2px 16px rgba(31, 38, 135, 0.2);
            margin: 2rem auto;
            max-width: 1400px;
            overflow: hidden;
        }

        .glass-card {
            backdrop-filter: blur(16px);
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow:
                0 4px 16px rgba(31, 38, 135, 0.2),
                0 1px 4px rgba(31, 38, 135, 0.1);
        }

        .header-gradient {
            background: var(--primary-gradient);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .header-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .page-title {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title i {
            font-size: 2rem;
            opacity: 0.9;
        }

        .btn-modern {
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-primary-modern {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-info-modern {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }

        .btn-warning-modern {
            background: var(--warning-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(67, 233, 123, 0.4);
        }

        .btn-secondary-modern {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .filter-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2rem;
            margin: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-control-modern {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-control-modern::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control-modern:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
            color: white;
        }

        .form-control-modern option {
            background: #2d3748;
            color: white;
        }

        .form-label-modern {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .historial-card-modern {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .historial-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
            transition: width 0.3s ease;
        }

        .historial-card-modern:hover {
            transform: translateY(-5px);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 10px 20px rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.25);
        }

        .historial-card-modern:hover::before {
            width: 8px;
        }

        .tipo-badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .badge-citas {
            background: var(--primary-gradient);
            color: white;
        }

        .badge-representantes {
            background: var(--success-gradient);
            color: white;
        }

        .badge-mineras {
            background: var(--warning-gradient);
            color: white;
        }

        .badge-personas {
            background: var(--secondary-gradient);
            color: white;
        }

        .badge-trabajadores {
            background: var(--danger-gradient);
            color: white;
        }

        .badge-general {
            background: var(--dark-gradient);
            color: white;
        }

        .detalle-modern {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1rem;
            backdrop-filter: blur(10px);
        }

        .url-display {
            font-family: 'Fira Code', monospace;
            background: rgba(0, 0, 0, 0.2);
            color: #00ff88;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border-left: 3px solid #00ff88;
            margin: 0.5rem 0;
            word-break: break-all;
        }

        .param-badge {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.3rem 0.7rem;
            border-radius: 15px;
            font-size: 0.8rem;
            margin: 0.2rem;
            display: inline-block;
            backdrop-filter: blur(5px);
        }

        .btn-action-modern {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .btn-action-modern::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transition: all 0.3s ease;
            transform: translate(-50%, -50%);
        }

        .btn-action-modern:hover::before {
            width: 100px;
            height: 100px;
        }

        .btn-action-modern:hover {
            transform: translateY(-3px) scale(1.05);
        }

        .btn-view {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }

        .btn-delete {
            background: var(--secondary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(250, 112, 154, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: white;
        }

        .empty-state i {
            font-size: 4rem;
            opacity: 0.5;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            opacity: 0.8;
            font-size: 1.1rem;
        }

        .modal-modern {
            backdrop-filter: blur(10px);
        }

        .modal-modern .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-modern .modal-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 20px 20px 0 0;
            border-bottom: none;
            padding: 1.5rem 2rem;
        }

        .modal-modern .modal-title {
            font-weight: 600;
            font-size: 1.3rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.2);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .pagination {
            --bs-pagination-bg: rgba(255, 255, 255, 0.1);
            --bs-pagination-border-color: rgba(255, 255, 255, 0.2);
            --bs-pagination-color: white;
            justify-content: center;
            margin: 2rem 0;
        }

        .pagination .page-link {
            backdrop-filter: blur(10px);
            border-radius: 8px;
            margin: 0 0.25rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 1rem;
                border-radius: 16px;
            }

            .page-title {
                font-size: 2rem;
            }

            .filter-section {
                margin: 1rem;
                padding: 1.5rem;
            }

            .historial-card-modern {
                padding: 1rem;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
                margin: 1rem;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-up {
            animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }



        .debug-info {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin: 1rem 2rem;
            color: white;
            font-family: monospace;
            font-size: 0.9rem;
        }

        .alert-modern {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            color: white;
            padding: 1rem 1.5rem;
            margin: 1rem 2rem;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            border-left: 4px solid #28a745;
        }

        .alert-error {
            border-left: 4px solid #dc3545;
        }

        .btn-home {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }

        .no-data-illustration {
            max-width: 300px;
            margin: 0 auto 2rem;
            opacity: 0.6;
        }
    </style>
</head>

<body>
    <div class="main-container slide-up">
        <!-- Mostrar mensajes de éxito o error -->
        @if (session('success'))
            <div class="alert-modern alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-modern alert-error">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="header-gradient">
            <div class="header-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h1 class="page-title">
                        <i class="fas fa-history"></i>
                        Historial de Consultas
                    </h1>
                    <div class="d-flex gap-3 flex-wrap">

                        <a href="{{ route('home') ?? '/home' }}" class="btn-modern btn-home">
                            <i class="fas fa-home"></i>
                            Ir a Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Estadísticas rápidas -->
        @if (isset($estadisticas))
            <div class="stats-container">
                <div class="stat-card fade-in">
                    <div class="stat-number">{{ $estadisticas['total_registros'] }}</div>
                    <div class="stat-label">Total Registros</div>
                </div>
                <div class="stat-card fade-in" style="animation-delay: 0.1s">
                    <div class="stat-number">{{ $tiposConsulta->count() }}</div>
                    <div class="stat-label">Tipos Consulta</div>
                </div>
                <div class="stat-card fade-in" style="animation-delay: 0.2s">
                    <div class="stat-number">{{ $estadisticas['registros_hoy'] }}</div>
                    <div class="stat-label">Consultas Hoy</div>
                </div>
                <div class="stat-card fade-in" style="animation-delay: 0.3s">
                    <div class="stat-number">{{ $estadisticas['registros_semana'] }}</div>
                    <div class="stat-label">Esta Semana</div>
                </div>
            </div>
        @endif

        <!-- Filtros -->
        @if (isset($tiposConsulta) && $tiposConsulta->count() > 0)
            <div class="filter-section fade-in">
                <form method="GET">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label class="form-label-modern">
                                <i class="fas fa-filter me-2"></i>Tipo de Consulta
                            </label>
                            <select name="tipo_consulta" class="form-control-modern">
                                <option value="">Todos los tipos</option>
                                @foreach ($tiposConsulta as $tipo)
                                    <option value="{{ $tipo }}"
                                        {{ request('tipo_consulta') == $tipo ? 'selected' : '' }}>
                                        {{ ucfirst($tipo) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-modern">
                                <i class="fas fa-calendar-alt me-2"></i>Fecha Desde
                            </label>
                            <input type="date" name="fecha_desde" class="form-control-modern"
                                value="{{ request('fecha_desde') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-modern">
                                <i class="fas fa-calendar-alt me-2"></i>Fecha Hasta
                            </label>
                            <input type="date" name="fecha_hasta" class="form-control-modern"
                                value="{{ request('fecha_hasta') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-modern">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn-modern btn-primary-modern">
                                    <i class="fas fa-search"></i>
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <!-- Lista de Historial -->
        <div style="padding: 0 2rem 2rem;">
            @forelse($historial as $index => $registro)
                <div class="historial-card-modern fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <div class="d-flex align-items-center mb-3">
                                <span
                                    class="tipo-badge-modern badge-{{ getTipoBadgeColor($registro->tipo_consulta) }} me-3">
                                    {{ ucfirst($registro->tipo_consulta) }}
                                </span>
                                <div class="text-white">
                                    <i class="fas fa-clock me-2 opacity-75"></i>
                                    <strong>{{ $registro->created_at->format('d/m/Y H:i:s') }}</strong>
                                </div>
                            </div>

                            @if (is_array($registro->detalle) && isset($registro->detalle['url']))
                                <div class="mb-3">
                                    <label class="text-white fw-bold mb-2">
                                        <i class="fas fa-link me-2"></i>URL Consultada:
                                    </label>
                                    <div class="url-display">{{ $registro->detalle['url'] }}</div>
                                </div>
                            @endif

                            @if (is_array($registro->detalle) && isset($registro->detalle['parametros']) && !empty($registro->detalle['parametros']))
                                <div class="mb-3">
                                    <label class="text-white fw-bold mb-2">
                                        <i class="fas fa-cogs me-2"></i>Parámetros:
                                    </label>
                                    <div class="detalle-modern">
                                        @foreach ($registro->detalle['parametros'] as $key => $value)
                                            <span class="param-badge">{{ $key }}:
                                                {{ is_array($value) ? json_encode($value) : $value }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex align-items-center text-white opacity-75">
                                <i class="fas fa-globe me-2"></i>
                                <span class="me-4">IP: {{ $registro->ip_address }}</span>
                                @if (is_array($registro->detalle) && isset($registro->detalle['metodo']))
                                    <i class="fas fa-code me-2"></i>
                                    <span>Método: {{ $registro->detalle['metodo'] }}</span>
                                @endif
                                @if ($registro->user)
                                    <i class="fas fa-user ms-4 me-2"></i>
                                    <span>Usuario:
                                        {{ $registro->user->name ?? ($registro->user->email ?? 'N/A') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            <div class="d-flex justify-content-end align-items-center">
                                <a href="{{ route('historial.show', $registro->id) }}"
                                    class="btn-action-modern btn-view" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('historial.destroy', $registro->id) }}"
                                    style="display: inline;" onsubmit="return confirm('¿Eliminar este registro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-modern btn-delete" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state fade-in">
                    <div class="no-data-illustration">
                        <i class="fas fa-search-minus"></i>
                    </div>
                    <h3>No hay registros en el historial</h3>
                    <p>
                        @if (request()->hasAny(['tipo_consulta', 'fecha_desde', 'fecha_hasta']))
                            No se encontraron consultas con los filtros aplicados.
                        @else
                            Aún no has realizado consultas que se registren en el historial.
                        @endif
                    </p>
                    @if (request()->hasAny(['tipo_consulta', 'fecha_desde', 'fecha_hasta']))
                        <a href="{{ route('historial.index') }}" class="btn-modern btn-primary-modern mt-3">
                            <i class="fas fa-times me-2"></i>
                            Limpiar Filtros
                        </a>
                    @endif
                </div>
            @endforelse

            <!-- Paginación -->
            @if ($historial->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $historial->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Limpiar Historial -->
    @if (isset($estadisticas) && $estadisticas['total_registros'] > 0)
        <div class="modal fade modal-modern" id="modalLimpiar" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-broom me-2"></i>
                            Limpiar Historial
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('historial.limpiar') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Eliminar registros anteriores a:</label>
                                <select name="dias" class="form-select">
                                    <option value="7">7 días</option>
                                    <option value="30" selected>30 días</option>
                                    <option value="60">60 días</option>
                                    <option value="90">90 días</option>
                                </select>
                            </div>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>¡Atención!</strong> Esta acción no se puede deshacer. Se eliminarán
                                permanentemente
                                todos los registros anteriores al período seleccionado.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-broom me-2"></i>Limpiar Historial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animaciones suaves para los elementos
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto de aparición en scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observar tarjetas del historial
            document.querySelectorAll('.historial-card-modern').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });

            // Efecto de hover mejorado para las tarjetas
            document.querySelectorAll('.historial-card-modern').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });

        // Función para confirmar eliminación con SweetAlert (opcional)
        function confirmarEliminacion(form) {
            event.preventDefault();

            // Aquí puedes usar SweetAlert si lo prefieres
            if (confirm('¿Estás seguro de que deseas eliminar este registro?\n\nEsta acción no se puede deshacer.')) {
                form.submit();
            }
        }
    </script>
</body>

</html>
