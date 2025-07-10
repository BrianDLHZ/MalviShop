<?php
// malvishop/controllers/pedido_detalle.php

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$cliente_id = $_SESSION['user_id'];
$pedido_id = $params['id'] ?? null;

if (!$pedido_id) {
    header('Location: ' . $baseUrl . '/pedidos');
    exit();
}

//obtenemos los datos principales del pedido.
$pedido = $db->query(
    "SELECT p.*, ep.nombre as estado_nombre
     FROM pedidos p
     JOIN estados_pedido ep ON p.estado_id = ep.id
     WHERE p.id = :id AND p.cliente_id = :cliente_id",
    ['id' => $pedido_id, 'cliente_id' => $cliente_id]
)->fetch();

if (!$pedido) {
    header('Location: ' . $baseUrl . '/pedidos');
    exit();
}

// Tomamos los productos del pedido y su respectiva foto
$items_del_pedido = $db->query(
    "SELECT dp.*, prod.imagen_principal 
     FROM detalle_pedido dp
     LEFT JOIN productos prod ON dp.producto_id = prod.id
     WHERE dp.pedido_id = :pedido_id",
    ['pedido_id' => $pedido_id]
)->fetchAll();

// Mapeo para formatear el método de pago y q no quede horrible
$metodos_pago_formateados = [
    'transferencia' => 'Transferencia Bancaria',
    'tarjeta_credito' => 'Tarjeta de Crédito',
    'mercado_pago' => 'Mercado Pago'
];

require BASE_PATH . '/views/pedido_detalle.php';