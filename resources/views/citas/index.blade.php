<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/js/citas/index.js', 'resources/css/citas/index.css'])
</head>

<body>
    <div class="modern-container">
        <!-- Decoración de fondo -->
        <div class="bg-decoration"></div>

        <!-- Header Section -->
        <div class="header-section">
            <div class="header-content">
                <div class="header-text">
                    <div class="icon-wrapper">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <h1 class="main-title">Gestión de Citas</h1>
                        <p class="subtitle">Administra y organiza las citas de manera eficiente</p>
                    </div>
                </div>
                <div class="header-actions">
                    <button onclick="abrirModalNuevaCita()" class="btn-modern btn-primary">
                        <i class="fas fa-plus"></i>
                        Nueva Cita
                    </button>
                    <a href="{{ url('/home') }}" class="btn-modern btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Card -->
        <div class="content-card">
            <div class="content-header">
                <div class="content-title">
                    <h2>Lista de Citas</h2>
                    <span class="record-count">{{ $citas->count() }} citas registradas</span>
                </div>
                <div class="content-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Buscar citas..." id="searchInput">
                    </div>
                    <button class="filter-btn" type="button">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>

            <!-- Filtros -->
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
                <form method="GET" class="mb-0">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>
                                    Pendiente</option>
                                <option value="confirmada" {{ request('estado') == 'confirmada' ? 'selected' : '' }}>
                                    Confirmada
                                </option>
                                <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>
                                    Cancelada</option>
                                <option value="reprogramada"
                                    {{ request('estado') == 'reprogramada' ? 'selected' : '' }}>Reprogramada
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Buscar</label>
                            <input type="text" name="buscar" class="form-control" placeholder="ID Rep o ID Rep Sus"
                                value="{{ request('buscar') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Mensajes -->
            @if (session('success'))
                <div style="padding: 1.5rem; padding-bottom: 0;">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            <div class="table-wrapper">
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Representante</th>
                                <th>DNI</th>
                                <th>Cargo</th>
                                <th>Fecha Original</th>
                                <th>Hora Original</th>
                                <th>Nueva Fecha</th>
                                <th>Nueva Hora</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($citas as $cita)
                                <tr>
                                    <td>
                                        <div class="table-user">
                                            <div class="user-avatar">
                                                <img class="avatar"
                                                    src="https://ui-avatars.com/api/?name={{ urlencode(($cita->representantePrincipal->persona->nombres ?? '') . ' ' . ($cita->representantePrincipal->persona->apellidos ?? '')) }}&background=6366f1&color=fff"
                                                    alt="Avatar">
                                            </div>
                                            <div class="user-info">
                                                <div class="user-name">
                                                    @if ($cita->representantePrincipal)
                                                        {{ $cita->representantePrincipal->persona->nombres ?? '' }}
                                                        {{ $cita->representantePrincipal->persona->apellidos ?? '' }}
                                                    @endif
                                                </div>
                                                <div class="user-email">
                                                    DNI: {{ $cita->representantePrincipal->persona->dni ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="dni-badge">
                                            {{ $cita->representantePrincipal->persona->dni ?? '' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="role-badge">
                                            {{ $cita->representantePrincipal->cargo ?? '' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($cita->fecha)
                                            <span class="fw-bold">
                                                {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($cita->hora)
                                            <span class="badge bg-info">
                                                {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($cita->fecha_nue)
                                            <span class="fw-bold">
                                                {{ \Carbon\Carbon::parse($cita->fecha_nue)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($cita->hora_nue)
                                            <span class="badge bg-success">
                                                {{ \Carbon\Carbon::parse($cita->hora_nue)->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="estado-badge estado-{{ strtolower($cita->estado) }}">
                                            {{ ucfirst($cita->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <button type="button" class="table-btn view"
                                                onclick="abrirModalVerCita(
                                                    {{ $cita->id_cita }},
                                                    '{{ $cita->representantePrincipal->persona->nombres ?? '' }}',
                                                    '{{ $cita->representantePrincipal->persona->apellidos ?? '' }}',
                                                    '{{ $cita->representantePrincipal->persona->dni ?? '' }}',
                                                    '{{ $cita->representantePrincipal->cargo ?? '' }}',
                                                    '{{ $cita->representantePrincipal->persona->telefono ?? '' }}',
                                                    '{{ $cita->representantePrincipal->persona->correo ?? '' }}',
                                                    '{{ $cita->representantePrincipal->minera->nombre_minera ?? '' }}',
                                                    '{{ $cita->representantePrincipal->minera->ruc ?? '' }}',
                                                    '{{ $cita->representantePrincipal->minera->direccion ?? '' }}',
                                                    '{{ $cita->representantePrincipal->minera->telefono_contacto ?? '' }}',
                                                    '{{ $cita->representantePrincipal->minera->correo_contacto ?? '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->nombres : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->apellidos : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->dni : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->cargo : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->telefono : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->correo : '' }}',
                                                    '{{ $cita->fecha }}',
                                                    '{{ $cita->hora ? \Carbon\Carbon::parse($cita->hora)->format('H:i') : '' }}',
                                                    '{{ $cita->fecha_nue }}',
                                                    '{{ $cita->hora_nue ? \Carbon\Carbon::parse($cita->hora_nue)->format('H:i') : '' }}',
                                                    '{{ $cita->estado }}',
                                                    '{{ $cita->descripcion ?? '' }}'
                                                )"
                                                title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button class="table-btn edit"
                                                onclick="abrirModalEditarCita(
                                                    {{ $cita->id_cita }},
                                                    {{ $cita->id_rep }},
                                                    {{ $cita->id_rep_sus ?? 'null' }},
                                                    '{{ $cita->fecha ? \Carbon\Carbon::parse($cita->fecha)->format('Y-m-d') : '' }}',
                                                    '{{ $cita->hora ? \Carbon\Carbon::parse($cita->hora)->format('H:i') : '' }}',
                                                    '{{ $cita->estado }}',
                                                    '{{ $cita->representantePrincipal->persona->nombres ?? '' }}',
                                                    '{{ $cita->representantePrincipal->persona->apellidos ?? '' }}',
                                                    '{{ $cita->representantePrincipal->persona->dni ?? '' }}',
                                                    '{{ $cita->representantePrincipal->cargo ?? '' }}',
                                                    '{{ $cita->representantePrincipal->persona->telefono ?? '' }}',
                                                    '{{ $cita->representantePrincipal->persona->correo ?? '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->nombres : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->apellidos : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->dni : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->cargo : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->telefono : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->correo : '' }}',
                                                    '{{ $cita->descripcion ?? '' }}',
                                                    '{{ $cita->fecha_nue ? \Carbon\Carbon::parse($cita->fecha_nue)->format('Y-m-d') : '' }}',
                                                    '{{ $cita->hora_nue ? \Carbon\Carbon::parse($cita->hora_nue)->format('H:i') : '' }}'
                                                )"
                                                title="Edita    r cita">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button" class="table-btn delete"
                                                onclick="confirmarEliminar({{ $cita->id_cita }})"
                                                title="Eliminar cita">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                            <h5>No hay citas registradas</h5>
                                            <p>Comienza creando una nueva cita</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            <div style="padding: 1.5rem;">
                {{ $citas->links() }}
            </div>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar esta cita?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="formEliminar" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Cita -->
    <div class="modal_editar" id="modalEditarCita" style="display: none;">
        <div class="container">
            <div class="modal-header">
                <h2>Editar Cita</h2>
                <button type="button" class="btn-close" onclick="cerrarModalEditarCita()">×</button>
            </div>
            <div class="modal-body">
                <form id="formEditarCita" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Sección Representante Principal -->
                    <div class="representante-section">
                        <div class="section-title">Representante Principal</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="input_nombre_rep"
                                        name="nombre_rep" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Apellido <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="input_apellido_rep"
                                        name="apellido_rep" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">DNI <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="input_dni_rep" name="dni_rep"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Cargo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="input_cargo_rep" name="cargo_rep"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="input_telefono_rep"
                                        name="telefono_rep">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Correo</label>
                                    <input type="email" class="form-control" id="input_correo_rep"
                                        name="correo_rep">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="input_id_rep" name="id_rep">
                    </div>

                    <!-- Checkbox para Representante Sustituto -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkbox_sustituto"
                                name="tiene_sustituto" value="1" onchange="toggleSustituto()">
                            <label class="form-check-label" for="checkbox_sustituto">
                                <i class="fas fa-user-plus me-2"></i>
                                Agregar Representante Sustituto
                            </label>
                        </div>
                    </div>

                    <!-- Sección Representante Sustituto -->
                    <div id="sustitutoCampos" class="sustituto-section" style="display: none;">
                        <div class="section-title">Representante Sustituto</div>
                        <div class="row">
                            <!-- DNI como primer campo -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">DNI <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="input_dni_sus" name="dni_sus"
                                            maxlength="8" placeholder="Ingrese DNI para buscar..."
                                            oninput="buscarPersonaPorDni(this.value, 'sus')">
                                        <span class="input-group-text" id="dni_sus_status">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                    </div>
                                    <small class="form-text" id="dni_sus_message"></small>
                                </div>
                            </div>

                            <!-- Nombres y Apellidos en la misma fila -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nombres <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="input_nombre_sus"
                                        name="nombre_sus" placeholder="Nombres del representante">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Apellidos <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="input_apellido_sus"
                                        name="apellido_sus" placeholder="Apellidos del representante">
                                </div>
                            </div>

                            <!-- Cargo y Teléfono en la misma fila -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Cargo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="input_cargo_sus" name="cargo_sus"
                                        placeholder="Cargo del representante">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="input_telefono_sus"
                                        name="telefono_sus" placeholder="Teléfono (opcional)">
                                </div>
                            </div>

                            <!-- Correo en fila completa -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Correo</label>
                                    <input type="email" class="form-control" id="input_correo_sus"
                                        name="correo_sus" placeholder="Correo electrónico (opcional)">
                                </div>
                            </div>
                        </div>

                        <!-- Indicador de estado de la búsqueda -->
                        <div class="alert alert-info" id="persona_sus_status" style="display: none;">
                            <i class="fas fa-info-circle me-2"></i>
                            <span id="persona_sus_message"></span>
                        </div>
                    </div>

                    <div id="noSustituto" class="no-sustituto">
                        <span>📋 No se añadió representante sustituto para esta cita</span>
                    </div>

                    <!-- Resto del formulario permanece igual -->
                    <!-- Sección Fecha y Hora Original (Solo lectura) -->
                    <div class="datetime-section">
                        <div class="section-title">📅 Cita Original (No editable)</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Original</label>
                                    <input type="date" class="form-control" id="input_fecha_original"
                                        name="fecha" readonly style="background-color: #f8f9fa;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hora Original</label>
                                    <input type="time" class="form-control" id="input_hora_original"
                                        name="hora" readonly style="background-color: #f8f9fa;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección Nueva Fecha y Hora (Editable) -->
                    <div class="datetime-section"
                        style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); border: 1px solid rgba(255, 152, 0, 0.2);">
                        <div class="section-title" style="color: #ff9800;">🔄 Reprogramar Cita</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nueva Fecha</label>
                                    <input type="date" class="form-control" id="input_fecha_nueva"
                                        name="fecha_nue">
                                    <small class="text-muted">Debe ser posterior a la fecha original</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nueva Hora</label>
                                    <input type="time" class="form-control" id="input_hora_nueva"
                                        name="hora_nue">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-warning"
                                onclick="limpiarFechasNuevas()">
                                <i class="fas fa-eraser me-1"></i>
                                Limpiar Reprogramación
                            </button>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <label class="form-label">Estado de la Cita</label>
                        <select class="form-select" id="input_estado" name="estado" required>
                            <option value="pendiente">🟡 Pendiente</option>
                            <option value="confirmada">🟢 Confirmada</option>
                            <option value="cancelada">🔴 Cancelada</option>
                            <option value="reprogramada">🔵 Reprogramada</option>
                        </select>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control" id="input_descripcion" name="descripcion" rows="3"
                            placeholder="Añade detalles adicionales sobre la cita..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cerrarModalEditarCita()">Cancelar</button>
                <button type="submit" form="formEditarCita" class="btn btn-primary">Actualizar Cita</button>
            </div>
        </div>
    </div>

    <!-- Modal Nueva Cita -->
    <div class="modal_editar" id="modalNuevaCita" style="display: none;">
        <div class="container">
            <div class="modal-header">
                <h2>Nueva Cita</h2>
                <button type="button" class="btn-close" onclick="cerrarModalNuevaCita()">×</button>
            </div>
            <div class="modal-body">
                <form id="formNuevaCita" action="{{ route('citas.store') }}" method="POST">
                    @csrf

                    <!-- Sección Representante Principal -->
                    <div class="representante-section">
                        <div class="section-title">Representante Principal</div>
                        <div class="mb-3">
                            <label class="form-label">Seleccionar Representante <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="nuevo_id_rep" name="id_rep" required>
                                <option value="">Seleccione un representante</option>
                                @foreach ($representantes as $rep)
                                    <option value="{{ $rep->id_rep }}">{{ $rep->persona->nombres }}
                                        {{ $rep->persona->apellidos }} - {{ $rep->persona->dni }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Checkbox para Representante Sustituto -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="nuevo_checkbox_sustituto"
                                name="tiene_sustituto" value="1" onchange="toggleNuevoSustituto()">
                            <label class="form-check-label" for="nuevo_checkbox_sustituto">
                                <i class="fas fa-user-plus me-2"></i>
                                Agregar Representante Sustituto
                            </label>
                        </div>
                    </div>

                    <!-- Sección Representante Sustituto -->
                    <div id="nuevoSustitutoCampos" class="sustituto-section" style="display: none;">
                        <div class="section-title">Representante Sustituto</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nombres <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nuevo_nombre_sus"
                                        name="nombre_sus">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Apellidos <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nuevo_apellido_sus"
                                        name="apellido_sus">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">DNI <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nuevo_dni_sus" name="dni_sus"
                                        maxlength="8">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Cargo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nuevo_cargo_sus"
                                        name="cargo_sus">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="nuevo_telefono_sus"
                                        name="telefono_sus">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Correo</label>
                                    <input type="email" class="form-control" id="nuevo_correo_sus"
                                        name="correo_sus">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="nuevoNoSustituto" class="no-sustituto">
                        <span>📋 No se añadirá representante sustituto para esta cita</span>
                    </div>

                    <!-- Sección Fecha y Hora -->
                    <div class="datetime-section">
                        <div class="section-title">Programación</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="nuevo_fecha" name="fecha"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hora <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="nuevo_hora" name="hora"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <label class="form-label">Estado Inicial</label>
                        <select class="form-select" id="nuevo_estado" name="estado" required>
                            <option value="pendiente">🟡 Pendiente</option>
                            <option value="confirmada">🟢 Confirmada</option>
                            <option value="cancelada">🔴 Cancelada</option>
                            <option value="reprogramada">🔵 Reprogramada</option>
                        </select>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control" id="nuevo_descripcion" name="descripcion" rows="3"
                            placeholder="Añade detalles adicionales sobre la cita..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cerrarModalNuevaCita()">Cancelar</button>
                <button type="submit" form="formNuevaCita" class="btn btn-primary">Crear Cita</button>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Detalle de Cita -->
    <div class="modal_ver" id="modalVerCita">
        <div class="container">
            <div class="modal-header">
                <h2>Detalle de la Cita</h2>
                <button type="button" class="btn-close" onclick="cerrarModalVerCita()">×</button>
            </div>
            <div class="modal-body">
                <!-- Información del Representante Principal -->
                <div class="info-card">
                    <div class="card-title">
                        👤 Representante Principal
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nombre Completo:</span>
                        <span class="info-value" id="ver_nombre_rep"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">DNI:</span>
                        <span class="info-value" id="ver_dni_rep"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Cargo:</span>
                        <span class="info-value" id="ver_cargo_rep"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value" id="ver_telefono_rep"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Correo:</span>
                        <span class="info-value" id="ver_correo_rep"></span>
                    </div>
                </div>

                <!-- Información de la Minera -->
                <div class="info-card minera">
                    <div class="card-title">
                        🏭 Información de la Minera
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nombre:</span>
                        <span class="info-value" id="ver_nombre_minera"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">RUC:</span>
                        <span class="info-value" id="ver_ruc_minera"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dirección:</span>
                        <span class="info-value" id="ver_direccion_minera"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value" id="ver_telefono_minera"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Correo:</span>
                        <span class="info-value" id="ver_correo_minera"></span>
                    </div>
                </div>

                <!-- Información del Representante Sustituto -->
                <div class="info-card" id="ver_sustituto_card">
                    <div class="card-title">
                        👥 Representante Sustituto
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nombre Completo:</span>
                        <span class="info-value" id="ver_nombre_sus"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">DNI:</span>
                        <span class="info-value" id="ver_dni_sus"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Cargo:</span>
                        <span class="info-value" id="ver_cargo_sus"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value" id="ver_telefono_sus"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Correo:</span>
                        <span class="info-value" id="ver_correo_sus"></span>
                    </div>
                </div>

                <div class="no-data" id="ver_no_sustituto" style="display:none;">
                    📋 No se asignó representante sustituto para esta cita
                </div>

                <!-- Información de Horarios -->
                <div class="info-card horario">
                    <div class="card-title">
                        🕐 Programación
                    </div>
                    <div class="info-row">
                        <span class="info-label">Fecha Original:</span>
                        <span class="info-value" id="ver_fecha_original"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Hora Original:</span>
                        <span class="info-value" id="ver_hora_original"></span>
                    </div>
                    <div class="info-row" id="ver_fecha_nueva_row" style="display:none;">
                        <span class="info-label">Nueva Fecha:</span>
                        <span class="info-value" id="ver_fecha_nueva"></span>
                    </div>
                    <div class="info-row" id="ver_hora_nueva_row" style="display:none;">
                        <span class="info-label">Nueva Hora:</span>
                        <span class="info-value" id="ver_hora_nueva"></span>
                    </div>
                </div>

                <!-- Descripción de la Cita -->
                <div class="info-card estado">
                    <div class="card-title">
                        📝 Descripción
                    </div>
                    <div class="info-row">
                        <span class="info-value" id="ver_descripcion"
                            style="max-width: 100%; text-align: left; white-space: pre-wrap;"></span>
                    </div>
                </div>

                <!-- Estado de la Cita -->
                <div class="info-card estado">
                    <div class="card-title">
                        📊 Estado de la Cita
                    </div>
                    <div class="info-row">
                        <span class="info-label">Estado Actual:</span>
                        <span class="info-value">
                            <span class="estado-badge" id="ver_estado_badge"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" onclick="cerrarModalVerCita()">
                    <i class="fas fa-check-circle me-2"></i>
                    Entendido
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
