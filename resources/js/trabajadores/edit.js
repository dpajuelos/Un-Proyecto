document.addEventListener('DOMContentLoaded', function () {

    // Función para mostrar/ocultar contraseñas
    window.togglePassword = function (fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');

        if (field && icon) {
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    };

    // Validación en tiempo real de confirmación de contraseña
    const confirmationField = document.getElementById('contrasena_confirmation');
    const passwordField = document.getElementById('contrasena');

    if (confirmationField && passwordField) {
        confirmationField.addEventListener('input', function () {
            const password = passwordField.value;
            const confirmation = this.value;

            // Solo validar si hay algo en los campos
            if (password || confirmation) {
                if (password !== confirmation) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            } else {
                this.classList.remove('is-invalid', 'is-valid');
            }
        });

        // También validar cuando se escribe en el campo de contraseña
        passwordField.addEventListener('input', function () {
            const confirmation = confirmationField.value;
            const password = this.value;

            if (password || confirmation) {
                if (password !== confirmation) {
                    confirmationField.classList.add('is-invalid');
                    confirmationField.classList.remove('is-valid');
                } else {
                    confirmationField.classList.remove('is-invalid');
                    confirmationField.classList.add('is-valid');
                }
            } else {
                confirmationField.classList.remove('is-invalid', 'is-valid');
            }
        });
    }

    // Validación del formulario antes de enviar
    const form = document.getElementById('trabajadorForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            const password = passwordField.value;
            const confirmation = confirmationField.value;

            // Solo validar contraseñas si se está intentando cambiar
            if (password || confirmation) {
                if (password !== confirmation) {
                    e.preventDefault();
                    alert('Las contraseñas no coinciden');
                    return false;
                }

                if (password.length < 6) {
                    e.preventDefault();
                    alert('La nueva contraseña debe tener al menos 6 caracteres');
                    return false;
                }
            }
        });
    }

    // Confirmación antes de salir si hay cambios sin guardar
    let formChanged = false;
    const formInputs = form.querySelectorAll('input, select, textarea');

    formInputs.forEach(input => {
        input.addEventListener('change', () => {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', function (e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '¿Estás seguro de que quieres salir? Los cambios no guardados se perderán.';
        }
    });

    // Resetear flag cuando se envía el formulario
    form.addEventListener('submit', () => {
        formChanged = false;
    });
});