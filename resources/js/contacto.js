document.addEventListener('DOMContentLoaded', function () {
    let searchTimeout = null;

    // Función para obtener CSRF token
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    }

    // Búsqueda automática de minera por RUC
    document.getElementById('ruc').addEventListener('input', function (e) {
        // Solo permitir números
        e.target.value = e.target.value.replace(/\D/g, '');

        const ruc = e.target.value;

        // Limpiar timeout anterior
        if (searchTimeout) clearTimeout(searchTimeout);

        if (ruc.length === 11) {
            searchTimeout = setTimeout(() => {
                searchMinera(ruc);
            }, 500);
        } else {
            clearMineraFields();
            hideRepresentanteSelector();
        }
    });

    // Manejar cambio en selector de representante
    document.getElementById('representante_existente').addEventListener('change', function () {
        const selectedValue = this.value;

        if (selectedValue === 'nuevo') {
            showNuevoRepresentanteFields();
            clearRepresentanteFields();
        } else {
            hideNuevoRepresentanteFields();
            // Buscar y llenar datos del representante seleccionado
            const representantes = JSON.parse(this.dataset.representantes || '[]');
            const representante = representantes.find(rep => rep.id_rep == selectedValue);
            if (representante) {
                fillRepresentanteFromExisting(representante);
            }
        }
    });

    // Función para buscar minera
    function searchMinera(ruc) {
        const statusDiv = document.getElementById('rucStatus');
        showSearchStatus(statusDiv, 'Buscando empresa...', 'loading');

        fetch('/api/search-minera', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ ruc: ruc })
        })
            .then(response => response.json())
            .then(data => {
                if (data.found) {
                    fillMineraFields(data.data);
                    showRepresentanteSelector(data.representantes);
                    showSearchStatus(statusDiv, '✅ Empresa encontrada - Datos autocompletados', 'found');
                } else {
                    clearMineraFields();
                    hideRepresentanteSelector();
                    showSearchStatus(statusDiv, '📝 Nueva empresa - Complete los datos', 'not-found');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideSearchStatus(statusDiv);
            });
    }

    // Mostrar selector de representantes
    function showRepresentanteSelector(representantes) {
        const selector = document.getElementById('representanteSelector');
        const select = document.getElementById('representante_existente');

        // Limpiar opciones anteriores
        select.innerHTML = '<option value="nuevo">Registrar nuevo representante</option>';

        if (representantes && representantes.length > 0) {
            // Agregar representantes existentes
            representantes.forEach(rep => {
                const option = document.createElement('option');
                option.value = rep.id_rep;
                option.textContent = `${rep.nombre_completo} - ${rep.cargo}`;
                select.appendChild(option);
            });

            // Guardar datos en el dataset para uso posterior
            select.dataset.representantes = JSON.stringify(representantes);

            selector.style.display = 'block';
        } else {
            hideRepresentanteSelector();
        }
    }

    // Ocultar selector de representantes
    function hideRepresentanteSelector() {
        document.getElementById('representanteSelector').style.display = 'none';
        document.getElementById('representante_existente').value = 'nuevo';
        showNuevoRepresentanteFields();
    }

    // Mostrar campos para nuevo representante
    function showNuevoRepresentanteFields() {
        document.getElementById('nuevoRepresentanteFields').style.display = 'block';
        // Hacer campos obligatorios
        ['dni', 'nombres', 'apellidos', 'cargo'].forEach(field => {
            document.getElementById(field).required = true;
        });
    }

    // Ocultar campos para nuevo representante
    function hideNuevoRepresentanteFields() {
        document.getElementById('nuevoRepresentanteFields').style.display = 'none';
        // Hacer campos no obligatorios
        ['dni', 'nombres', 'apellidos', 'cargo'].forEach(field => {
            document.getElementById(field).required = false;
        });
    }

    // Llenar datos de representante existente
    function fillRepresentanteFromExisting(representante) {
        document.getElementById('dni').value = representante.dni;
        document.getElementById('nombres').value = representante.nombres;
        document.getElementById('apellidos').value = representante.apellidos;
        document.getElementById('cargo').value = representante.cargo;
        document.getElementById('telefono').value = representante.telefono || '';
        document.getElementById('correo').value = representante.correo || '';

        // Marcar como autocompletados
        ['dni', 'nombres', 'apellidos', 'cargo', 'telefono', 'correo'].forEach(field => {
            const element = document.getElementById(field);
            if (element.value) {
                element.classList.add('auto-filled');
            }
        });
    }

    // Funciones auxiliares para el estado de búsqueda
    function showSearchStatus(element, message, type) {
        element.textContent = message;
        element.className = `search-status search-${type}`;
        element.style.display = 'block';
    }

    function hideSearchStatus(element) {
        element.style.display = 'none';
    }

    // Llenar campos de minera
    function fillMineraFields(data) {
        const fields = ['nombre_minera', 'direccion', 'telefono_contacto', 'correo_contacto'];
        fields.forEach(field => {
            if (data[field]) {
                document.getElementById(field).value = data[field];
                markAsAutoFilled(field);
            }
        });
    }

    // Marcar campo como autocompletado
    function markAsAutoFilled(fieldId) {
        document.getElementById(fieldId).classList.add('auto-filled');
    }

    // Limpiar campos de minera
    function clearMineraFields() {
        const fields = ['nombre_minera', 'direccion', 'telefono_contacto', 'correo_contacto'];
        fields.forEach(field => {
            document.getElementById(field).classList.remove('auto-filled');
        });
        hideSearchStatus(document.getElementById('rucStatus'));
    }

    // Limpiar campos de representante
    function clearRepresentanteFields() {
        const fields = ['dni', 'nombres', 'apellidos', 'cargo', 'telefono', 'correo'];
        fields.forEach(field => {
            const element = document.getElementById(field);
            element.value = '';
            element.classList.remove('auto-filled');
        });
    }

    // Validación de fecha mínima
    document.getElementById('fecha').min = new Date().toISOString().split('T')[0];

    // Cargar horarios disponibles cuando se selecciona una fecha
    document.getElementById('fecha').addEventListener('change', function () {
        const fecha = this.value;
        const horaSelect = document.getElementById('hora');
        const warning = document.getElementById('timeWarning');

        if (!fecha) {
            horaSelect.disabled = true;
            horaSelect.innerHTML = '<option value="">Primero seleccione una fecha</option>';
            return;
        }

        // Verificar si es domingo
        const selectedDate = new Date(fecha + 'T00:00:00');
        if (selectedDate.getDay() === 0) {
            horaSelect.disabled = true;
            horaSelect.innerHTML = '<option value="">Domingos cerrado</option>';
            warning.innerHTML = '⚠️ Los domingos estamos cerrados. Por favor seleccione otra fecha.';
            warning.style.display = 'block';
            return;
        }

        // Obtener horarios disponibles
        fetch('/api/get-available-slots', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ fecha: fecha })
        })
            .then(response => response.json())
            .then(data => {
                horaSelect.innerHTML = '<option value="">Seleccione un horario</option>';

                if (data.slots && data.slots.length > 0) {
                    data.slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot.time;
                        option.textContent = slot.display + (slot.available ? '' : ' - OCUPADO');
                        option.disabled = !slot.available;
                        option.style.color = slot.available ? '#333' : '#999';
                        horaSelect.appendChild(option);
                    });
                    horaSelect.disabled = false;
                    warning.style.display = 'none';
                } else {
                    horaSelect.innerHTML = '<option value="">No hay horarios disponibles</option>';
                    horaSelect.disabled = true;
                    warning.innerHTML = '⚠️ No hay horarios disponibles para esta fecha.';
                    warning.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                horaSelect.innerHTML = '<option value="">Error al cargar horarios</option>';
                horaSelect.disabled = true;
            });
    });

    // Verificar disponibilidad al seleccionar horario
    document.getElementById('hora').addEventListener('change', function () {
        const fecha = document.getElementById('fecha').value;
        const hora = this.value;
        const submitBtn = document.getElementById('submitBtn');

        if (fecha && hora) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            submitBtn.style.cursor = 'not-allowed';
        }
    });

    // Deshabilitar botón de envío inicialmente
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.5';
        submitBtn.style.cursor = 'not-allowed';
    }
});