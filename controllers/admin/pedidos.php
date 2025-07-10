<?php
// malvishop/controllers/admin/pedidos.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$pedidos_por_pagina = 15;
$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_actual - 1) * $pedidos_por_pagina;

$buscar = $_GET['buscar'] ?? '';

$where_clauses = [];
$params = [];

if ($buscar !== '') {
    $where_clauses[] = "(p.id = :id_exact OR u.nombre LIKE :buscar OR u.apellido LIKE :buscar)";
    $params['id_exact'] = (int)$buscar;
    $params['buscar'] = '%' . $buscar . '%';
}

$where_sql = '';
if (!empty($where_clauses)) {
    $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
}

$total_pedidos = $db->query(
    "SELECT COUNT(p.id) FROM pedidos p
     JOIN usuarios u ON p.cliente_id = u.id
     $where_sql",
    $params
)->fetchColumn();

$total_paginas = ceil($total_pedidos / $pedidos_por_pagina);

$params['limit'] = $pedidos_por_pagina;
$params['offset'] = $offset;

$pedidos = $db->query(
    "SELECT 
        p.id, 
        p.fecha_pedido, 
        p.total_pedido, 
        CONCAT(u.nombre, ' ', u.apellido) AS cliente_nombre, 
        ep.nombre as estado_nombre
     FROM pedidos p
     JOIN usuarios u ON p.cliente_id = u.id
     JOIN estados_pedido ep ON p.estado_id = ep.id
     $where_sql
     ORDER BY p.fecha_pedido DESC 
     LIMIT :limit OFFSET :offset",
    $params
)->fetchAll();

require BASE_PATH . '/views/admin/pedidos.php';
