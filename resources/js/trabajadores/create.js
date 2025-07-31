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


    const confirmationField = document.getElementById('contrasena_confirmation');
    if (confirmationField) {
        confirmationField.addEventListener('input', function () {
            const password = document.getElementById('contrasena').value;
            const confirmation = this.value;

            if (password !== confirmation) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    }


    const nombresField = document.getElementById('nombres');
    const apellidosField = document.getElementById('apellidos');

    if (nombresField && apellidosField) {
        nombresField.addEventListener('input', generateUsername);
        apellidosField.addEventListener('input', generateUsername);
    }

    function generateUsername() {
        const nombres = document.getElementById('nombres').value.toLowerCase();
        const apellidos = document.getElementById('apellidos').value.toLowerCase();
        const usernameField = document.getElementById('nombre_usuario');

        if (nombres && apellidos && usernameField && !usernameField.value) {
            const firstLetter = nombres.charAt(0);
            const lastName = apellidos.split(' ')[0];
            const suggestion = firstLetter + lastName;
            usernameField.placeholder = `Sugerencia: ${suggestion}`;
        }
    }

    // Validación del formulario antes de enviar
    const form = document.getElementById('trabajadorForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            const password = document.getElementById('contrasena').value;
            const confirmation = document.getElementById('contrasena_confirmation').value;

            if (password !== confirmation) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres');
                return false;
            }
        });
    }
});
