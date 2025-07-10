<?php
// malvishop/controllers/admin/editar_producto.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$producto_id = $params['id'] ?? null;
if (!$producto_id) {
    header('Location: ' . $baseUrl . '/admin/productos');
    exit();
}

$errors = [];
$categorias = $db->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC")->fetchAll();
$producto = $db->query("SELECT * FROM productos WHERE id = :id", ['id' => $producto_id])->fetch();

if (!$producto) {
    header('Location: ' . $baseUrl . '/admin/productos');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Recoger datos
    $nombre = trim($_POST['nombre'] ?? '');
    $marca = trim($_POST['marca'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $codigo = trim($_POST['codigo'] ?? '');
    $categoria_id = !empty($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;
    $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT);
    $activo = isset($_POST['activo']) ? 1 : 0;
    $destacado = isset($_POST['destacado']) ? 1 : 0;
    
    // 2. Validar datos
    if (empty($nombre)) { $errors[] = 'El nombre no puede estar vacío.'; }
    if ($precio === false || $precio <= 0) { $errors[] = 'El precio debe ser un número válido mayor a cero.'; }
    
    // 3.. Manejar subida de la fotito
    $imagen_a_guardar = $producto['imagen_principal']; // Por defecto, mantenemos la imagen actual para evitar errores xd
    if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['imagen_principal'];
        $allowed_types = ['image/jpeg', 'image/png'];
        $max_size = 5 * 1024 * 1024;

        if (!in_array($file['type'], $allowed_types)) { $errors[] = 'Formato de imagen no válido.'; }
        if ($file['size'] > $max_size) { $errors[] = 'La imagen es demasiado grande.'; }
        
        if (empty($errors)) {
            // Borramos la imagen vieja si existe
            if (!empty($producto['imagen_principal']) && file_exists(BASE_PATH . '/public/images/productos/' . $producto['imagen_principal'])) {
                unlink(BASE_PATH . '/public/images/productos/' . $producto['imagen_principal']);
            }
            
            $filename = uniqid('prod_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $target_path = BASE_PATH . '/public/images/productos/' . $filename;
            if (move_uploaded_file($file['tmp_name'], $target_path)) {
                $imagen_a_guardar = $filename;
            } else {
                $errors[] = 'Error al subir la nueva imagen.';
            }
        }
    }

    if (empty($errors)) {
        try {
            // 4 Actualizar en la base de datos
            $db->query(
                "UPDATE productos SET 
                    nombre = :nombre, 
                    descripcion = :desc, 
                    marca = :marca, 
                    codigo = :codigo, 
                    precio = :precio, 
                    stock = :stock, 
                    categoria_id = :cat_id, 
                    activo = :activo, 
                    destacado = :destacado, 
                    imagen_principal = :img 
                WHERE id = :id",
                [
                    'nombre' => $nombre,
                    'desc' => $descripcion,
                    'marca' => $marca,
                    'codigo' => $codigo,
                    'precio' => $precio,
                    'stock' => $stock,
                    'cat_id' => $categoria_id,
                    'activo' => $activo,
                    'destacado' => $destacado,
                    'img' => $imagen_a_guardar,
                    'id' => $producto_id
                ]
            );

            $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Producto actualizado con éxito.'];
            header('Location: ' . $baseUrl . '/admin/productos');
            exit();

        } catch (Exception $e) {
            $errors[] = 'Error al actualizar el producto. El SKU ya podría existir.';
        }
    }
    // Si hay errores, se repueblan los datos viejos con los del POST para que el usuario pueda corregirlo
    $old_input = $_POST;
    $producto = array_merge($producto, $old_input);
}

// Para el primer renderizado (GET), pre-rellenamos $old_input con los datos del productos
$old_input = $producto;

require BASE_PATH . '/views/admin/product_form.php';