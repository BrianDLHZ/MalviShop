document.addEventListener('DOMContentLoaded', () => {
    // Selector para el formulario de datos personales
    const personalDataForm = document.getElementById('personal-data-form');
    // Selector para el formulario de cambio de contraseña
    const passwordChangeForm = document.getElementById('password-change-form');

    // Validación para el formulario de datos personales
    if (personalDataForm) {
        personalDataForm.addEventListener('submit', function(event) {
            let isValid = true;
            const nombre = personalDataForm.querySelector('#nombre');
            const apellido = personalDataForm.querySelector('#apellido');

            // Limpiar errores previos
            [nombre, apellido].forEach(input => input.nextElementSibling.textContent = '');

            if (nombre.value.trim() === '') {
                isValid = false;
                showError(nombre, 'El nombre no puede estar vacío.');
            }
            if (apellido.value.trim() === '') {
                isValid = false;
                showError(apellido, 'El apellido no puede estar vacío.');
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    // validación para el formulario de cambio de contraseña
    if (passwordChangeForm) {
        passwordChangeForm.addEventListener('submit', function(event) {
            let isValid = true;
            const currentPassword = passwordChangeForm.querySelector('#current_password');
            const newPassword = passwordChangeForm.querySelector('#new_password');
            const confirmPassword = passwordChangeForm.querySelector('#confirm_password');

            // Limpiar errores previos
            [currentPassword, newPassword, confirmPassword].forEach(input => input.nextElementSibling.textContent = '');
            
            if (currentPassword.value.trim() === '' || newPassword.value.trim() === '' || confirmPassword.value.trim() === '') {
                 isValid = false;
                 // Mostramos un error general en el primer campo para no ser repetitivos
                 showError(currentPassword, 'Todos los campos son obligatorios para cambiar la contraseña.');
            } else {
                if (newPassword.value.length < 8) {
                    isValid = false;
                    showError(newPassword, 'La nueva contraseña debe tener al menos 8 caracteres.');
                }
                if (newPassword.value !== confirmPassword.value) {
                    isValid = false;
                    showError(confirmPassword, 'Las contraseñas no coinciden.');
                }
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    // funcion de ayuda para mostrar errores debajo del input
    function showError(inputElement, message) {
        const errorElement = inputElement.nextElementSibling;
        if (errorElement && errorElement.tagName === 'SMALL') {
            errorElement.textContent = message;
            // Para que funcione con los errores de PHP tambien  le ponemos un estilo simple
            errorElement.style.color = '#dc3545';
            errorElement.style.display = 'block';
        }
    }
});