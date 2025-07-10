<?php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$nombre_usuario = $_SESSION['user_nombre'];

require BASE_PATH . '/views/admin/dashboard.php';