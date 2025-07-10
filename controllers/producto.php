<?php
// malvishop/controllers/producto.php

$slug = $params['slug'] ?? null;

if (!$slug) {
    // si no hay slug, no podemos hacer nada
    http_response_code(404);
    require BASE_PATH . '/views/404.php';
    exit();
}

// Buscamos el producto por su slug
$producto = $db->query("SELECT * FROM productos WHERE slug = :slug AND activo = TRUE", ['slug' => $slug])->fetch();

// Si no se encuentra el producto, mostramos la pagin 404
if (!$producto) {
    http_response_code(404);
    require BASE_PATH . '/views/404.php';
    exit();
}

// Decodificamos las specs JSON para poder usarlas en la vista
$producto['especificaciones'] = json_decode($producto['especificaciones'] ?? '[]', true);

// Obtenemos la lista de deseados del usuario para mostrar el estado del corachonchito
$deseados_ids = [];
if (isset($_SESSION['user_id'])) {
    $resultados_deseados = $db->query(
        "SELECT producto_id FROM lista_deseados WHERE usuario_id = :usuario_id",
        ['usuario_id' => $_SESSION['user_id']]
    )->fetchAll(PDO::FETCH_COLUMN);
    $deseados_ids = $resultados_deseados ?: [];
}


require BASE_PATH . '/views/producto.php';