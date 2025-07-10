<?php
// malvishop/controllers/login.php

if (isset($_SESSION['user_id'])) {
    // Si ya está logueado, lo redirigimos a su panel correspondiente (si es admin)
    header('Location: ' . $baseUrl . ($_SESSION['user_rol_id'] > 1 ? '/admin' : '/productos'));
    exit();
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = $db->query("SELECT * FROM usuarios WHERE email = :email", ['email' => $email])->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nombre'] = $user['nombre'];
        $_SESSION['user_apellido'] = $user['apellido'];
        $_SESSION['user_rol_id'] = (int)$user['rol_id'];

        // LÓGICA DE REDIRECCIÓN BASADA EN ROL
        if ($_SESSION['user_rol_id'] === 2 || $_SESSION['user_rol_id'] === 3) {
            // Si es gestor (2) o administrador (3), va al panel de admin
            header('Location: ' . $baseUrl . '/admin');
        } else {
            // Si es cliente (1), va al catálogo
            $_SESSION['flash_message'] = ['type' => 'success', 'message' => '¡Has iniciado sesión exitosamente!'];
            header('Location: ' . $baseUrl . '/productos');
        }
        exit();

    } else {
        $errors['general'] = 'Email o contraseña incorrectos.';
    }
}

require BASE_PATH . '/views/login.php';