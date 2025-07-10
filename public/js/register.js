document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('register-form');
    const dniInput = document.getElementById('dni');
    const cuitInput = document.getElementById('cuit_cuil');
    const telInput = document.getElementById('telefono');
    const passwordInput = document.getElementById('password');

    //  Formateo automático para DNI 
    if (dniInput) {
        dniInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) value = value.slice(0, 8);
            
            let formattedValue = value;
            if (value.length > 5) {
                formattedValue = value.slice(0, 2) + '.' + value.slice(2, 5) + '.' + value.slice(5);
            } else if (value.length > 2) {
                formattedValue = value.slice(0, 2) + '.' + value.slice(2);
            }
            e.target.value = formattedValue;
        });
    }

    //  Formateo automático para CUIL/CUIT 
    if (cuitInput) {
        cuitInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            
            let formattedValue = value;
            if (value.length > 10) {
                formattedValue = value.slice(0, 2) + '-' + value.slice(2, 10) + '-' + value.slice(10);
            } else if (value.length > 2) {
                formattedValue = value.slice(0, 2) + '-' + value.slice(2);
            }
            e.target.value = formattedValue;
        });
    }
    
    //  Lógica para limitar teléfono a solo números y max 15 digitos
    if (telInput) {
        telInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 15) value = value.slice(0, 15);
            e.target.value = value;
        });
    }

    //  Logica para el medidor de fortaleza de contraseña 
    if (passwordInput) {
        passwordInput.addEventListener('input', function(e) {
            const password = e.target.value;
            const meter = document.getElementById('password-strength-meter');
            const text = document.getElementById('password-strength-text');
            if (!meter || !text) return;

            const strength = checkPasswordStrength(password);
            
            // Actualizamos el texto
            text.textContent = strength.text;

            // Reseteamos las clases y añadimos las nuevas para el color
            meter.className = 'password-strength-meter';
            text.className = 'strength-text'; // Resetear clase del texto
            if (strength.value > 0) {
                meter.classList.add(`strength-${strength.value}`);
                text.classList.add(`text-strength-${strength.value}`); // Se añade clase al texto también
            }
        });
    }

    function checkPasswordStrength(password) {
        let score = 0;
        let text = '';
        if (!password) return { value: 0, text: '' };

        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        switch (score) {
            case 1: text = 'Muy Débil'; break;
            case 2: text = 'Débil'; break;
            case 3: text = 'Aceptable'; break;
            case 4: text = 'Fuerte (Nivel Rayada)'; break;
            case 5: text = 'Muy Fuerte (Nivel Backup)'; break;
            default: text = 'Demasiado corta'; break;
        }
        if (password.length < 8) text = 'Demasiado corta';

        return { value: score, text: text };
    }

    //  validación al enviar el formulario
    if (form) {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            // Limpiar errores previos
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            document.querySelectorAll('input, textarea').forEach(el => el.classList.remove('is-invalid'));

            // Validar campos obligatorios
            const requiredFields = ['#nombre', '#apellido', '#email', '#password', '#password_confirm', '#dni', '#cuit_cuil', '#direccion', '#codigo_postal'];
            requiredFields.forEach(selector => {
                const input = form.querySelector(selector);
                if (input.value.trim() === '') {
                    isValid = false;
                    showError(input, `El campo es obligatorio.`);
                }
            });

            // Validaciones específicas
            const email = form.querySelector('#email');
            if (email.value.trim() !== '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                isValid = false;
                showError(email, 'El formato del email no es válido.');
            }

            const password = form.querySelector('#password');
            if (password.value.length > 0 && password.value.length < 8) {
                isValid = false;
                showError(password, 'La contraseña debe tener al menos 8 caracteres.');
            }

            const passwordConfirm = form.querySelector('#password_confirm');
            if (password.value !== passwordConfirm.value) {
                isValid = false;
                showError(passwordConfirm, 'Las contraseñas no coinciden.');
            }

            // Validación de coincidencia DNI y CUIL/CUIT
            if (dniInput.value && cuitInput.value) {
                const dniNumeros = dniInput.value.replace(/\./g, '');
                const cuitDniParte = cuitInput.value.replace(/-/g, '').substring(2, 10);
                if (dniNumeros && cuitDniParte && dniNumeros !== cuitDniParte) {
                    isValid = false;
                    showError(cuitInput, 'El DNI no coincide con el CUIL/CUIT.');
                }
            }

            // Si alguna validacion falló, detenemos el envio
            if (!isValid) {
                event.preventDefault();
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