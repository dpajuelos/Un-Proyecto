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
    <title>Detalle del Registro - Historial</title>
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
            max-width: 1200px;
            overflow: hidden;
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
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title i {
            font-size: 1.8rem;
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

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary-modern {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-danger-modern {
            background: var(--secondary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(250, 112, 154, 0.4);
        }

        .detail-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem;
            position: relative;
            overflow: hidden;
        }

        .detail-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
        }

        .info-section {
            margin-bottom: 2rem;
        }

        .info-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-value {
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .tipo-badge-modern {
            padding: 0.7rem 1.5rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: inline-block;
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

        .url-display {
            font-family: 'Fira Code', monospace;
            background: rgba(0, 0, 0, 0.3);
            color: #00ff88;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border-left: 4px solid #00ff88;
            word-break: break-all;
            font-size: 0.95rem;
            line-height: 1.5;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .url-display:hover {
            background: rgba(0, 0, 0, 0.4);
            transform: translateY(-2px);
        }

        .param-container {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .param-item {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .param-item:last-child {
            margin-bottom: 0;
        }

        .param-key {
            color: #ffd700;
            font-weight: 600;
            font-family: monospace;
        }

        .param-value {
            color: white;
            font-family: monospace;
            word-break: break-word;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .param-value:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            padding: 0.25rem;
        }

        .json-display {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            font-family: 'Fira Code', monospace;
            color: #f8f8f2;
            font-size: 0.9rem;
            line-height: 1.6;
            overflow-x: auto;
            white-space: pre-wrap;
        }

        .metadata-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .metadata-item {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .metadata-icon {
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
        }

        .metadata-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .metadata-value {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .action-buttons {
            margin: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
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

        @media (max-width: 768px) {
            .main-container {
                margin: 1rem;
                border-radius: 16px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .detail-card {
                margin: 1rem;
                padding: 1.5rem;
            }

            .metadata-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                margin: 1rem;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="main-container slide-up">
        <!-- Mostrar mensajes -->
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
                        <i class="fas fa-file-alt"></i>
                        Detalle del Registro
                    </h1>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('historial.index') }}" class="btn-modern btn-secondary-modern">
                            <i class="fas fa-arrow-left"></i>
                            Volver al Historial
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="detail-card">
            <!-- Información Básica -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="info-section">
                        <div class="info-label">
                            <i class="fas fa-tag"></i>
                            Tipo de Consulta
                        </div>
                        <div class="info-value">
                            <span class="tipo-badge-modern badge-{{ getTipoBadgeColor($registro->tipo_consulta) }}">
                                {{ ucfirst($registro->tipo_consulta) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-section">
                        <div class="info-label">
                            <i class="fas fa-clock"></i>
                            Fecha y Hora
                        </div>
                        <div class="info-value">
                            {{ $registro->created_at->format('d/m/Y H:i:s') }}
                            <small class="d-block mt-1 opacity-75">
                                ({{ $registro->created_at->diffForHumans() }})
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- URL Consultada -->
            @if (is_array($registro->detalle) && isset($registro->detalle['url']))
                <div class="info-section">
                    <div class="info-label">
                        <i class="fas fa-link"></i>
                        URL Consultada
                    </div>
                    <div class="url-display" title="Click para copiar">{{ $registro->detalle['url'] }}</div>
                </div>
            @endif

            <!-- Parámetros -->
            @if (is_array($registro->detalle) && isset($registro->detalle['parametros']) && !empty($registro->detalle['parametros']))
                <div class="info-section">
                    <div class="info-label">
                        <i class="fas fa-cogs"></i>
                        Parámetros de la Consulta
                    </div>
                    <div class="param-container">
                        @foreach ($registro->detalle['parametros'] as $key => $value)
                            <div class="param-item">
                                <span class="param-key">{{ $key }}</span>
                                <span class="param-value" title="Click para copiar">
                                    @if (is_array($value))
                                        {{ json_encode($value, JSON_PRETTY_PRINT) }}
                                    @else
                                        {{ $value }}
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Detalles Completos (JSON) -->
            @if (is_array($registro->detalle))
                <div class="info-section">
                    <div class="info-label">
                        <i class="fas fa-code"></i>
                        Detalles Completos (JSON)
                    </div>
                    <div class="json-display">
                        {{ json_encode($registro->detalle, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</div>
                </div>
            @else
                <div class="info-section">
                    <div class="info-label">
                        <i class="fas fa-info-circle"></i>
                        Detalles
                    </div>
                    <div class="info-value">{{ $registro->detalle ?? 'Sin detalles disponibles' }}</div>
                </div>
            @endif

            <!-- Metadatos -->
            <div class="metadata-grid">
                <div class="metadata-item">
                    <div class="metadata-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="metadata-label">Dirección IP</div>
                    <div class="metadata-value">{{ $registro->ip_address }}</div>
                </div>

                @if (is_array($registro->detalle) && isset($registro->detalle['metodo']))
                    <div class="metadata-item">
                        <div class="metadata-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="metadata-label">Método HTTP</div>
                        <div class="metadata-value">{{ $registro->detalle['metodo'] }}</div>
                    </div>
                @endif

                @if ($registro->user)
                    <div class="metadata-item">
                        <div class="metadata-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="metadata-label">Usuario</div>
                        <div class="metadata-value">
                            {{ $registro->user->name ?? ($registro->user->email ?? 'N/A') }}
                        </div>
                    </div>
                @endif

                <div class="metadata-item">
                    <div class="metadata-icon">
                        <i class="fas fa-hashtag"></i>
                    </div>
                    <div class="metadata-label">ID del Registro</div>
                    <div class="metadata-value">#{{ $registro->id }}</div>
                </div>

                @if (is_array($registro->detalle) && isset($registro->detalle['user_agent']))
                    <div class="metadata-item">
                        <div class="metadata-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="metadata-label">User Agent</div>
                        <div class="metadata-value" style="font-size: 0.8rem; word-break: break-word;">
                            {{ $registro->detalle['user_agent'] }}
                        </div>
                    </div>
                @endif

                @if (is_array($registro->detalle) && isset($registro->detalle['referer']))
                    <div class="metadata-item">
                        <div class="metadata-icon">
                            <i class="fas fa-external-link-alt"></i>
                        </div>
                        <div class="metadata-label">Referrer</div>
                        <div class="metadata-value" style="font-size: 0.8rem; word-break: break-word;">
                            {{ $registro->detalle['referer'] }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="action-buttons">
            <a href="{{ route('historial.index') }}" class="btn-modern btn-secondary-modern">
                <i class="fas fa-arrow-left"></i>
                Volver al Historial
            </a>

            <form method="POST" action="{{ route('historial.destroy', $registro->id) }}" style="display: inline;"
                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este registro?\n\nEsta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modern btn-danger-modern">
                    <i class="fas fa-trash"></i>
                    Eliminar Registro
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animación de entrada
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto de aparición gradual para las secciones
            const sections = document.querySelectorAll('.info-section, .metadata-item');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'all 0.6s ease';

                setTimeout(() => {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Función para copiar texto al portapapeles
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Crear notificación temporal
                const notification = document.createElement('div');
                notification.textContent = 'Copiado al portapapeles!';
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: rgba(40, 167, 69, 0.9);
                    color: white;
                    padding: 0.75rem 1.5rem;
                    border-radius: 8px;
                    z-index: 9999;
                    font-weight: 600;
                    backdrop-filter: blur(10px);
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                `;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            });
        }

        // Agregar funcionalidad de copia a elementos clickeables
        document.querySelectorAll('.url-display, .param-value').forEach(element => {
            element.addEventListener('click', function() {
                copyToClipboard(this.textContent);
            });
        });
    </script>
</body>

</html>
