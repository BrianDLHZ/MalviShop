<?php
// malvishop/controllers/admin/delete_product.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$producto_id = $params['id'] ?? null;

if ($producto_id) {
    
    $db->query("DELETE FROM productos WHERE id = :id", ['id' => $producto_id]);

    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Producto eliminado correctamente.'
    ];
}

header('Location: ' . $baseUrl . '/admin/productos');
exit();