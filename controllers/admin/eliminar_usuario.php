<?php
// malvishop/controllers/admin/eliminar_usuario.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 3) {
    http_response_code(403);
    echo "Acceso denegado.";
    exit();
}

$usuario_id_a_eliminar = $params['id'] ?? null;

if ($usuario_id_a_eliminar == $_SESSION['user_id']) {
    $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'No puedes eliminar tu propia cuenta de administrador.'];
    header('Location: ' . $baseUrl . '/admin/usuarios');
    exit();
}

if ($usuario_id_a_eliminar) {
    try {
        // evitamos q de la base de datos se borren usuarios con pedidos existentes
        $db->query("DELETE FROM usuarios WHERE id = :id", ['id' => $usuario_id_a_eliminar]);
        
        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Usuario eliminado correctamente.'];

    } catch (Exception $e) {
        // Capturamos el error si el usuario tiene pedidos
        if ($e->getCode() == 23000) {
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Error: No se puede eliminar un usuario que tiene pedidos asociados.'];
        } else {
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Ocurrió un error al intentar eliminar el usuario.'];
        }
    }
}

header('Location: ' . $baseUrl . '/admin/usuarios');
exit();