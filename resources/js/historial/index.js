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

// El DOMContentLoaded solo para código que necesite esperar a que cargue el DOM
document.addEventListener('DOMContentLoaded', function () {
    // Aquí puedes agregar código que necesite que el DOM esté listo
    console.log('Historial JS cargado correctamente');
});