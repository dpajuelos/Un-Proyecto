<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        .modal_editar {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        .modal_editar.show {
            display: flex;
        }

        .modal_editar .container {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 20px;
            max-width: 600px;
            width: 95%;
            padding: 0;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.15),
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            position: relative;
            max-height: 90vh;
            overflow: hidden;
            transform: scale(0.9);
            transition: transform 0.3s ease-in-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal_editar.show .container {
            transform: scale(1);
        }

        .modal_editar .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 20px 20px 0 0;
            position: relative;
            overflow: hidden;
        }

        .modal_editar .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .modal_editar .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal_editar .modal-header h2::before {
            content: '📅';
            font-size: 1.2rem;
        }

        .modal_editar .btn-close {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .modal_editar .btn-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg) scale(1.1);
        }

        .modal_editar .modal-body {
            padding: 2rem;
            max-height: calc(90vh - 140px);
            overflow-y: auto;
        }

        .modal_editar .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal_editar .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal_editar .modal-body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
        }

        .modal_editar .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal_editar .form-control,
        .modal_editar .form-select {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .modal_editar .form-control:focus,
        .modal_editar .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .modal_editar .form-control:hover,
        .modal_editar .form-select:hover {
            border-color: #764ba2;
        }

        .modal_editar .mb-3 {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .modal_editar .representante-section {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .modal_editar .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal_editar .section-title::before {
            content: '👤';
            font-size: 1.1rem;
        }

        .modal_editar .sustituto-section {
            background: linear-gradient(135deg, #fff8f0 0%, #fff4e6 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 152, 0, 0.1);
        }

        .modal_editar .sustituto-section .section-title {
            color: #ff9800;
        }

        .modal_editar .sustituto-section .section-title::before {
            content: '👥';
        }

        .modal_editar .datetime-section {
            background: linear-gradient(135deg, #f0fff4 0%, #e8f5e8 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(76, 175, 80, 0.1);
        }

        .modal_editar .datetime-section .section-title {
            color: #4caf50;
        }

        .modal_editar .datetime-section .section-title::before {
            content: '🕐';
        }

        .modal_editar .no-sustituto {
            background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            color: #757575;
            font-style: italic;
            border: 2px dashed #e0e0e0;
        }

        .modal_editar .modal-footer {
            padding: 2px 1px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 0 0 20px 20px;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .modal_editar .btn {
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .modal_editar .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modal_editar .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .modal_editar .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
        }

        .modal_editar .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px) scale(0.9);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .modal_editar .container {
            animation: slideIn 0.4s ease-out;
        }

        /* Estilos para Modal de Visualización */
        .modal_ver {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        .modal_ver.show {
            display: flex;
        }

        .modal_ver .container {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 20px;
            max-width: 700px;
            width: 95%;
            padding: 0;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.15),
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            position: relative;
            max-height: 90vh;
            overflow: hidden;
            transform: scale(0.9);
            transition: transform 0.3s ease-in-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal_ver.show .container {
            transform: scale(1);
        }

        .modal_ver .modal-header {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 20px 20px 0 0;
            position: relative;
            overflow: hidden;
        }

        .modal_ver .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .modal_ver .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal_ver .modal-header h2::before {
            content: '👁️';
            font-size: 1.2rem;
        }

        .modal_ver .btn-close {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .modal_ver .btn-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg) scale(1.1);
        }

        .modal_ver .modal-body {
            padding: 2rem;
            max-height: calc(90vh - 140px);
            overflow-y: auto;
        }

        .modal_ver .info-card {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(102, 126, 234, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .modal_ver .info-card.minera {
            background: linear-gradient(135deg, #fff8f0 0%, #fff4e6 100%);
            border: 1px solid rgba(255, 152, 0, 0.1);
        }

        .modal_ver .info-card.horario {
            background: linear-gradient(135deg, #f0fff4 0%, #e8f5e8 100%);
            border: 1px solid rgba(76, 175, 80, 0.1);
        }

        .modal_ver .info-card.estado {
            background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
            border: 1px solid rgba(156, 39, 176, 0.1);
        }

        .modal_ver .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
            padding-bottom: 0.5rem;
        }

        .modal_ver .info-card.minera .card-title {
            color: #ff9800;
            border-bottom-color: rgba(255, 152, 0, 0.1);
        }

        .modal_ver .info-card.horario .card-title {
            color: #4caf50;
            border-bottom-color: rgba(76, 175, 80, 0.1);
        }

        .modal_ver .info-card.estado .card-title {
            color: #9c27b0;
            border-bottom-color: rgba(156, 39, 176, 0.1);
        }

        .modal_ver .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .modal_ver .info-row:last-child {
            border-bottom: none;
        }

        .modal_ver .info-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
        }

        .modal_ver .info-value {
            color: #6c757d;
            font-size: 0.95rem;
            text-align: right;
            max-width: 60%;
        }

        .modal_ver .estado-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal_ver .estado-pendiente {
            background: linear-gradient(135deg, #ffc107, #ff8f00);
            color: white;
        }

        .modal_ver .estado-confirmada {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .modal_ver .estado-cancelada {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .modal_ver .estado-reprogramada {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
        }

        .modal_ver .no-data {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            color: #6c757d;
            font-style: italic;
            border: 2px dashed #dee2e6;
        }

        .modal_ver .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 0 0 20px 20px;
            display: flex;
            gap: 1rem;
            justify-content: center;
            align-items: center;
        }

        .modal_ver .btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            padding: 0.75rem 2.5rem;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 150px;
            justify-content: center;
        }

        .modal_ver .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(23, 162, 184, 0.3);
            background: linear-gradient(135deg, #138496 0%, #117a8b 100%);
        }

        .modal_ver .btn-info:active {
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.2);
        }

        @media (max-width: 768px) {
            .modal_editar .container {
                width: 95%;
                margin: 1rem;
            }

            .modal_editar .modal-header,
            .modal_editar .modal-body,
            .modal_editar .modal-footer {
                padding: 1rem;
            }

            .modal_editar .representante-section,
            .modal_editar .sustituto-section,
            .modal_editar .datetime-section {
                padding: 1rem;
            }

            .modal_ver .container {
                width: 95%;
                margin: 1rem;
            }

            .modal_ver .modal-header,
            .modal_ver .modal-body,
            .modal_ver .modal-footer {
                padding: 1rem;
            }

            .modal_ver .info-card {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Gestión de Citas
                        </h4>

                        <!-- Botón Nueva Cita -->
                        <a href="javascript:void(0);" class="btn btn-primary" onclick="abrirModalNuevaCita()">
                            <i class="fas fa-plus me-1"></i>
                            Nueva Cita
                        </a>
                        <a href="{{ url('/home') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver
                        </a>
                    </div>

                    <div class="card-body">
                        <!-- Filtros -->
                        <form method="GET" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Estado</label>
                                    <select name="estado" class="form-select">
                                        <option value="">Todos</option>
                                        <option value="pendiente"
                                            {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="confirmada"
                                            {{ request('estado') == 'confirmada' ? 'selected' : '' }}>Confirmada
                                        </option>
                                        <option value="cancelada"
                                            {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                        <option value="reprogramada"
                                            {{ request('estado') == 'reprogramada' ? 'selected' : '' }}>Reprogramada
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Fecha</label>
                                    <input type="date" name="fecha" class="form-control"
                                        value="{{ request('fecha') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Buscar</label>
                                    <input type="text" name="buscar" class="form-control"
                                        placeholder="ID Rep o ID Rep Sus" value="{{ request('buscar') }}">
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

                        <!-- Mensajes -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Tabla de Citas -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Representante</th>
                                        <th>DNI</th>
                                        <th>Cargo</th>
                                        <th>Fecha Original</th>
                                        <th> Hora Original</th>
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
                                                @if ($cita->representantePrincipal)
                                                    {{ $cita->representantePrincipal->persona->nombres ?? '' }}
                                                    {{ $cita->representantePrincipal->persona->apellidos ?? '' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($cita->representantePrincipal)
                                                    {{ $cita->representantePrincipal->persona->dni ?? '' }}
                                                @endif
                                            </td>
                                            <td>{{ $cita->representantePrincipal->cargo ?? '' }}</td>
                                            <td>{{ $cita->fecha ? \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td>{{ $cita->hora ? \Carbon\Carbon::parse($cita->hora)->format('H:i') : '-' }}
                                            </td>
                                            <td>
                                                {{ $cita->fecha_nue ? \Carbon\Carbon::parse($cita->fecha_nue)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td>
                                                {{ $cita->hora_nue ? \Carbon\Carbon::parse($cita->hora_nue)->format('H:i') : '-' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge 
                                                    @switch($cita->estado)
                                                        @case('pendiente') bg-warning @break
                                                        @case('confirmada') bg-success @break
                                                        @case('cancelada') bg-danger @break
                                                        @case('reprogramada') bg-info @break
                                                    @endswitch
                                                ">
                                                    {{ ucfirst($cita->estado) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick="abrirModalVerCita(
                                                            {{ $cita->id_cita }},
                                                            '{{ $cita->representantePrincipal->persona->nombres ?? '' }}',
                                                            '{{ $cita->representantePrincipal->persona->apellidos ?? '' }}',
                                                            '{{ $cita->representantePrincipal->persona->dni ?? '' }}',
                                                            '{{ $cita->representantePrincipal->cargo ?? '' }}',
                                                            '{{ $cita->representantePrincipal->minera->nombre_minera ?? '' }}',
                                                            '{{ $cita->representantePrincipal->minera->ruc ?? '' }}',
                                                            '{{ $cita->representantePrincipal->minera->direccion ?? '' }}',
                                                            '{{ $cita->representantePrincipal->minera->telefono_contacto ?? '' }}',
                                                            '{{ $cita->representantePrincipal->minera->correo_contacto ?? '' }}',
                                                            '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->nombres : '' }}',
                                                            '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->apellidos : '' }}',
                                                            '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->dni : '' }}',
                                                            '{{ $cita->representanteSustituto ? $cita->representanteSustituto->cargo : '' }}',
                                                            '{{ $cita->fecha }}',
                                                            '{{ $cita->hora ? \Carbon\Carbon::parse($cita->hora)->format('H:i') : '' }}',
                                                            '{{ $cita->fecha_nue }}',
                                                            '{{ $cita->hora_nue ? \Carbon\Carbon::parse($cita->hora_nue)->format('H:i') : '' }}',
                                                            '{{ $cita->estado }}',
                                                            '{{ $cita->descripcion ?? '' }}'
                                                        )">
                                                        <i class="fas fa-eye"></i>
                                                    </button>

                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning"
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
                                                            '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->nombres : '' }}',
                                                            '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->apellidos : '' }}',
                                                            '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->dni : '' }}',
                                                            '{{ $cita->descripcion ?? '' }}',
                                                            '{{ $cita->fecha_nue ? \Carbon\Carbon::parse($cita->fecha_nue)->format('Y-m-d') : '' }}',
                                                            '{{ $cita->hora_nue ? \Carbon\Carbon::parse($cita->hora_nue)->format('H:i') : '' }}'
                                                        )">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmarEliminar({{ $cita->id_cita }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No hay citas registradas</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        {{ $citas->links() }}
                    </div>
                </div>
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
    <div class="modal_editar" id="modalEditarCita">
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
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="input_nombre_rep"
                                        name="nombre_rep" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="input_apellido_rep"
                                        name="apellido_rep" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">DNI</label>
                                    <input type="text" class="form-control" id="input_dni_rep" name="dni_rep"
                                        required>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="input_id_rep" name="id_rep">
                    </div>

                    <!-- Sección Representante Sustituto -->
                    <div id="sustitutoCampos" class="sustituto-section">
                        <div class="section-title">Representante Sustituto</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="input_nombre_sus"
                                        name="nombre_sus">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="input_apellido_sus"
                                        name="apellido_sus">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">DNI</label>
                                    <input type="text" class="form-control" id="input_dni_sus" name="dni_sus">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="input_id_rep_sus" name="id_rep_sus">
                    </div>

                    <div id="noSustituto" class="no-sustituto" style="display:none;">
                        <span>📋 No se añadió representante sustituto para esta cita</span>
                    </div>

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
    <div class="modal_editar" id="modalNuevaCita">
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
                            <label class="form-label">Seleccionar Representante</label>
                            <select class="form-select" id="nuevo_id_rep" name="id_rep" required>
                                <option value="">Seleccione un representante</option>
                                @foreach ($representantes as $rep)
                                    <option value="{{ $rep->id_rep }}">{{ $rep->persona->nombres }}
                                        {{ $rep->persona->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Sección Representante Sustituto -->
                    <div class="sustituto-section">
                        <div class="section-title">Representante Sustituto (Opcional)</div>
                        <div class="mb-3">
                            <label class="form-label">Seleccionar Sustituto</label>
                            <select class="form-select" id="nuevo_id_rep_sus" name="id_rep_sus">
                                <option value="">Ninguno</option>
                                @foreach ($representantes as $rep)
                                    <option value="{{ $rep->id_rep }}">{{ $rep->persona->nombres }}
                                        {{ $rep->persona->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Sección Fecha y Hora -->
                    <div class="datetime-section">
                        <div class="section-title">Programación</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="nuevo_fecha" name="fecha"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hora</label>
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
    <script>
        function confirmarEliminar(id) {
            document.getElementById('formEliminar').action = '/citas/' + id;
            new bootstrap.Modal(document.getElementById('modalEliminar')).show();
        }

        function abrirModalEditarCita(id_cita, id_rep, id_rep_sus, fecha, hora, estado, nombre_rep, apellido_rep, dni_rep,
            nombre_sus, apellido_sus, dni_sus, descripcion, fecha_nue, hora_nue) {

            console.log('Datos recibidos:', {
                fecha,
                hora,
                fecha_nue,
                hora_nue
            }); // Para debugging

            // Información básica
            document.getElementById('input_id_rep').value = id_rep;
            document.getElementById('input_nombre_rep').value = nombre_rep || '';
            document.getElementById('input_apellido_rep').value = apellido_rep || '';
            document.getElementById('input_dni_rep').value = dni_rep || '';
            document.getElementById('input_id_rep_sus').value = id_rep_sus || '';
            document.getElementById('input_estado').value = estado;
            document.getElementById('input_descripcion').value = descripcion || '';

            // Fechas y horas originales (readonly)
            document.getElementById('input_fecha_original').value = fecha || '';
            document.getElementById('input_hora_original').value = hora || '';

            // Fechas y horas nuevas (editables)
            document.getElementById('input_fecha_nueva').value = fecha_nue || '';
            document.getElementById('input_hora_nueva').value = hora_nue || '';

            // Configurar fecha mínima para la nueva fecha
            if (fecha) {
                // Añadir un día a la fecha original para que sea posterior
                const fechaOriginal = new Date(fecha);
                fechaOriginal.setDate(fechaOriginal.getDate() + 1);
                const fechaMinima = fechaOriginal.toISOString().split('T')[0];
                document.getElementById('input_fecha_nueva').min = fechaMinima;
            }

            // Remover event listeners anteriores y añadir nuevo
            const inputFechaNueva = document.getElementById('input_fecha_nueva');
            inputFechaNueva.removeEventListener('change', validarFechaNueva);
            inputFechaNueva.addEventListener('change', validarFechaNueva);

            // Configurar acción del formulario
            document.getElementById('formEditarCita').action = '/citas/' + id_cita;

            // Manejo del representante sustituto
            if (id_rep_sus && id_rep_sus !== 'null') {
                document.getElementById('sustitutoCampos').style.display = '';
                document.getElementById('noSustituto').style.display = 'none';
                document.getElementById('input_nombre_sus').value = nombre_sus || '';
                document.getElementById('input_apellido_sus').value = apellido_sus || '';
                document.getElementById('input_dni_sus').value = dni_sus || '';
            } else {
                document.getElementById('sustitutoCampos').style.display = 'none';
                document.getElementById('noSustituto').style.display = '';
                document.getElementById('input_nombre_sus').value = '';
                document.getElementById('input_apellido_sus').value = '';
                document.getElementById('input_dni_sus').value = '';
            }

            document.getElementById('modalEditarCita').classList.add('show');
        }

        // Función separada para validar fecha nueva
        function validarFechaNueva() {
            const fechaOriginal = document.getElementById('input_fecha_original').value;
            const fechaNueva = this.value;

            if (fechaNueva && fechaOriginal && fechaNueva <= fechaOriginal) {
                alert('La nueva fecha debe ser posterior a la fecha original (' +
                    new Date(fechaOriginal).toLocaleDateString('es-ES') + ')');
                this.value = '';
            }
        }

        function limpiarFechasNuevas() {
            document.getElementById('input_fecha_nueva').value = '';
            document.getElementById('input_hora_nueva').value = '';
        }

        function cerrarModalEditarCita() {
            document.getElementById('modalEditarCita').classList.remove('show');
        }

        function abrirModalNuevaCita() {
            document.getElementById('formNuevaCita').reset();
            document.getElementById('nuevo_descripcion').value = '';
            document.getElementById('modalNuevaCita').classList.add('show');
        }

        function cerrarModalNuevaCita() {
            document.getElementById('modalNuevaCita').classList.remove('show');
        }

        function abrirModalVerCita(id_cita, nombre_rep, apellido_rep, dni_rep, cargo_rep,
            nombre_minera, ruc_minera, direccion_minera, telefono_minera, correo_minera,
            nombre_sus, apellido_sus, dni_sus, cargo_sus,
            fecha, hora, fecha_nue, hora_nue, estado, descripcion) {

            // Información del representante principal
            document.getElementById('ver_nombre_rep').textContent = `${nombre_rep} ${apellido_rep}`;
            document.getElementById('ver_dni_rep').textContent = dni_rep || 'No especificado';
            document.getElementById('ver_cargo_rep').textContent = cargo_rep || 'No especificado';

            // Información de la minera
            document.getElementById('ver_nombre_minera').textContent = nombre_minera || 'No especificado';
            document.getElementById('ver_ruc_minera').textContent = ruc_minera || 'No especificado';
            document.getElementById('ver_direccion_minera').textContent = direccion_minera || 'No especificado';
            document.getElementById('ver_telefono_minera').textContent = telefono_minera || 'No especificado';
            document.getElementById('ver_correo_minera').textContent = correo_minera || 'No especificado';

            // Información del representante sustituto
            if (nombre_sus && apellido_sus) {
                document.getElementById('ver_sustituto_card').style.display = 'block';
                document.getElementById('ver_no_sustituto').style.display = 'none';
                document.getElementById('ver_nombre_sus').textContent = `${nombre_sus} ${apellido_sus}`;
                document.getElementById('ver_dni_sus').textContent = dni_sus || 'No especificado';
                document.getElementById('ver_cargo_sus').textContent = cargo_sus || 'No especificado';
            } else {
                document.getElementById('ver_sustituto_card').style.display = 'none';
                document.getElementById('ver_no_sustituto').style.display = 'block';
            }

            // Información de fechas y horas
            if (fecha && fecha !== 'null') {
                const fechaFormateada = new Date(fecha).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                document.getElementById('ver_fecha_original').textContent = fechaFormateada;
            } else {
                document.getElementById('ver_fecha_original').textContent = 'No especificado';
            }

            document.getElementById('ver_hora_original').textContent = hora || 'No especificado';

            // Fechas y horas nuevas (si existen)
            if (fecha_nue && fecha_nue !== 'null' && fecha_nue !== '') {
                document.getElementById('ver_fecha_nueva_row').style.display = 'flex';
                const fechaNuevaFormateada = new Date(fecha_nue).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                document.getElementById('ver_fecha_nueva').textContent = fechaNuevaFormateada;
            } else {
                document.getElementById('ver_fecha_nueva_row').style.display = 'none';
            }

            if (hora_nue && hora_nue !== 'null' && hora_nue !== '') {
                document.getElementById('ver_hora_nueva_row').style.display = 'flex';
                document.getElementById('ver_hora_nueva').textContent = hora_nue;
            } else {
                document.getElementById('ver_hora_nueva_row').style.display = 'none';
            }

            // Descripción
            document.getElementById('ver_descripcion').textContent = descripcion ||
                'No se añadió descripción para esta cita';

            // Estado de la cita
            const estadoBadge = document.getElementById('ver_estado_badge');
            estadoBadge.textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
            estadoBadge.className = `estado-badge estado-${estado}`;

            // Mostrar modal
            document.getElementById('modalVerCita').classList.add('show');
        }

        function cerrarModalVerCita() {
            document.getElementById('modalVerCita').classList.remove('show');
        }
    </script>


</body>

</html>
