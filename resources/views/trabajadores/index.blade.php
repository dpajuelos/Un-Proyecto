@extends('layouts.app')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('title', 'Gestión de Trabajadores')
@vite(['resources/css/trabajadores/index.css', 'resources/js/trabajadores/index.js'])
@section('content')
    <div class="modern-container">
        <!-- Background Elements -->
        <div class="bg-decoration"></div>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <!-- Header Section -->
                    <div class="header-section">
                        <div class="header-content">
                            <div class="header-text">
                                <div class="icon-wrapper">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h1 class="main-title">Gestión de Trabajadores</h1>
                                    <p class="subtitle">Administra y visualiza información del personal</p>
                                </div>
                            </div>
                            <div class="header-actions">
                                <a href="{{ url('home') }}" class="btn-modern btn-secondary">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Volver</span>
                                </a>
                                <a href="{{ route('trabajadores.create') }}" class="btn-modern btn-primary">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Nuevo Trabajador</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Dashboard -->
                    <div class="stats-grid">
                        <div class="stat-card primary">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $trabajadores->count() }}</div>
                                <div class="stat-label">Total Trabajadores</div>
                            </div>
                            <div class="stat-trend">
                                <i class="fas fa-arrow-up"></i>
                                <span>12%</span>
                            </div>
                        </div>

                        <div class="stat-card success">
                            <div class="stat-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $trabajadores->count() }}</div>
                                <div class="stat-label">Activos</div>
                            </div>
                            <div class="stat-trend">
                                <i class="fas fa-minus"></i>
                                <span>0%</span>
                            </div>
                        </div>

                        <div class="stat-card warning">
                            <div class="stat-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">
                                    {{ $trabajadores->pluck('cargo.nombre_cargo')->filter()->unique()->count() }}</div>
                                <div class="stat-label">Cargos Diferentes</div>
                            </div>
                            <div class="stat-trend">
                                <i class="fas fa-arrow-up"></i>
                                <span>5%</span>
                            </div>
                        </div>

                        <div class="stat-card info">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">
                                    {{ $trabajadores->pluck('especializacion.especializacion')->filter()->unique()->count() }}
                                </div>
                                <div class="stat-label">Especializaciones</div>
                            </div>
                            <div class="stat-trend">
                                <i class="fas fa-arrow-up"></i>
                                <span>8%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="content-card">
                        <div class="content-header">
                            <div class="content-title">
                                <h2>Lista de Trabajadores</h2>
                                <span class="record-count">{{ $trabajadores->count() }} registros</span>
                            </div>
                            <div class="content-actions">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" placeholder="Buscar trabajadores..." id="searchInput">
                                </div>
                                <button class="filter-btn">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>

                        <div class="content-body">
                            @forelse($trabajadores as $trabajador)
                                <div class="table-wrapper">
                                    @if ($loop->first)
                                        <div class="table-container">
                                            <table class="modern-table">
                                                <thead>
                                                    <tr>
                                                        <th>Trabajador</th>
                                                        <th>DNI</th>
                                                        <th>Cargo</th>
                                                        <th>Especialización</th>
                                                        <th>Turno</th>
                                                        <th>Estado</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                    @endif

                                    <tr>
                                        <td>
                                            <div class="table-user">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode(($trabajador->persona->nombres ?? 'NA') . ' ' . ($trabajador->persona->apellidos ?? '')) }}&background=6366f1&color=fff&size=40"
                                                    alt="Avatar" class="user-avatar">
                                                <div class="user-info">
                                                    <div class="user-name">{{ $trabajador->persona->nombres ?? 'N/A' }}
                                                        {{ $trabajador->persona->apellidos ?? '' }}</div>
                                                    <div class="user-email">
                                                        {{ $trabajador->persona->correo ?? 'Sin email' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="dni-badge">{{ $trabajador->dni }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="role-badge">{{ $trabajador->cargo->nombre_cargo ?? 'No asignado' }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="spec-badge">{{ $trabajador->especializacion->especializacion ?? 'No asignada' }}</span>
                                        </td>
                                        <td>
                                            @if ($trabajador->trabajador_turnos->isNotEmpty())
                                                @foreach ($trabajador->trabajador_turnos as $trabajadorTurno)
                                                    <div class="turno-info">
                                                        <span
                                                            class="turno-badge">{{ $trabajadorTurno->turno->descripcion }}</span>
                                                        <div class="horario-info">
                                                            <small>
                                                                <i class="fas fa-clock"></i>
                                                                {{ \Carbon\Carbon::parse($trabajadorTurno->turno->hora_inicio)->format('H:i') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($trabajadorTurno->turno->hora_fin)->format('H:i') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="turno-badge no-turno">Sin turno asignado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge active">Activo</span>
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="{{ route('trabajadores.edit', $trabajador->id_trabajador) }}"
                                                    class="table-btn edit" title="Editar trabajador">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="table-btn delete" title="Eliminar trabajador"
                                                    onclick="showDeleteModal({{ $trabajador->id_trabajador }}, '{{ $trabajador->persona->nombres ?? 'N/A' }} {{ $trabajador->persona->apellidos ?? '' }}', '{{ $trabajador->dni }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    @if ($loop->last)
                                        </tbody>
                                        </table>
                                </div>
                            @endif
                        </div>
                    @empty
                        <!-- Empty State -->
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>No hay trabajadores registrados</h3>
                            <p>Comienza agregando tu primer trabajador al sistema</p>
                            <a href="{{ route('trabajadores.create') }}" class="btn-modern btn-primary">
                                <i class="fas fa-plus"></i>
                                <span>Agregar Primer Trabajador</span>
                            </a>
                        </div>
                        @endforelse
                    </div>

                    @if ($trabajadores->count() > 0)
                        <div class="content-footer">
                            <div class="pagination-info">
                                Mostrando {{ $trabajadores->count() }} trabajadores
                            </div>
                            <div class="pagination-controls">
                                <!-- Pagination buttons would go here -->
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación -->
    <div class="delete-modal-overlay" id="deleteModalOverlay">
        <div class="delete-modal">
            <div class="delete-modal-header">
                <div class="delete-icon-wrapper">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="delete-title">¿Eliminar Trabajador?</h3>
                <button type="button" class="close-btn" onclick="hideDeleteModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="delete-modal-body">
                <div class="worker-info">
                    <div class="worker-avatar">
                        <img src="" alt="Avatar" id="workerAvatar">
                    </div>
                    <div class="worker-details">
                        <h4 id="workerName">Nombre del Trabajador</h4>
                        <p><strong>DNI:</strong> <span id="workerDNI">12345678</span></p>
                    </div>
                </div>

                <div class="warning-message">
                    <div class="warning-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="warning-text">
                        <p><strong>Esta acción no se puede deshacer.</strong></p>
                        <p>Se eliminarán permanentemente:</p>
                        <ul>
                            <li><i class="fas fa-user"></i> Información personal</li>
                            <li><i class="fas fa-user-circle"></i> Usuario del sistema</li>
                            <li><i class="fas fa-clock"></i> Asignaciones de turnos</li>
                            <li><i class="fas fa-briefcase"></i> Datos laborales</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="delete-modal-footer">
                <button type="button" class="btn-modern btn-secondary" onclick="hideDeleteModal()">
                    <i class="fas fa-times"></i>
                    <span>Cancelar</span>
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modern btn-danger">
                        <i class="fas fa-trash"></i>
                        <span>Eliminar Trabajador</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
