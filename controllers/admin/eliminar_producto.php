<?php
// malvishop/controllers/admin/eliminar_producto.php

// Guardián del panel de administración
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$producto_id = $params['id'] ?? null;

if ($producto_id) {
    // 1. Buscamos y borramos la foto
    $producto = $db->query("SELECT imagen_principal FROM productos WHERE id = :id", ['id' => $producto_id])->fetch();
    if ($producto && !empty($producto['imagen_principal'])) {
        $ruta_imagen = BASE_PATH . '/public/images/productos/' . $producto['imagen_principal'];
        if (file_exists($ruta_imagen)) {
            unlink($ruta_imagen); // Borra el archivo de imagen del servier
        }
    }
    
    $db->query("DELETE FROM productos WHERE id = :id", ['id' => $producto_id]);

    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Producto eliminado correctamente.'
    ];
}

header('Location: ' . $baseUrl . '/admin/productos');
exit();