<?php
// malvishop/controllers/admin/usuarios.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 3) {
    http_response_code(403);
    echo "Acceso denegado.";
    exit();
}

// Configuración de paginación
$usuarios_por_pagina = 15;
$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_actual - 1) * $usuarios_por_pagina;

// Filtros de búsqueda
$buscar = $_GET['buscar'] ?? '';

// Construir clausulas dinámicas para búsqueda
$where_clauses = [];
$params = [];

if ($buscar !== '') {
    $where_clauses[] = "(u.nombre LIKE :buscar OR u.apellido LIKE :buscar OR u.email LIKE :buscar)";
    $params['buscar'] = '%' . $buscar . '%';
}

$where_sql = '';
if (!empty($where_clauses)) {
    $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
}

// Obtener total de usuarios con filtro
$total_usuarios = $db->query(
    "SELECT COUNT(u.id) FROM usuarios u
     $where_sql",
    $params
)->fetchColumn();

$total_paginas = ceil($total_usuarios / $usuarios_por_pagina);

// Agregar paginación a parámetros
$params['limit'] = $usuarios_por_pagina;
$params['offset'] = $offset;

// Obtener usuarios filtrados con paginacción
$usuarios = $db->query(
    "SELECT u.id, u.nombre, u.apellido, u.email, u.activo, u.foto_perfil, r.nombre_rol
     FROM usuarios u
     JOIN roles r ON u.rol_id = r.id
     $where_sql
     ORDER BY u.id ASC
     LIMIT :limit OFFSET :offset",
    $params
)->fetchAll();

require BASE_PATH . '/views/admin/usuarios.php';
