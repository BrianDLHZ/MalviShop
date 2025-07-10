<?php
// malvishop/controllers/home.php

try {
    $productos_destacados = $db->query(
        "SELECT id, nombre, precio, imagen_principal, slug FROM productos WHERE destacado = TRUE AND activo = TRUE LIMIT 10"
    )->fetchAll();
} catch (Exception $e) {
    // Si hay un error, dejamos el array vacío para no romper la página a la gaver.
    $productos_destacados = [];
}

// Agarramos los IDs de los productos en la lista de deseados del usuario actual
$deseados_ids = [];
if (isset($_SESSION['user_id'])) {
    $resultados_deseados = $db->query(
        "SELECT producto_id FROM lista_deseados WHERE usuario_id = :usuario_id",
        ['usuario_id' => $_SESSION['user_id']]
    )->fetchAll(PDO::FETCH_COLUMN);
    $deseados_ids = $resultados_deseados ?: [];
}

require BASE_PATH . '/views/home.php';