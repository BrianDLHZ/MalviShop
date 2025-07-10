<?php
// malvishop/controllers/admin/eliminar_pedido.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$pedido_id = $params['id'] ?? null;

if ($pedido_id) {
    // La restricción 'ON DELETE CASCADE' en la base de datos se encarga d borrar
    // automááticamente los registros relacionados en la tabla 'detalle_pedido'.
    
    // Eliminamos el pedido de la base de datos
    $db->query("DELETE FROM pedidos WHERE id = :id", ['id' => $pedido_id]);

    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Pedido eliminado correctamente.'
    ];
}

// Redirigimos de vuelta a la lista de pedidos
header('Location: ' . $baseUrl . '/admin/pedidos');
exit();