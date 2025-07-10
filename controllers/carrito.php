<?php
// malvishop/controllers/carrito.php

if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Login requerido']);
    exit();
}

$action = $params['action'] ?? 'ver';
$producto_id = $params['id'] ?? null;

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

//  Lógica para manejar las acciones del carrito 
if ($producto_id) {
    switch ($action) {
        case 'agregar':
            $_SESSION['carrito'][$producto_id] = ($_SESSION['carrito'][$producto_id] ?? 0) + 1;
            break;
        case 'incrementar':
            if (isset($_SESSION['carrito'][$producto_id])) {
                $_SESSION['carrito'][$producto_id]++;
            }
            break;
        case 'decrementar':
            if (isset($_SESSION['carrito'][$producto_id]) && $_SESSION['carrito'][$producto_id] > 1) {
                $_SESSION['carrito'][$producto_id]--;
            } else {
                unset($_SESSION['carrito'][$producto_id]); // Si llega a 0, se borra
            }
            break;
        case 'eliminar':
            unset($_SESSION['carrito'][$producto_id]);
            break;
    }
}

// Si la petición fue para modificar el carrito, devolvemos una respuesta JSON
if (in_array($action, ['agregar', 'incrementar', 'decrementar', 'eliminar'])) {
    // Recalculamos todo para devolver el estado actualizado  ((no es la forma más limpia pero bue))
    $items = [];
    $total = 0;
    if (!empty($_SESSION['carrito'])) {
        $ids_productos = array_keys($_SESSION['carrito']);
        $in_params = [];
        $param_keys = [];
        foreach ($ids_productos as $i => $id) {
            $key = ":id{$i}";
            $param_keys[] = $key;
            $in_params[$key] = $id;
        }
        $placeholders = implode(',', $param_keys);
        
        $productos_en_carrito = $db->query("SELECT id, precio FROM productos WHERE id IN ($placeholders)", $in_params)->fetchAll();
        $productos_por_id = array_column($productos_en_carrito, null, 'id');

        foreach ($_SESSION['carrito'] as $id => $cantidad) {
            if (isset($productos_por_id[$id])) {
                $subtotal = $productos_por_id[$id]['precio'] * $cantidad;
                $total += $subtotal;
                $items[$id] = [
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal
                ];
            }
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'cart_total_items' => array_sum($_SESSION['carrito'] ?? []),
        'cart_total_price' => $total,
        'items' => $items
    ]);
    exit();
}


//  LÓGICA PARA MOSTRAR LA VISTA DEL CARRITO 
$items_del_carrito = [];
$total_carrito = 0;

if (!empty($_SESSION['carrito'])) {
    $ids_productos = array_keys($_SESSION['carrito']);
    
    $in_params = [];
    $param_keys = [];
    foreach ($ids_productos as $i => $id) {
        $key = ":id{$i}";
        $param_keys[] = $key;
        $in_params[$key] = $id;
    }
    $placeholders = implode(',', $param_keys);
    
    $productos_en_carrito = $db->query(
        "SELECT id, nombre, precio, imagen_principal, slug FROM productos WHERE id IN ($placeholders)",
        $in_params
    )->fetchAll();

    foreach ($productos_en_carrito as $producto) {
        $cantidad = $_SESSION['carrito'][$producto['id']];
        $subtotal = $producto['precio'] * $cantidad;
        $total_carrito += $subtotal;

        $items_del_carrito[] = [
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'slug' => $producto['slug'],
            'precio' => $producto['precio'],
            'imagen' => $producto['imagen_principal'],
            'cantidad' => $cantidad,
            'subtotal' => $subtotal
        ];
    }
}

require BASE_PATH . '/views/carrito.php';