<?php
// malvishop/controllers/admin/agregar_producto.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$errors = [];
$old_input = [];
$categorias = $db->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_input = $_POST; 

    $nombre = trim($_POST['nombre'] ?? '');
    $marca = trim($_POST['marca'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $codigo = trim($_POST['codigo'] ?? '');
    $categoria_id = !empty($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;
    $precio = filter_var($_POST['precio'] ?? '', FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'] ?? '', FILTER_VALIDATE_INT);
    $activo = isset($_POST['activo']) ? 1 : 0;
    $destacado = isset($_POST['destacado']) ? 1 : 0;
    $imagen_principal = null;

    if (empty($nombre)) { $errors[] = 'El nombre del producto es obligatorio.'; }
    if (empty($codigo)) { $errors[] = 'El código (SKU) es obligatorio.'; }
    if ($precio === false || $precio <= 0) { $errors[] = 'El precio debe ser un número válido mayor a cero.'; }
    
    if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['imagen_principal'];
       
        if (empty($errors)) {
            $filename = uniqid('prod_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $target_path = BASE_PATH . '/public/images/productos/' . $filename;
            if (move_uploaded_file($file['tmp_name'], $target_path)) {
                $imagen_principal = $filename;
            } else {
                $errors[] = 'Ocurrió un error al subir la imagen.';
            }
        }
    }

    if (empty($errors)) {
        $slug_base = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nombre)));
        $slug = $slug_base;
        $counter = 1;
        while ($db->query("SELECT id FROM productos WHERE slug = :slug", ['slug' => $slug])->fetch()) {
            $slug = $slug_base . '-' . $counter++;
        }

        try {
            $db->query(
                "INSERT INTO productos (nombre, slug, descripcion, marca, codigo, precio, stock, categoria_id, activo, destacado, imagen_principal) VALUES (:nombre, :slug, :desc, :marca, :codigo, :precio, :stock, :cat_id, :activo, :destacado, :img)",
                ['nombre' => $nombre, 'slug' => $slug, 'desc' => $descripcion, 'marca' => $marca, 'codigo' => $codigo, 'precio' => $precio, 'stock' => $stock, 'cat_id' => $categoria_id, 'activo' => $activo, 'destacado' => $destacado, 'img' => $imagen_principal]
            );

            $_SESSION['flash_message'] = ['type' => 'success', 'message' => '¡Producto añadido con éxito!'];
            header('Location: ' . $baseUrl . '/admin/productos');
            exit();

        } catch (Exception $e) {
            $errors[] = 'Ocurrió un error al guardar el producto. Es posible que el SKU ya exista.';
        }
    }
}

require BASE_PATH . '/views/admin/product_form.php';