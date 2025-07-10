<?php
// malvishop/controllers/admin/productos.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

// Paginación
$productos_por_pagina = 15;
$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_actual - 1) * $productos_por_pagina;

// Filtros de busquedda
$buscar = trim($_GET['buscar'] ?? '');
$estado = $_GET['estado'] ?? '';

// Construir clausulas dinamicas
$where_clauses = [];
$params = [];

if ($buscar !== '') {
    $where_clauses[] = "(nombre LIKE :buscar OR marca LIKE :buscar)";
    $params['buscar'] = '%' . $buscar . '%';
}

if ($estado === '0' || $estado === '1') {
    $where_clauses[] = "activo = :estado";
    $params['estado'] = (int)$estado;
}

$where_sql = '';
if (!empty($where_clauses)) {
    $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
}

// Total de productos (filtrado)
$total_productos = $db->query(
    "SELECT COUNT(id) FROM productos $where_sql",
    $params
)->fetchColumn();

$total_paginas = ceil($total_productos / $productos_por_pagina);

// Parámetros para consulta final
$params['limit'] = $productos_por_pagina;
$params['offset'] = $offset;

$productos = $db->query(
    "SELECT id, nombre, marca, precio, stock, activo, imagen_principal
     FROM productos
     $where_sql
     ORDER BY id DESC
     LIMIT :limit OFFSET :offset",
    $params
)->fetchAll();

require BASE_PATH . '/views/admin/productos.php';
