<?php
// malvishop/controllers/admin/categorias.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$categorias = $db->query(
    "SELECT c1.*, c2.nombre AS nombre_padre
     FROM categorias c1
     LEFT JOIN categorias c2 ON c1.parent_id = c2.id
     ORDER BY c1.nombre ASC"
)->fetchAll();

require BASE_PATH . '/views/admin/categorias.php';