<?php
// malvishop/controllers/pedidos.php

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$usuario_id = $_SESSION['user_id'];

// bscamos todos los pedidos del usuario uniendo la tabla de pedidos
// con la de estados para obtener el nombre del estado en lugar de solo el ID
$pedidos = $db->query(
    "SELECT p.id, p.fecha_pedido, p.total_pedido, ep.nombre as estado_nombre
     FROM pedidos p
     JOIN estados_pedido ep ON p.estado_id = ep.id
     WHERE p.cliente_id = :cliente_id
     ORDER BY p.fecha_pedido DESC",
    ['cliente_id' => $usuario_id]
)->fetchAll();


require BASE_PATH . '/views/pedidos.php';