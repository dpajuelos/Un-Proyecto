@extends('layouts.app')

@section('title', 'Editar Trabajador')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/trabajadores/create.css', 'resources/js/trabajadores/edit.js'])

    <div class="modern-container">
        <!-- Background Elements -->
        <div class="bg-decoration"></div>

        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <!-- Mostrar errores -->
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6><i class="fas fa-exclamation-triangle"></i> Errores de validación:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Header Section -->
                    <div class="header-section">
                        <div class="header-content">
                            <div class="header-text">
                                <div class="icon-wrapper">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <div>
                                    <h1 class="main-title">Editar Trabajador</h1>
                                    <p class="subtitle">Modifica la información de
                                        {{ $trabajador->persona->nombres ?? 'N/A' }}
                                        {{ $trabajador->persona->apellidos ?? '' }}</p>
                                </div>
                            </div>
                            <div class="header-actions">
                                <a href="{{ route('trabajadores.index') }}" class="btn-modern btn-secondary">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Volver</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="form-card">
                        <form action="{{ route('trabajadores.update', $trabajador->id_trabajador) }}" method="POST"
                            id="trabajadorForm">
                            @csrf
                            @method('PUT')

                            <!-- Información Personal -->
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-user"></i>
                                    <h3>Información Personal</h3>
                                </div>

                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="dni" class="form-label">
                                            <i class="fas fa-id-card"></i>
                                            DNI
                                        </label>
                                        <input type="text" name="dni" id="dni"
                                            class="form-control @error('dni') is-invalid @enderror"
                                            value="{{ old('dni', $trabajador->dni) }}" placeholder="Ej: 12345678" required>
                                        @error('dni')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="nombres" class="form-label">
                                            <i class="fas fa-user"></i>
                                            Nombres
                                        </label>
                                        <input type="text" name="nombres" id="nombres"
                                            class="form-control @error('nombres') is-invalid @enderror"
                                            value="{{ old('nombres', $trabajador->persona->nombres ?? '') }}"
                                            placeholder="Ej: Juan Carlos" required>
                                        @error('nombres')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="apellidos" class="form-label">
                                            <i class="fas fa-user"></i>
                                            Apellidos
                                        </label>
                                        <input type="text" name="apellidos" id="apellidos"
                                            class="form-control @error('apellidos') is-invalid @enderror"
                                            value="{{ old('apellidos', $trabajador->persona->apellidos ?? '') }}"
                                            placeholder="Ej: Pérez García" required>
                                        @error('apellidos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="telefono" class="form-label">
                                            <i class="fas fa-phone"></i>
                                            Teléfono
                                        </label>
                                        <input type="text" name="telefono" id="telefono"
                                            class="form-control @error('telefono') is-invalid @enderror"
                                            value="{{ old('telefono', $trabajador->persona->telefono ?? '') }}"
                                            placeholder="Ej: 987654321">
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="correo" class="form-label">
                                            <i class="fas fa-envelope"></i>
                                            Correo Electrónico
                                        </label>
                                        <input type="email" name="correo" id="correo"
                                            class="form-control @error('correo') is-invalid @enderror"
                                            value="{{ old('correo', $trabajador->persona->correo ?? '') }}"
                                            placeholder="Ej: juan.perez@email.com">
                                        @error('correo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Información de Usuario del Sistema -->
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-user-circle"></i>
                                    <h3>Credenciales del Sistema</h3>
                                    <span class="section-subtitle">Información de acceso al sistema</span>
                                </div>

                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="nombre_usuario" class="form-label">
                                            <i class="fas fa-user-circle"></i>
                                            Nombre de Usuario
                                        </label>
                                        <input type="text" name="nombre_usuario" id="nombre_usuario"
                                            class="form-control @error('nombre_usuario') is-invalid @enderror"
                                            value="{{ old('nombre_usuario', $trabajador->usuario->nombre_usuario ?? '') }}"
                                            placeholder="Ej: jperez" required>
                                        <small class="form-text text-muted">Debe ser único en el sistema</small>
                                        @error('nombre_usuario')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="contrasena" class="form-label">
                                            <i class="fas fa-lock"></i>
                                            Nueva Contraseña <span class="text-muted">(opcional)</span>
                                        </label>
                                        <div class="password-input-wrapper">
                                            <input type="password" name="contrasena" id="contrasena"
                                                class="form-control @error('contrasena') is-invalid @enderror"
                                                placeholder="Dejar vacío para mantener actual">
                                            <button type="button" class="password-toggle"
                                                onclick="togglePassword('contrasena')">
                                                <i class="fas fa-eye" id="contrasena-icon"></i>
                                            </button>
                                        </div>
                                        <small class="form-text text-muted">Dejar vacío para mantener la contraseña actual.
                                            Mínimo 6 caracteres si se cambia.</small>
                                        @error('contrasena')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="contrasena_confirmation" class="form-label">
                                            <i class="fas fa-lock"></i>
                                            Confirmar Nueva Contraseña
                                        </label>
                                        <div class="password-input-wrapper">
                                            <input type="password" name="contrasena_confirmation"
                                                id="contrasena_confirmation"
                                                class="form-control @error('contrasena_confirmation') is-invalid @enderror"
                                                placeholder="Confirmar nueva contraseña">
                                            <button type="button" class="password-toggle"
                                                onclick="togglePassword('contrasena_confirmation')">
                                                <i class="fas fa-eye" id="contrasena_confirmation-icon"></i>
                                            </button>
                                        </div>
                                        @error('contrasena_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Información Laboral -->
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-briefcase"></i>
                                    <h3>Información Laboral</h3>
                                </div>

                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="id_cargo" class="form-label">
                                            <i class="fas fa-user-tie"></i>
                                            Cargo
                                        </label>
                                        <select name="id_cargo" id="id_cargo"
                                            class="form-select @error('id_cargo') is-invalid @enderror" required>
                                            <option value="">Seleccionar cargo</option>
                                            @foreach ($cargos as $cargo)
                                                <option value="{{ $cargo->id_cargo }}"
                                                    {{ old('id_cargo', $trabajador->id_cargo) == $cargo->id_cargo ? 'selected' : '' }}>
                                                    {{ $cargo->nombre_cargo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_cargo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="id_espe" class="form-label">
                                            <i class="fas fa-star"></i>
                                            Especialización
                                        </label>
                                        <select name="id_espe" id="id_espe"
                                            class="form-select @error('id_espe') is-invalid @enderror" required>
                                            <option value="">Seleccionar especialización</option>
                                            @foreach ($especializaciones as $especializacion)
                                                <option value="{{ $especializacion->id_espe }}"
                                                    {{ old('id_espe', $trabajador->id_espe) == $especializacion->id_espe ? 'selected' : '' }}>
                                                    {{ $especializacion->especializacion }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_espe')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Turnos -->
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-clock"></i>
                                    <h3>Turnos de Trabajo</h3>
                                    <span class="section-subtitle">Selecciona uno o más turnos (opcional)</span>
                                </div>

                                <div class="turnos-grid">
                                    @php
                                        $turnosAsignados = $trabajador->trabajador_turnos->pluck('id_turno')->toArray();
                                    @endphp
                                    @foreach ($turnos as $turno)
                                        <div class="turno-card">
                                            <input type="checkbox" name="turnos[]" value="{{ $turno->id_turno }}"
                                                id="turno_{{ $turno->id_turno }}" class="turno-checkbox"
                                                {{ in_array($turno->id_turno, old('turnos', $turnosAsignados)) ? 'checked' : '' }}>
                                            <label for="turno_{{ $turno->id_turno }}" class="turno-label">
                                                <div class="turno-header">
                                                    <i class="fas fa-business-time"></i>
                                                    <span class="turno-name">{{ $turno->descripcion }}</span>
                                                </div>
                                                <div class="turno-time">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($turno->hora_inicio)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($turno->hora_fin)->format('H:i') }}
                                                </div>
                                                @if ($turno->tiem_aten)
                                                    <div class="turno-duration">
                                                        <i class="fas fa-hourglass-half"></i>
                                                        {{ $turno->tiem_aten }}
                                                    </div>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="form-actions">
                                <a href="{{ route('trabajadores.index') }}" class="btn-modern btn-secondary">
                                    <i class="fas fa-times"></i>
                                    <span>Cancelar</span>
                                </a>
                                <button type="submit" class="btn-modern btn-primary">
                                    <i class="fas fa-save"></i>
                                    <span>Actualizar Trabajador</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
