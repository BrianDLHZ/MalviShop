<?php
// malvishop/controllers/checkout.php

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}
if (empty($_SESSION['carrito'])) {
    header('Location: ' . $baseUrl . '/productos');
    exit();
}

$errors = [];
$usuario_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $direccion_envio = trim($_POST['direccion_envio'] ?? '');
    $metodo_pago = trim($_POST['metodo_pago'] ?? '');
    $notas_cliente = trim($_POST['notas_cliente'] ?? '');

    if (empty($direccion_envio) || empty($metodo_pago)) {
        $errors['general'] = 'Por favor, confirma tu dirección y método de pago.';
    }

    if (empty($errors)) {
        $db->connection->beginTransaction();
        try {
            $ids_productos = array_keys($_SESSION['carrito']);
            
            // Usamos parámetros con nombre para la cláusula IN
            $in_params = [];
            $param_keys = [];
            foreach ($ids_productos as $i => $id) {
                $key = ":id{$i}";
                $param_keys[] = $key;
                $in_params[$key] = $id;
            }
            $placeholders = implode(',', $param_keys);

            $productos_db = $db->query("SELECT id, nombre, precio, stock FROM productos WHERE id IN ($placeholders)", $in_params)->fetchAll();
            $productos_por_id = array_column($productos_db, null, 'id');

            $total_pedido = 0;
            foreach ($_SESSION['carrito'] as $id => $cantidad) {
                if (!isset($productos_por_id[$id])) throw new Exception("Producto no encontrado en la base de datos.");
                $total_pedido += $productos_por_id[$id]['precio'] * $cantidad;
            }

            // creamos el pedido en la tabla pedidos (usando parámetros con nombre)
            $db->query(
                "INSERT INTO pedidos (cliente_id, total_pedido, direccion_envio_texto, metodo_pago, notas_cliente) VALUES (:cliente_id, :total, :direccion, :pago, :notas)",
                [
                    'cliente_id' => $usuario_id,
                    'total' => $total_pedido,
                    'direccion' => $direccion_envio,
                    'pago' => $metodo_pago,
                    'notas' => $notas_cliente
                ]
            );
            $pedido_id = $db->connection->lastInsertId();

            // Insertamos cada producto en la tabla de detalles de pedidos
            $sql_detalle = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario_snapshot, nombre_producto_snapshot) VALUES (?, ?, ?, ?, ?)";
            $stmt_detalle = $db->connection->prepare($sql_detalle);
            foreach ($_SESSION['carrito'] as $id => $cantidad) {
                $stmt_detalle->execute([ $pedido_id, $id, $cantidad, $productos_por_id[$id]['precio'], $productos_por_id[$id]['nombre'] ]);
            }
            
            $db->connection->commit();
            unset($_SESSION['carrito']);
            header('Location: ' . $baseUrl . '/pedido_exitoso');
            exit();

        } catch (Exception $e) {
            $db->connection->rollBack();
            $errors['general'] = 'Hubo un error al procesar tu pedido. Inténtalo de nuevo.';
        }
    }
}

// usar parámetros con nombre para buscar al usuario 
$usuario = $db->query("SELECT * FROM usuarios WHERE id = :id", ['id' => $usuario_id])->fetch();

// Obtenemos los productos del carrito para el resumen
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
    
    $productos_en_carrito = $db->query("SELECT id, nombre, precio FROM productos WHERE id IN ($placeholders)", $in_params)->fetchAll();
    
    foreach ($productos_en_carrito as $producto) {
        $cantidad = $_SESSION['carrito'][$producto['id']];
        $total_carrito += $producto['precio'] * $cantidad;
        $items_del_carrito[] = ['nombre' => $producto['nombre'], 'cantidad' => $cantidad];
    }
}

require BASE_PATH . '/views/checkout.php';