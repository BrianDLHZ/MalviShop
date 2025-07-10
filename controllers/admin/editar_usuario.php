<?php
// malvishop/controllers/admin/editar_usuario.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 3) {
    http_response_code(403);
    echo "Acceso denegado.";
    exit();
}

$usuario_id_a_editar = $params['id'] ?? null;
if (!$usuario_id_a_editar) {
    header('Location: ' . $baseUrl . '/admin/usuarios');
    exit();
}

$errors = [];
$roles = $db->query("SELECT * FROM roles")->fetchAll();

// Si se envía el formulario con los datos actualizados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $rol_id = (int)($_POST['rol_id'] ?? 1);
    $activo = isset($_POST['activo']) ? 1 : 0;

    // Validaciones
    if (empty($nombre) || empty($apellido)) { $errors[] = 'Nombre y apellido son obligatorios.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'El formato del email no es válido.'; }

    if (empty($errors)) {
        try {
            $db->query(
                "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, email = :email, rol_id = :rol_id, activo = :activo WHERE id = :id",
                [
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'email' => $email,
                    'rol_id' => $rol_id,
                    'activo' => $activo,
                    'id' => $usuario_id_a_editar
                ]
            );
            $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Usuario actualizado con éxito.'];
            header('Location: ' . $baseUrl . '/admin/usuarios');
            exit();
        } catch (Exception $e) {
            $errors[] = 'Error al actualizar el usuario. Es posible que el email ya esté en uso.';
        }
    }
}

// Obtenemos los datos actuales del usuario para mostrar en el formulario
$usuario = $db->query("SELECT * FROM usuarios WHERE id = :id", ['id' => $usuario_id_a_editar])->fetch();
if (!$usuario) {
    header('Location: ' . $baseUrl . '/admin/usuarios');
    exit();
}

require BASE_PATH . '/views/admin/user_form.php';