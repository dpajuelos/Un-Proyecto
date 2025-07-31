@php
    function getTipoBadgeColor($tipo)
    {
        return match ($tipo) {
            'citas' => 'citas',
            'representantes' => 'representantes',
            'mineras' => 'mineras',
            'trabajadores' => 'trabajadores',
            'personas' => 'personas',
            default => 'general',
        };
    }

@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Historial de Consultas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/historial/index.css', 'resources/js/historial/index.js'])
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
                                {{-- Comentar la parte del usuario ya que no existe la relación --}}
                                {{-- @if ($registro->user)
                                    <i class="fas fa-user ms-4 me-2"></i>
                                    <span>Usuario:
                                        {{ $registro->user->name ?? ($registro->user->email ?? 'N/A') }}</span>
                                @endif --}}
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn-action-modern btn-view" title="Ver detalles"
                                    onclick="mostrarDetalles({{ $registro->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
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

    <!-- Modal Detalles del Historial -->
    <div class="modal fade modal-modern" id="modalDetalles" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Detalles del Registro
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalDetallesContent">
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function mostrarDetalles(id) {
            const modal = new bootstrap.Modal(document.getElementById('modalDetalles'));
            const content = document.getElementById('modalDetallesContent');

            // Mostrar loading
            content.innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    `;

            modal.show();

            // Realizar petición AJAX con mejor manejo de errores
            fetch(`/historial/${id}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(response => {
                    console.log('Status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data received:', data);
                    if (data.success && data.registro) {
                        content.innerHTML = generarContenidoModal(data.registro);
                    } else {
                        throw new Error('Formato de respuesta inválido');
                    }
                })
                .catch(error => {
                    console.error('Error completo:', error);
                    content.innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                <h5>Error al cargar los detalles</h5>
                <p class="mb-0">Error: ${error.message}</p>
                <small class="text-muted">Revisa la consola para más detalles</small>
            </div>
        `;
                });
        }

        function generarContenidoModal(registro) {
            const fechaFormateada = new Date(registro.created_at).toLocaleString('es-ES', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const tipoBadgeClass = getTipoBadgeColor(registro.tipo_consulta);

            let parametrosHtml = '';
            if (registro.detalle && registro.detalle.parametros && Object.keys(registro.detalle.parametros).length > 0) {
                parametrosHtml = `
            <div class="detalle-section mb-4">
                <h6 class="detalle-title">
                    <i class="fas fa-cogs me-2"></i>Parámetros de Consulta
                </h6>
                <div class="parametros-grid">
                    ${Object.entries(registro.detalle.parametros).map(([key, value]) => `
                                                            <div class="param-item">
                                                                <strong>${key}:</strong>
                                                                <span>${typeof value === 'object' ? JSON.stringify(value) : value}</span>
                                                            </div>
                                                        `).join('')}
                </div>
            </div>
        `;
            }

            let urlHtml = '';
            if (registro.detalle && registro.detalle.url) {
                urlHtml = `
            <div class="detalle-section mb-4">
                <h6 class="detalle-title">
                    <i class="fas fa-link me-2"></i>URL Consultada
                </h6>
                <div class="url-display-modal">
                    ${registro.detalle.url}
                </div>
            </div>
        `;
            }

            let usuarioHtml = '';
            if (registro.user) {
                usuarioHtml = `
            <div class="detalle-section mb-4">
                <h6 class="detalle-title">
                    <i class="fas fa-user me-2"></i>Información del Usuario
                </h6>
                <div class="usuario-info">
                    <p><strong>Nombre:</strong> ${registro.user.name || 'N/A'}</p>
                    <p><strong>Email:</strong> ${registro.user.email || 'N/A'}</p>
                </div>
            </div>
        `;
            }

            return `
        <div class="modal-detalle-container">
            <!-- Header del registro -->
            <div class="detalle-header mb-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="tipo-badge-modal badge-${tipoBadgeClass}">
                            ${registro.tipo_consulta.charAt(0).toUpperCase() + registro.tipo_consulta.slice(1)}
                        </span>
                    </div>
                    <div class="fecha-registro">
                        <i class="fas fa-calendar-alt me-2"></i>
                        ${fechaFormateada}
                    </div>
                </div>
            </div>

            ${urlHtml}
            ${parametrosHtml}

            <!-- Información técnica -->
            <div class="detalle-section mb-4">
                <h6 class="detalle-title">
                    <i class="fas fa-info-circle me-2"></i>Información Técnica
                </h6>
                <div class="info-tecnica">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>IP Address:</strong> ${registro.ip_address}</p>
                            <p><strong>ID del Registro:</strong> ${registro.id}</p>
                        </div>
                        <div class="col-md-6">
                            ${registro.detalle && registro.detalle.metodo ? `<p><strong>Método HTTP:</strong> ${registro.detalle.metodo}</p>` : ''}
                            <p><strong>User Agent:</strong> ${registro.user_agent ? registro.user_agent.substring(0, 50) + '...' : 'N/A'}</p>
                        </div>
                    </div>
                </div>
            </div>

            ${usuarioHtml}

            <!-- Detalles completos (JSON) -->
            <div class="detalle-section">
                <h6 class="detalle-title">
                    <i class="fas fa-code me-2"></i>Detalles Completos (JSON)
                </h6>
                <div class="json-display">
                    <pre><code>${JSON.stringify(registro.detalle, null, 2)}</code></pre>
                </div>
            </div>
        </div>
    `;
        }

        function getTipoBadgeColor(tipo) {
            const colors = {
                'citas': 'citas',
                'representantes': 'representantes',
                'mineras': 'mineras',
                'trabajadores': 'trabajadores',
                'personas': 'personas'
            };
            return colors[tipo] || 'general';
        }
    </script>
</body>

</html>
