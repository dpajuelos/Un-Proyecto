@extends('layouts.app')

@section('content')
<link rel="icon" type="image/png" href="{{ asset('img/hpp.png') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="{{ asset('img/hpp.png') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
  
<style>
    :root {
        --primary-color: #667eea;
        --primary-dark: #5a67d8;
        --secondary-color: #764ba2;
        --success-color: #48bb78;
        --danger-color: #f56565;
        --warning-color: #ed8936;
        --info-color: #4299e1;
        --dark-color: #2d3748;
        --light-color: #37a6f1;
        --border-color: #000000;
        --text-muted: #365076;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.15);
        --border-radius: 12px;
        --border-radius-sm: 8px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Main Container */
    .mineras-container {
        max-width: 1400px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .mineras-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .mineras-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .mineras-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Action Bar */
    .action-bar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .search-container {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        font-size: 1rem;
        transition: var(--transition);
        background: white;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .filter-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: var(--border-radius-sm);
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        filter: brightness(1.1);
    }

    .btn-secondary {
        background: var(--light-color);
        color: var(--dark-color);
        border: 2px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--border-color);
        transform: translateY(-1px);
    }

    .btn-success {
        background: var(--success-color);
        color: white;
    }

    .btn-danger {
        background: var(--danger-color);
        color: white;
    }

    .btn-info {
        background: var(--info-color);
        color: white;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }

    /* Table Styles */
    .table-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .table-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .table-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    th, td {
        padding: 1rem 1.5rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    th {
        background: var(--light-color);
        font-weight: 600;
        color: var(--dark-color);
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    tbody tr {
        background: white;
        transition: var(--transition);
    }

    tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.001);
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    /* Action Buttons */
    .actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.5rem 0.75rem;
        border-radius: var(--border-radius-sm);
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-edit {
        background: var(--info-color);
        color: white;
    }

    .btn-edit:hover {
        background: #3182ce;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: var(--danger-color);
        color: white;
    }

    .btn-delete:hover {
        background: #e53e3e;
        transform: translateY(-1px);
    }

    .btn-save {
        background: var(--success-color);
        color: white;
    }

    .btn-cancel {
        background: var(--text-muted);
        color: white;
    }

    /* Cards for Mobile */
    .mineras-cards {
        display: none;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .minera-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .minera-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .minera-card h3 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .minera-card p {
        margin-bottom: 0.5rem;
        color: var(--dark-color);
    }

    .minera-card strong {
        color: var(--text-muted);
        font-weight: 500;
    }

    .card-buttons {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-xl);
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(20px) scale(0.95);
        transition: transform 0.3s ease;
    }

    .modal-overlay.active .modal-container {
        transform: translateY(0) scale(1);
    }

    .modal-header {
        padding: 2rem;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .modal-title {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .modal-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        cursor: pointer;
        color: rgb(0, 0, 0);
        transition: var(--transition);
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .modal-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--dark-color);
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        font-size: 1rem;
        transition: var(--transition);
        background: rgb(0, 0, 0);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .modal-footer {
        padding: 1.5rem 2rem 2rem;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        margin-bottom: 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
        opacity: 0.7;
    }

    .empty-state h3 {
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
    }

    .empty-state p {
        color: var(--text-muted);
        margin-bottom: 2rem;
    }

    /* Loading States */
    .loading {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .mineras-container {
            padding: 0 0.5rem;
            margin: 1rem auto;
        }

        .mineras-header {
            padding: 1.5rem;
        }

        .mineras-title {
            font-size: 2rem;
        }

        .action-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-container {
            max-width: none;
        }

        .filter-buttons {
            justify-content: center;
        }

        .table-container {
            display: none;
        }

        .mineras-cards {
            display: grid;
        }

        .modal-container {
            width: 95%;
            margin: 1rem;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }
    }
</style>

<div class="mineras-container">
    <!-- Header -->
    <div class="mineras-header fade-in">
        <h1 class="mineras-title">
            <i class="fas fa-industry"></i>
            Gestión de Mineras
        </h1>
        <p class="mineras-subtitle">
            Administra y controla todas las empresas mineras del sistema
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: white;">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-number">{{ $mineras->count() }}</div>
            <div class="stat-label">Total Mineras</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, var(--success-color), #38a169); color: white;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-number">{{ $mineras->count() }}</div>
            <div class="stat-label">Activas</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, var(--info-color), #3182ce); color: white;">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div class="stat-number">{{ $mineras->where('created_at', '>=', now()->subMonth())->count() }}</div>
            <div class="stat-label">Este Mes</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, var(--warning-color), #dd6b20); color: white;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-number">100%</div>
            <div class="stat-label">Operativas</div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="action-bar fade-in">
        <div class="search-container">
            <input type="text" class="search-input" id="search-mineras" placeholder="Buscar mineras...">
            <i class="fas fa-search search-icon"></i>
        </div>
        <div class="filter-buttons">
            <button class="btn btn-secondary btn-sm" id="filter-all">
                <i class="fas fa-list"></i> Todas
            </button>
            <button class="btn btn-secondary btn-sm" id="export-excel">
                <i class="fas fa-file-excel"></i> Exportar
            </button>
            <button id="open-modal" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Minera
            </button>
        </div>
    </div>

    @if($mineras->isEmpty())
        <div class="empty-state fade-in">
            <i class="fas fa-industry"></i>
            <h3>No hay mineras registradas</h3>
            <p>Comienza agregando tu primera empresa minera al sistema</p>
            <button id="open-modal-empty" class="btn btn-primary">
                <i class="fas fa-plus"></i> Agregar Primera Minera
            </button>
        </div>
    @else
        <!-- Table View -->
        <div class="table-container fade-in">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-table"></i>
                    Listado de Mineras
                </h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <i class="fas fa-hashtag"></i> ID
                            </th>
                            <th>
                                <i class="fas fa-building"></i> Nombre
                            </th>
                            <th>
                                <i class="fas fa-id-card"></i> RUC
                            </th>
                            <th>
                                <i class="fas fa-map-marker-alt"></i> Dirección
                            </th>
                            <th>
                                <i class="fas fa-phone"></i> Teléfono
                            </th>
                            <th>
                                <i class="fas fa-envelope"></i> Correo
                            </th>
                            <th>
                                <i class="fas fa-cogs"></i> Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody id="mineras-tbody">
                        @foreach($mineras as $minera)
                        <tr data-id="{{ $minera->id_minera }}" class="minera-row">
                            @if(request('edit_id') == $minera->id_minera)
                                <td>{{ $minera->id_minera }}</td>
                                <td>
                                    <input type="text" class="form-control" name="nombre_minera" value="{{ $minera->nombre_minera }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="ruc" value="{{ $minera->ruc }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="direccion" value="{{ $minera->direccion }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="telefono_contacto" value="{{ $minera->telefono_contacto }}" required>
                                </td>
                                <td>
                                    <input type="email" class="form-control" name="correo_contacto" value="{{ $minera->correo_contacto }}" required>
                                </td>
                                <td class="actions">
                                    <button type="button" class="btn-action btn-save btn-guardar" data-id="{{ $minera->id_minera }}">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                    <a href="{{ route('mineras.index') }}" class="btn-action btn-cancel">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                </td>
                            @else
                                <td>
                                    <span class="tooltip" data-tooltip="ID único: {{ $minera->id_minera }}">
                                        {{ $minera->id_minera }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $minera->nombre_minera }}</strong>
                                </td>
                                <td>
                                    <code>{{ $minera->ruc }}</code>
                                </td>
                                <td>{{ $minera->direccion }}</td>
                                <td>
                                    <a href="tel:{{ $minera->telefono_contacto }}" class="tooltip" data-tooltip="Llamar">
                                        {{ $minera->telefono_contacto }}
                                    </a>
                                </td>
                                <td>
                                    <a href="mailto:{{ $minera->correo_contacto }}" class="tooltip" data-tooltip="Enviar email">
                                        {{ $minera->correo_contacto }}
                                    </a>
                                </td>
                                <td class="actions">
                                    <a href="{{ route('mineras.index', ['edit_id' => $minera->id_minera]) }}" 
                                       class="btn-action btn-edit tooltip" data-tooltip="Editar minera">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('mineras.destroy', $minera->id_minera) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete tooltip" 
                                                data-tooltip="Eliminar minera"
                                                onclick="return confirm('¿Estás seguro de eliminar esta minera?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Cards -->
        <div class="mineras-cards">
            @foreach($mineras as $minera)
            <div class="minera-card minera-card-mobile" data-name="{{ strtolower($minera->nombre_minera) }}" data-ruc="{{ $minera->ruc }}">
                <h3>{{ $minera->nombre_minera }}</h3>
                <p><strong>ID:</strong> {{ $minera->id_minera }}</p>
                <p><strong>RUC:</strong> <code>{{ $minera->ruc }}</code></p>
                <p><strong>Dirección:</strong> {{ $minera->direccion }}</p>
                <p><strong>Teléfono:</strong> 
                    <a href="tel:{{ $minera->telefono_contacto }}">{{ $minera->telefono_contacto }}</a>
                </p>
                <p><strong>Correo:</strong> 
                    <a href="mailto:{{ $minera->correo_contacto }}">{{ $minera->correo_contacto }}</a>
                </p>
                <div class="card-buttons">
                    <a href="{{ route('mineras.index', ['edit_id' => $minera->id_minera]) }}" class="btn-action btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('mineras.destroy', $minera->id_minera) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('¿Estás seguro de eliminar esta minera?')">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ url('/home') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al Inicio
        </a>
    </div>
</div>

<!-- Modal para crear nueva minera -->
<div class="modal-overlay" id="create-modal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-plus-circle"></i>
                Nueva Minera
            </h3>
            <button class="modal-close" id="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="create-minera-form">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="nombre_minera" class="form-label">
                        <i class="fas fa-building"></i> Nombre de la Minera
                    </label>
                    <input type="text" class="form-control" id="nombre_minera" name="nombre_minera" 
                           placeholder="Ej: Minera San Rafael S.A.C." required>
                </div>
                <div class="form-group">
                    <label for="ruc" class="form-label">
                        <i class="fas fa-id-card"></i> RUC
                    </label>
                    <input type="text" class="form-control" id="ruc" name="ruc" 
                           placeholder="Ej: 20123456789" maxlength="11" required>
                </div>
                <div class="form-group">
                    <label for="direccion" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Dirección
                    </label>
                    <input type="text" class="form-control" id="direccion" name="direccion" 
                           placeholder="Ej: Av. Principal 123, Lima" required>
                </div>
                <div class="form-group">
                    <label for="telefono_contacto" class="form-label">
                        <i class="fas fa-phone"></i> Teléfono de Contacto
                    </label>
                    <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" 
                           placeholder="Ej: +51 123 456 789" required>
                </div>
                <div class="form-group">
                    <label for="correo_contacto" class="form-label">
                        <i class="fas fa-envelope"></i> Correo de Contacto
                    </label>
                    <input type="email" class="form-control" id="correo_contacto" name="correo_contacto" 
                           placeholder="Ej: contacto@minera.com" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancel-modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-primary" id="submit-btn">
                    <i class="fas fa-save"></i> Guardar Minera
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Success/Error Messages -->
<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 10000;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Initialize tooltips and animations
    initializeAnimations();
    
    // Modal handling
    const modal = $('#create-modal');
    const openModalBtns = $('#open-modal, #open-modal-empty');
    const closeModalBtns = $('#close-modal, #cancel-modal');

    openModalBtns.on('click', function() {
        modal.addClass('active');
        $('#nombre_minera').focus();
    });

    closeModalBtns.on('click', function() {
        modal.removeClass('active');
        resetForm();
    });

    // Close modal when clicking outside
    modal.on('click', function(e) {
        if (e.target === modal[0]) {
            modal.removeClass('active');
            resetForm();
        }
    });

    // Close modal with Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && modal.hasClass('active')) {
            modal.removeClass('active');
            resetForm();
        }
    });

    // Search functionality
    $('#search-mineras').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterMineras(searchTerm);
    });

    // Filter buttons
    $('#filter-all').on('click', function() {
        $('.minera-row, .minera-card-mobile').show();
        updateActiveFilter($(this));
    });

    // Export functionality
    $('#export-excel').on('click', function() {
        exportToExcel();
    });

    // Form submission with enhanced validation
    $('#create-minera-form').on('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }
        
        const form = $(this);
        const formData = form.serialize();
        const submitBtn = $('#submit-btn');
        
        $.ajax({
            url: "{{ route('mineras.store') }}",
            type: 'POST',
            data: formData,
            beforeSend: function() {
                submitBtn.prop('disabled', true)
                    .html('<div class="loading"></div> Guardando...');
            },
            success: function(response) {
                modal.removeClass('active');
                resetForm();
                
                showToast('success', '¡Éxito!', 'Minera creada correctamente');
                
                // Add new row with animation
                setTimeout(() => {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorMessages = [];
                    $.each(errors, function(key, value) {
                        errorMessages.push(value.join('<br>'));
                    });
                    showToast('error', 'Error de validación', errorMessages.join('<br>'));
                } else {
                    showToast('error', 'Error', 'No se pudo crear la minera');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false)
                    .html('<i class="fas fa-save"></i> Guardar Minera');
            }
        });
    });

    // Enhanced edit functionality
    $('.btn-guardar').on('click', function() {
        const $row = $(this).closest('tr');
        const id = $(this).data('id');
        const $button = $(this);
        
        // Validate required fields
        const requiredFields = ['nombre_minera', 'ruc', 'direccion', 'telefono_contacto', 'correo_contacto'];
        let isValid = true;
        
        requiredFields.forEach(field => {
            const $input = $row.find(`input[name="${field}"]`);
            if (!$input.val().trim()) {
                $input.addClass('error');
                isValid = false;
            } else {
                $input.removeClass('error');
            }
        });
        
        if (!isValid) {
            showToast('error', 'Error', 'Todos los campos son obligatorios');
            return;
        }
        
        // Validate email format
        const email = $row.find('input[name="correo_contacto"]').val();
        if (!isValidEmail(email)) {
            showToast('error', 'Error', 'El formato del correo no es válido');
            return;
        }
        
        // Validate RUC format (Peru RUC has 11 digits)
        const ruc = $row.find('input[name="ruc"]').val();
        if (!/^\d{11}$/.test(ruc)) {
            showToast('error', 'Error', 'El RUC debe tener 11 dígitos');
            return;
        }
        
        const data = {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',
            nombre_minera: $row.find('input[name="nombre_minera"]').val().trim(),
            ruc: ruc,
            direccion: $row.find('input[name="direccion"]').val().trim(),
            telefono_contacto: $row.find('input[name="telefono_contacto"]').val().trim(),
            correo_contacto: email
        };

        $.ajax({
            url: '/mineras/' + id,
            type: 'POST',
            data: data,
            beforeSend: function() {
                $button.prop('disabled', true)
                    .html('<div class="loading"></div> Guardando...');
            },
            success: function(response) {
                showToast('success', '¡Éxito!', 'Cambios guardados correctamente');
                
                setTimeout(() => {
                    location.href = "{{ route('mineras.index') }}";
                }, 1500);
            },
            error: function(xhr) {
                let message = 'Hubo un problema al actualizar la minera';
                if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }
                showToast('error', 'Error', message);
                
                $button.prop('disabled', false)
                    .html('<i class="fas fa-save"></i> Guardar');
            }
        });
    });

    // Enhanced input validation
    $('#ruc').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 11) value = value.substring(0, 11);
        $(this).val(value);
    });

    $('#telefono_contacto').on('input', function() {
        let value = $(this).val().replace(/[^\d\s\+\-\(\)]/g, '');
        $(this).val(value);
    });

    // Real-time form validation
    $('#create-minera-form input').on('blur', function() {
        validateField($(this));
    });

    // Functions
    function initializeAnimations() {
        // Staggered animation for table rows
        $('.minera-row').each(function(index) {
            $(this).css('animation-delay', (index * 0.1) + 's');
        });
        
        // Fade in cards
        $('.minera-card').each(function(index) {
            $(this).css('animation-delay', (index * 0.15) + 's');
            $(this).addClass('fade-in');
        });
    }

    function filterMineras(searchTerm) {
        $('.minera-row').each(function() {
            const $row = $(this);
            const name = $row.find('td:nth-child(2)').text().toLowerCase();
            const ruc = $row.find('td:nth-child(3)').text().toLowerCase();
            const address = $row.find('td:nth-child(4)').text().toLowerCase();
            
            if (name.includes(searchTerm) || ruc.includes(searchTerm) || address.includes(searchTerm)) {
                $row.show();
            } else {
                $row.hide();
            }
        });
        
        $('.minera-card-mobile').each(function() {
            const $card = $(this);
            const name = $card.data('name') || '';
            const ruc = $card.data('ruc') || '';
            
            if (name.includes(searchTerm) || ruc.includes(searchTerm)) {
                $card.show();
            } else {
                $card.hide();
            }
        });
    }

    function updateActiveFilter($activeBtn) {
        $('.filter-buttons .btn').removeClass('btn-primary').addClass('btn-secondary');
        $activeBtn.removeClass('btn-secondary').addClass('btn-primary');
    }

    function validateForm() {
        let isValid = true;
        const form = $('#create-minera-form');
        
        // Reset previous errors
        form.find('.form-control').removeClass('error');
        
        // Validate required fields
        form.find('input[required]').each(function() {
            if (!$(this).val().trim()) {
                $(this).addClass('error');
                isValid = false;
            }
        });
        
        // Validate email
        const email = $('#correo_contacto').val();
        if (email && !isValidEmail(email)) {
            $('#correo_contacto').addClass('error');
            isValid = false;
        }
        
        // Validate RUC
        const ruc = $('#ruc').val();
        if (ruc && !/^\d{11}$/.test(ruc)) {
            $('#ruc').addClass('error');
            isValid = false;
        }
        
        if (!isValid) {
            showToast('error', 'Error', 'Por favor, complete todos los campos correctamente');
        }
        
        return isValid;
    }

    function validateField($field) {
        const fieldName = $field.attr('name');
        const value = $field.val().trim();
        
        $field.removeClass('error');
        
        if ($field.attr('required') && !value) {
            $field.addClass('error');
            return false;
        }
        
        if (fieldName === 'correo_contacto' && value && !isValidEmail(value)) {
            $field.addClass('error');
            return false;
        }
        
        if (fieldName === 'ruc' && value && !/^\d{11}$/.test(value)) {
            $field.addClass('error');
            return false;
        }
        
        return true;
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function resetForm() {
        const form = $('#create-minera-form');
        form[0].reset();
        form.find('.form-control').removeClass('error');
    }

    function showToast(type, title, message) {
        const toast = $(`
            <div class="toast toast-${type}" style="
                background: ${type === 'success' ? 'var(--success-color)' : 'var(--danger-color)'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: var(--border-radius-sm);
                margin-bottom: 1rem;
                box-shadow: var(--shadow-lg);
                transform: translateX(100%);
                transition: var(--transition);
                max-width: 400px;
            ">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    <div>
                        <div style="font-weight: 600; margin-bottom: 0.25rem;">${title}</div>
                        <div style="font-size: 0.9rem; opacity: 0.9;">${message}</div>
                    </div>
                    <button onclick="$(this).parent().parent().remove()" style="
                        background: none;
                        border: none;
                        color: white;
                        font-size: 1.2rem;
                        cursor: pointer;
                        opacity: 0.7;
                        margin-left: auto;
                    ">×</button>
                </div>
            </div>
        `);
        
        $('#toast-container').append(toast);
        
        setTimeout(() => {
            toast.css('transform', 'translateX(0)');
        }, 100);
        
        setTimeout(() => {
            toast.css('transform', 'translateX(100%)');
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    function exportToExcel() {
        // Simple CSV export functionality
        let csv = 'ID,Nombre,RUC,Dirección,Teléfono,Correo\n';
        
        $('.minera-row').each(function() {
            const $row = $(this);
            const cols = [];
            $row.find('td').not(':last').each(function(index) {
                if (index < 6) { // Only first 6 columns
                    let text = $(this).text().trim();
                    if (text.includes(',')) text = `"${text}"`;
                    cols.push(text);
                }
            });
            if (cols.length === 6) {
                csv += cols.join(',') + '\n';
            }
        });
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'mineras_' + new Date().toISOString().split('T')[0] + '.csv';
        a.click();
        window.URL.revokeObjectURL(url);
        
        showToast('success', 'Exportado', 'Archivo descargado correctamente');
    }

    // Add error styles
    $('<style>').text(`
        .form-control.error {
            border-color: var(--danger-color) !important;
            box-shadow: 0 0 0 3px rgba(245, 101, 101, 0.2) !important;
        }
        
        .fade-in {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    `).appendTo('head');
});
</script>
@endsection