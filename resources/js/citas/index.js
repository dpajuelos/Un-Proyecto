document.addEventListener('DOMContentLoaded', function () {

    function confirmarEliminar(id) {
        document.getElementById('formEliminar').action = '/citas/' + id;
        new bootstrap.Modal(document.getElementById('modalEliminar')).show();
    }

    function toggleNuevoSustituto() {
        const checkbox = document.getElementById('nuevo_checkbox_sustituto');
        const sustitutoCampos = document.getElementById('nuevoSustitutoCampos');
        const noSustituto = document.getElementById('nuevoNoSustituto');

        if (checkbox.checked) {
            sustitutoCampos.style.display = 'block';
            noSustituto.style.display = 'none';

            // Hacer requeridos los campos
            document.getElementById('nuevo_nombre_sus').required = true;
            document.getElementById('nuevo_apellido_sus').required = true;
            document.getElementById('nuevo_dni_sus').required = true;
            document.getElementById('nuevo_cargo_sus').required = true;
        } else {
            sustitutoCampos.style.display = 'none';
            noSustituto.style.display = 'block';

            // Quitar requeridos y limpiar campos
            document.getElementById('nuevo_nombre_sus').required = false;
            document.getElementById('nuevo_apellido_sus').required = false;
            document.getElementById('nuevo_dni_sus').required = false;
            document.getElementById('nuevo_cargo_sus').required = false;

            // Limpiar campos
            document.getElementById('nuevo_nombre_sus').value = '';
            document.getElementById('nuevo_apellido_sus').value = '';
            document.getElementById('nuevo_dni_sus').value = '';
            document.getElementById('nuevo_cargo_sus').value = '';
            document.getElementById('nuevo_telefono_sus').value = '';
            document.getElementById('nuevo_correo_sus').value = '';
        }
    }

    // Variable para controlar el timeout de búsqueda
    let searchTimeout;

    // Función para buscar persona por DNI
    function buscarPersonaPorDni(dni, tipo) {
        // Limpiar timeout anterior
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        const dniInput = document.getElementById(`input_dni_${tipo}`);
        const statusIcon = document.getElementById(`dni_${tipo}_status`);
        const message = document.getElementById(`dni_${tipo}_message`);
        const statusAlert = document.getElementById(`persona_${tipo}_status`);
        const statusMessage = document.getElementById(`persona_${tipo}_message`);

        // Limpiar clases y mensajes
        dniInput.classList.remove('dni-found', 'dni-not-found', 'dni-error');
        statusAlert.style.display = 'none';

        // Si el DNI está vacío, resetear todo
        if (!dni || dni.length < 8) {
            statusIcon.innerHTML = '<i class="fas fa-search text-muted"></i>';
            message.textContent = '';
            limpiarCamposPersona(tipo);
            habilitarCamposPersona(tipo);
            return;
        }

        // Mostrar spinner de carga
        statusIcon.innerHTML = '<i class="fas fa-spinner fa-spin text-primary"></i>';
        message.textContent = 'Buscando...';
        message.className = 'form-text text-muted';

        // Realizar búsqueda con delay
        searchTimeout = setTimeout(async () => {
            try {
                const response = await fetch('/api/search-persona', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ dni: dni })
                });

                const data = await response.json();

                if (data.success && data.persona) {
                    // Persona encontrada
                    dniInput.classList.add('dni-found');
                    statusIcon.innerHTML = '<i class="fas fa-check-circle text-success"></i>';
                    message.textContent = 'Persona encontrada';
                    message.className = 'form-text text-success';

                    // Autocompletar campos
                    document.getElementById(`input_nombre_${tipo}`).value = data.persona.nombres || '';
                    document.getElementById(`input_apellido_${tipo}`).value = data.persona.apellidos || '';
                    document.getElementById(`input_telefono_${tipo}`).value = data.persona.telefono || '';
                    document.getElementById(`input_correo_${tipo}`).value = data.persona.correo || '';

                    // Mantener campos editables para permitir actualizaciones
                    habilitarCamposPersona(tipo);

                    // Mostrar mensaje de éxito
                    statusAlert.className = 'alert alert-success';
                    statusMessage.textContent = 'Persona encontrada en el sistema. Puede editar los datos si es necesario.';
                    statusAlert.style.display = 'block';

                } else {
                    // Persona no encontrada
                    dniInput.classList.add('dni-not-found');
                    statusIcon.innerHTML = '<i class="fas fa-user-plus text-warning"></i>';
                    message.textContent = 'Registro nuevo';
                    message.className = 'form-text text-warning';

                    // Limpiar campos para nuevo registro
                    limpiarCamposPersona(tipo);
                    habilitarCamposPersona(tipo);

                    // Mostrar mensaje de nuevo registro
                    statusAlert.className = 'alert alert-warning';
                    statusMessage.textContent = 'DNI no encontrado. Se creará un nuevo registro con los datos que ingrese.';
                    statusAlert.style.display = 'block';
                }

            } catch (error) {
                console.error('Error al buscar persona:', error);
                dniInput.classList.add('dni-error');
                statusIcon.innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i>';
                message.textContent = 'Error en la búsqueda';
                message.className = 'form-text text-danger';

                // Mostrar mensaje de error
                statusAlert.className = 'alert alert-danger';
                statusMessage.textContent = 'Error al buscar en el sistema. Intente nuevamente.';
                statusAlert.style.display = 'block';
            }
        }, 500); // Delay de 500ms
    }

    // Función para limpiar campos de persona
    function limpiarCamposPersona(tipo) {
        document.getElementById(`input_nombre_${tipo}`).value = '';
        document.getElementById(`input_apellido_${tipo}`).value = '';
        document.getElementById(`input_telefono_${tipo}`).value = '';
        document.getElementById(`input_correo_${tipo}`).value = '';
    }

    // Función para habilitar campos de persona
    function habilitarCamposPersona(tipo) {
        document.getElementById(`input_nombre_${tipo}`).readOnly = false;
        document.getElementById(`input_apellido_${tipo}`).readOnly = false;
        document.getElementById(`input_telefono_${tipo}`).readOnly = false;
        document.getElementById(`input_correo_${tipo}`).readOnly = false;
    }

    function toggleSustituto() {
        const checkbox = document.getElementById('checkbox_sustituto');
        const sustitutoCampos = document.getElementById('sustitutoCampos');
        const noSustituto = document.getElementById('noSustituto');

        if (checkbox.checked) {
            sustitutoCampos.style.display = 'block';
            noSustituto.style.display = 'none';

            // Hacer requeridos los campos
            document.getElementById('input_nombre_sus').required = true;
            document.getElementById('input_apellido_sus').required = true;
            document.getElementById('input_dni_sus').required = true;
            document.getElementById('input_cargo_sus').required = true;
        } else {
            sustitutoCampos.style.display = 'none';
            noSustituto.style.display = 'block';

            // Quitar requeridos y limpiar campos
            document.getElementById('input_nombre_sus').required = false;
            document.getElementById('input_apellido_sus').required = false;
            document.getElementById('input_dni_sus').required = false;
            document.getElementById('input_cargo_sus').required = false;

            // Limpiar todos los campos y estados
            limpiarCamposPersona('sus');
            document.getElementById('input_dni_sus').value = '';
            document.getElementById('input_dni_sus').classList.remove('dni-found', 'dni-not-found', 'dni-error');
            document.getElementById('dni_sus_status').innerHTML = '<i class="fas fa-search text-muted"></i>';
            document.getElementById('dni_sus_message').textContent = '';
            document.getElementById('persona_sus_status').style.display = 'none';
        }
    }

    function limpiarFechasNuevas() {
        document.getElementById('input_fecha_nueva').value = '';
        document.getElementById('input_hora_nueva').value = '';
    }

    function cerrarModalEditarCita() {
        document.getElementById('modalEditarCita').style.display = 'none';
    }

    function abrirModalNuevaCita() {
        // Limpiar formulario
        document.getElementById('formNuevaCita').reset();

        // Resetear checkbox y campos del sustituto
        const checkbox = document.getElementById('nuevo_checkbox_sustituto');
        const sustitutoCampos = document.getElementById('nuevoSustitutoCampos');
        const noSustituto = document.getElementById('nuevoNoSustituto');

        checkbox.checked = false;
        sustitutoCampos.style.display = 'none';
        noSustituto.style.display = 'block';

        // Establecer fecha mínima como hoy
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('nuevo_fecha').min = today;

        // Mostrar modal
        document.getElementById('modalNuevaCita').style.display = 'flex';
    }

    function cerrarModalNuevaCita() {
        document.getElementById('modalNuevaCita').style.display = 'none';
    }

    function abrirModalEditarCita(id, idRep, idRepSus, fecha, hora, estado, nombreRep, apellidoRep, dniRep, cargoRep, telefonoRep, correoRep, nombreSus, apellidoSus, dniSus, cargoSus, telefonoSus, correoSus, descripcion, fechaNue, horaNue) {
        document.getElementById('modalEditarCita').style.display = 'flex';
        document.getElementById('formEditarCita').action = `/citas/${id}`;

        // Rellenar campos del representante principal
        document.getElementById('input_id_rep').value = idRep;
        document.getElementById('input_nombre_rep').value = nombreRep || '';
        document.getElementById('input_apellido_rep').value = apellidoRep || '';
        document.getElementById('input_dni_rep').value = dniRep || '';
        document.getElementById('input_cargo_rep').value = cargoRep || '';
        document.getElementById('input_telefono_rep').value = telefonoRep || '';
        document.getElementById('input_correo_rep').value = correoRep || '';

        // Fechas originales
        document.getElementById('input_fecha_original').value = fecha || '';
        document.getElementById('input_hora_original').value = hora || '';

        // Fechas nuevas
        document.getElementById('input_fecha_nueva').value = fechaNue || '';
        document.getElementById('input_hora_nueva').value = horaNue || '';

        // Estado y descripción
        document.getElementById('input_estado').value = estado || 'pendiente';
        document.getElementById('input_descripcion').value = descripcion || '';

        // Manejar representante sustituto
        const checkboxSustituto = document.getElementById('checkbox_sustituto');
        const sustitutoCampos = document.getElementById('sustitutoCampos');
        const noSustituto = document.getElementById('noSustituto');

        if (idRepSus && idRepSus !== 'null' && nombreSus && apellidoSus && dniSus) {
            // Hay sustituto
            checkboxSustituto.checked = true;
            sustitutoCampos.style.display = 'block';
            noSustituto.style.display = 'none';

            // Llenar campos del sustituto
            document.getElementById('input_dni_sus').value = dniSus;
            document.getElementById('input_nombre_sus').value = nombreSus;
            document.getElementById('input_apellido_sus').value = apellidoSus;
            document.getElementById('input_cargo_sus').value = cargoSus || '';
            document.getElementById('input_telefono_sus').value = telefonoSus || '';
            document.getElementById('input_correo_sus').value = correoSus || '';

            // Marcar como encontrado (ya existe)
            document.getElementById('input_dni_sus').classList.add('dni-found');
            document.getElementById('dni_sus_status').innerHTML = '<i class="fas fa-check-circle text-success"></i>';
            document.getElementById('dni_sus_message').textContent = 'Persona encontrada';
            document.getElementById('dni_sus_message').className = 'form-text text-success';

            // Habilitar campos para edición
            habilitarCamposPersona('sus');

            // Mostrar mensaje de éxito
            document.getElementById('persona_sus_status').className = 'alert alert-success';
            document.getElementById('persona_sus_message').textContent = 'Persona encontrada en el sistema. Puede editar los datos si es necesario.';
            document.getElementById('persona_sus_status').style.display = 'block';

            // Hacer requeridos los campos
            document.getElementById('input_nombre_sus').required = true;
            document.getElementById('input_apellido_sus').required = true;
            document.getElementById('input_dni_sus').required = true;
            document.getElementById('input_cargo_sus').required = true;
        } else {
            // No hay sustituto
            checkboxSustituto.checked = false;
            sustitutoCampos.style.display = 'none';
            noSustituto.style.display = 'block';

            // Limpiar y resetear todo
            limpiarCamposPersona('sus');
            document.getElementById('input_dni_sus').value = '';
            document.getElementById('input_dni_sus').classList.remove('dni-found', 'dni-not-found', 'dni-error');
            document.getElementById('dni_sus_status').innerHTML = '<i class="fas fa-search text-muted"></i>';
            document.getElementById('dni_sus_message').textContent = '';
            document.getElementById('persona_sus_status').style.display = 'none';

            // Quitar requeridos
            document.getElementById('input_nombre_sus').required = false;
            document.getElementById('input_apellido_sus').required = false;
            document.getElementById('input_dni_sus').required = false;
            document.getElementById('input_cargo_sus').required = false;
        }
    }

    function abrirModalVerCita(idCita, nombreRep, apellidoRep, dniRep, cargoRep, telefonoRep, correoRep,
        nombreMinera, rucMinera, direccionMinera, telefonoMinera, correoMinera,
        nombreSus, apellidoSus, dniSus, cargoSus, telefonoSus, correoSus,
        fechaOriginal, horaOriginal, fechaNueva, horaNueva, estado, descripcion) {

        // Llenar información del representante principal
        document.getElementById('ver_nombre_rep').textContent = nombreRep + ' ' + apellidoRep;
        document.getElementById('ver_dni_rep').textContent = dniRep || 'No especificado';
        document.getElementById('ver_cargo_rep').textContent = cargoRep || 'No especificado';
        document.getElementById('ver_telefono_rep').textContent = telefonoRep || 'No especificado';
        document.getElementById('ver_correo_rep').textContent = correoRep || 'No especificado';

        // Llenar información de la minera
        document.getElementById('ver_nombre_minera').textContent = nombreMinera || 'No especificado';
        document.getElementById('ver_ruc_minera').textContent = rucMinera || 'No especificado';
        document.getElementById('ver_direccion_minera').textContent = direccionMinera || 'No especificado';
        document.getElementById('ver_telefono_minera').textContent = telefonoMinera || 'No especificado';
        document.getElementById('ver_correo_minera').textContent = correoMinera || 'No especificado';

        // Manejar representante sustituto
        if (nombreSus && apellidoSus) {
            document.getElementById('ver_sustituto_card').style.display = 'block';
            document.getElementById('ver_no_sustituto').style.display = 'none';

            document.getElementById('ver_nombre_sus').textContent = nombreSus + ' ' + apellidoSus;
            document.getElementById('ver_dni_sus').textContent = dniSus || 'No especificado';
            document.getElementById('ver_cargo_sus').textContent = cargoSus || 'No especificado';
            document.getElementById('ver_telefono_sus').textContent = telefonoSus || 'No especificado';
            document.getElementById('ver_correo_sus').textContent = correoSus || 'No especificado';
        } else {
            document.getElementById('ver_sustituto_card').style.display = 'none';
            document.getElementById('ver_no_sustituto').style.display = 'block';
        }

        // Llenar información de horarios
        document.getElementById('ver_fecha_original').textContent = fechaOriginal ? new Date(fechaOriginal).toLocaleDateString('es-ES') : 'No especificado';
        document.getElementById('ver_hora_original').textContent = horaOriginal || 'No especificado';

        // Manejar nueva fecha y hora
        if (fechaNueva && horaNueva) {
            document.getElementById('ver_fecha_nueva_row').style.display = 'flex';
            document.getElementById('ver_hora_nueva_row').style.display = 'flex';
            document.getElementById('ver_fecha_nueva').textContent = new Date(fechaNueva).toLocaleDateString('es-ES');
            document.getElementById('ver_hora_nueva').textContent = horaNueva;
        } else {
            document.getElementById('ver_fecha_nueva_row').style.display = 'none';
            document.getElementById('ver_hora_nueva_row').style.display = 'none';
        }

        // Llenar descripción
        document.getElementById('ver_descripcion').textContent = descripcion || 'Sin descripción adicional';

        // Llenar estado
        const estadoBadge = document.getElementById('ver_estado_badge');
        estadoBadge.textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
        estadoBadge.className = `estado-badge estado-${estado.toLowerCase()}`;

        // Mostrar modal
        document.getElementById('modalVerCita').style.display = 'flex';
    }

    function cerrarModalVerCita() {
        document.getElementById('modalVerCita').style.display = 'none';
    }

    // Agregar el meta tag para CSRF si no existe
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = '{{ csrf_token() }}';
        document.head.appendChild(meta);
    }

    // Hacer las funciones globales
    window.confirmarEliminar = confirmarEliminar;
    window.toggleNuevoSustituto = toggleNuevoSustituto;
    window.toggleSustituto = toggleSustituto;
    window.limpiarFechasNuevas = limpiarFechasNuevas;
    window.cerrarModalEditarCita = cerrarModalEditarCita;
    window.abrirModalEditarCita = abrirModalEditarCita;
    window.abrirModalNuevaCita = abrirModalNuevaCita;
    window.cerrarModalNuevaCita = cerrarModalNuevaCita;
    window.abrirModalVerCita = abrirModalVerCita;
    window.cerrarModalVerCita = cerrarModalVerCita;
    window.buscarPersonaPorDni = buscarPersonaPorDni;
});