<?php
// malvishop/controllers/admin/pedido.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$pedido_id = $params['id'] ?? null;
if (!$pedido_id) {
    header('Location: ' . $baseUrl . '/admin/pedidos');
    exit();
}

// Si se envía el formulario para actualizar el estado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_estado_id = $_POST['estado_id'] ?? null;
    
    if ($nuevo_estado_id) {
        // Actualizamos el estado del pedido en la base de datos
        $db->query(
            "UPDATE pedidos SET estado_id = :estado_id WHERE id = :id",
            ['estado_id' => $nuevo_estado_id, 'id' => $pedido_id]
        );

        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Estado del pedido actualizado con éxito.'];
    }
    
    // Redirigimos a la misma página para ver los cambios
    header('Location: ' . $baseUrl . '/admin/pedido/' . $pedido_id);
    exit();
}


// 1. Obtenemos los datos principales del pedido
$pedido = $db->query(
    "SELECT p.*, CONCAT(u.nombre, ' ', u.apellido) as cliente_nombre, u.email as cliente_email, ep.nombre as estado_nombre
     FROM pedidos p
     JOIN usuarios u ON p.cliente_id = u.id
     JOIN estados_pedido ep ON p.estado_id = ep.id
     WHERE p.id = :id",
    ['id' => $pedido_id]
)->fetch();

if (!$pedido) {
    http_response_code(404);
    require BASE_PATH . '/views/404.php';
    exit();
}

// 2. Obtenemos los productos del pedido
$items_del_pedido = $db->query("SELECT * FROM detalle_pedido WHERE pedido_id = :pedido_id", ['pedido_id' => $pedido_id])->fetchAll();

// 3. Obtenemos TODOS los estados posibles para el menu desplegable
$todos_los_estados = $db->query("SELECT * FROM estados_pedido")->fetchAll();


require BASE_PATH . '/views/admin/pedido.php';