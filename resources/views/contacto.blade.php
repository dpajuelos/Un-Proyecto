<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - HPP Consultoría Minera</title>
    <link rel="icon" type="image/png" href="{{ asset('img/hpp.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/contacto.css')
    @vite('resources/css/welcome.css')
    @vite('resources/js/contacto.js')
</head>

<body>
    <!-- Barra de navegación -->
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <img src="{{ asset('img/hpp.png') }}" alt="Logo"
                        style="height:40px; vertical-align:middle; margin-right:10px;">
                    HPP <span>Consultoría Minera</span>
                </div>
                <ul class="nav-links">
                    <li><a href="/">Inicio</a></li>
                    <li><a href="/#servicios">Servicios</a></li>
                    <li><a href="/#nosotros">Nosotros</a></li>
                    <li><a href="/#proyectos">Proyectos</a></li>
                    <li><a href="/contacto" class="active">Contacto</a></li>
                    <li><a href="/login" class="login-btn">Iniciar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Formulario de Contacto -->
    <section class="form-section">
        <div class="main-container">
            <a href="/" class="back-btn">← Volver al Inicio</a>

            <h2 class="page-title">Registro de Minera y Solicitud de Cita</h2>

            @if (session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>❌ Por favor corrija los siguientes errores:</strong>
                    <ul style="margin: 10px 0 0 0; padding-left: 25px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contacto.store') }}" method="POST" id="contactForm">
                @csrf

                <div class="forms-layout">
                    <!-- Columna Izquierda: Datos de la Minera y Representante -->
                    <div class="form-container">
                        <!-- Datos de la Minera -->
                        <div class="form-section-title">🏢 Información de la Empresa Minera</div>

                        <!-- RUC como primer campo para búsqueda automática -->
                        <div class="form-group">
                            <label for="ruc">RUC de la Empresa *</label>
                            <input type="text" id="ruc" name="ruc" maxlength="11"
                                value="{{ old('ruc') }}" required placeholder="Ej: 20123456789">
                            <div class="search-status" id="rucStatus"></div>
                        </div>

                        <div class="form-group">
                            <label for="nombre_minera">Nombre de la Empresa *</label>
                            <input type="text" id="nombre_minera" name="nombre_minera"
                                value="{{ old('nombre_minera') }}" required
                                placeholder="Ingrese el nombre completo de la empresa">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="telefono_contacto">Teléfono Empresarial</label>
                                <input type="tel" id="telefono_contacto" name="telefono_contacto"
                                    value="{{ old('telefono_contacto') }}" placeholder="Ej: +51 999 888 777">
                            </div>
                            <div class="form-group">
                                <label for="correo_contacto">Correo Corporativo</label>
                                <input type="email" id="correo_contacto" name="correo_contacto"
                                    value="{{ old('correo_contacto') }}" placeholder="contacto@empresa.com">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección de la Empresa</label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}"
                                placeholder="Dirección completa de la empresa">
                        </div>

                        <!-- Datos del Representante -->
                        <div class="form-section-title">👤 Información del Representante Legal</div>

                        <!-- Selector de representante existente (solo se muestra si hay representantes) -->
                        <div class="form-group" id="representanteSelector" style="display: none;">
                            <label for="representante_existente">¿Desea usar un representante existente?</label>
                            <select id="representante_existente" name="representante_existente">
                                <option value="nuevo">Registrar nuevo representante</option>
                            </select>
                        </div>

                        <!-- Campos para nuevo representante -->
                        <div id="nuevoRepresentanteFields">
                            <div class="form-group">
                                <label for="dni">DNI del Representante *</label>
                                <input type="text" id="dni" name="dni" maxlength="8"
                                    value="{{ old('dni') }}" required placeholder="12345678">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="nombres">Nombres *</label>
                                    <input type="text" id="nombres" name="nombres" value="{{ old('nombres') }}"
                                        required placeholder="Nombres completos">
                                </div>
                                <div class="form-group">
                                    <label for="apellidos">Apellidos *</label>
                                    <input type="text" id="apellidos" name="apellidos"
                                        value="{{ old('apellidos') }}" required placeholder="Apellidos completos">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="cargo">Cargo en la Empresa *</label>
                                    <input type="text" id="cargo" name="cargo" value="{{ old('cargo') }}"
                                        required placeholder="Ej: Gerente General">
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Teléfono Personal</label>
                                    <input type="tel" id="telefono" name="telefono"
                                        value="{{ old('telefono') }}" placeholder="+51 999 888 777">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="correo">Correo Personal</label>
                                <input type="email" id="correo" name="correo" value="{{ old('correo') }}"
                                    placeholder="nombre@email.com">
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Datos de la Cita -->
                    <div class="form-container cita-container">
                        <div class="form-section-title">📅 Programación de Cita</div>

                        <div class="cita-info">
                            <h4>💼 Horarios de Atención</h4>
                            <p><strong>Lunes a Viernes:</strong> 8:00 AM - 6:00 PM<br>
                                <strong>Sábados:</strong> 9:00 AM - 1:00 PM<br>
                                <strong>Domingos:</strong> Cerrado
                            </p>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="fecha">Fecha Preferida *</label>
                                <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}"
                                    required min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="form-group">
                                <label for="hora">Horario Disponible *</label>
                                <select id="hora" name="hora" required disabled>
                                    <option value="">Primero seleccione una fecha</option>
                                </select>
                                <div class="time-warning" id="timeWarning" style="display: none;">
                                    ⚠️ Por favor seleccione una fecha válida para ver los horarios disponibles.
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Motivo de la Consulta</label>
                            <textarea id="descripcion" name="descripcion" rows="6"
                                placeholder="Describa el tipo de consultoría minera que requiere, servicios específicos, o cualquier información relevante para su cita...">{{ old('descripcion') }}</textarea>
                        </div>

                        <button type="submit" class="submit-btn" id="submitBtn">
                            📨 Solicitar Cita de Consultoría
                        </button>

                        <p
                            style="text-align: center; margin-top: 20px; font-size: 13px; color: #6c757d; line-height: 1.4;">
                            <strong>*</strong> Campos obligatorios<br>
                            Nos pondremos en contacto en un plazo máximo de 24 horas para confirmar su cita.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>

</html>
