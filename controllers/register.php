<?php
// malvishop/controllers/register.php

$errors = [];
$old_input = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitizar y obtener todos los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $dni = trim($_POST['dni'] ?? '');
    $cuit_cuil = trim($_POST['cuit_cuil'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $codigo_postal = trim($_POST['codigo_postal'] ?? '');
    $descripcion_fachada = trim($_POST['descripcion_fachada'] ?? '');

    // Guardar datos para repoblar el formulario en caso de error
    $old_input = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email,
        'dni' => $dni,
        'cuit_cuil' => $cuit_cuil,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'codigo_postal' => $codigo_postal,
        'descripcion_fachada' => $descripcion_fachada
    ];

    //  Validaciones de campos individuales 
    if (empty($nombre)) { $errors['nombre'] = 'El nombre es obligatorio.'; }
    if (empty($apellido)) { $errors['apellido'] = 'El apellido es obligatorio.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'El formato del email no es válido.'; }
    if (strlen($password) < 8) { $errors['password'] = 'La contraseña debe tener al menos 8 caracteres.'; }
    if ($password !== $password_confirm) { $errors['password_confirm'] = 'Las contraseñas no coinciden.'; }
    if (empty($dni)) {
        $errors['dni'] = 'El DNI es obligatorio.';
    } elseif (!preg_match('/^[\d]{1,2}\.[\d]{3}\.[\d]{3}$/', $dni)) {
        $errors['dni'] = 'El formato del DNI debe ser XX.XXX.XXX.';
    }
    if (empty($cuit_cuil)) {
        $errors['cuit_cuil'] = 'El CUIL/CUIT es obligatorio.';
    } elseif (!preg_match('/^[\d]{2}-[\d]{8}-[\d]{1}$/', $cuit_cuil)) {
        $errors['cuit_cuil'] = 'El formato del CUIL/CUIT debe ser XX-XXXXXXXX-X.';
    }
    if (empty($direccion)) { $errors['direccion'] = 'La dirección es obligatoria.'; }
    if (empty($codigo_postal)) { $errors['codigo_postal'] = 'El código postal es obligatorio.'; }

    if (!empty($telefono) && !preg_match('/^[0-9]{10,15}$/', preg_replace('/\D/', '', $telefono))) {
        $errors['telefono'] = 'El teléfono solo debe contener números y tener una longitud válida.';
    }

   
    if (empty($errors['dni']) && empty($errors['cuit_cuil'])) {
        $dni_numeros = str_replace('.', '', $dni);
        $cuit_dni_parte = substr(str_replace('-', '', $cuit_cuil), 2, 8);
        if ($dni_numeros !== $cuit_dni_parte) {
            $errors['cuit_cuil'] = 'El DNI no coincide con el número central del CUIL/CUIT.';
        }
    }

    if (empty($errors)) {
        try {
            $user = $db->query(
                "SELECT id FROM usuarios WHERE email = :email OR dni = :dni OR cuit_cuil = :cuit_cuil",
                ['email' => $email, 'dni' => $dni, 'cuit_cuil' => $cuit_cuil]
            )->fetch();

            if ($user) {
                $errors['general'] = 'El email, DNI o CUIL/CUIT ingresado ya se encuentra registrado.';
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $db->query(
                    "INSERT INTO usuarios (nombre, apellido, email, password, dni, cuit_cuil, telefono, direccion, codigo_postal, descripcion_fachada, rol_id)
                     VALUES (:nombre, :apellido, :email, :password, :dni, :cuit_cuil, :telefono, :direccion, :codigo_postal, :descripcion_fachada, 1)",
                    [
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'email' => $email,
                        'password' => $hashed_password,
                        'dni' => $dni,
                        'cuit_cuil' => $cuit_cuil,
                        'telefono' => !empty($telefono) ? $telefono : null,
                        'direccion' => $direccion,
                        'codigo_postal' => $codigo_postal,
                        'descripcion_fachada' => !empty($descripcion_fachada) ? $descripcion_fachada : null,
                    ]
                );
                $_SESSION['flash_message'] = ['type' => 'success', 'message' => '¡Te has registrado con éxito! Ahora puedes iniciar sesión.'];
                header('Location: ' . $baseUrl . '/login');
                exit();
            }
        } catch (Exception $e) {
            $errors['general'] = 'Ocurrió un error al crear la cuenta. Por favor, inténtalo de nuevo más tarde.';
        }
    }
}

require BASE_PATH . '/views/register.php';