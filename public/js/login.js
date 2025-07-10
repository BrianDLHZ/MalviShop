document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('login-form');

    if (form) {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            // Limpiar errores previos
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            document.querySelectorAll('input').forEach(el => el.classList.remove('is-invalid'));

            // Validar email
            const email = form.querySelector('#email');
            if (email.value.trim() === '') {
                isValid = false;
                showError(email, 'Por favor, ingresa tu email.');
            }

            // Validar contraseña
            const password = form.querySelector('#password');
            if (password.value.trim() === '') {
                isValid = false;
                showError(password, 'Por favor, ingresa tu contraseña.');
            }
            
            if (!isValid) {
                event.preventDefault(); // Detener el envíio si hay errores
            }
        });
    }

    function showError(inputElement, message) {
        inputElement.classList.add('is-invalid');
        const errorElement = inputElement.nextElementSibling;
        if (errorElement && errorElement.classList.contains('error-message')) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    }
});