<?php
// malvishop/controllers/deseados.php

if (!isset($_SESSION['user_id'])) {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Login requerido']);
    } else {
        header('Location: ' . $baseUrl . '/login');
    }
    exit();
}

$action = $params['action'] ?? 'ver';
$producto_id = $params['id'] ?? null;
$usuario_id = $_SESSION['user_id'];

// LÓGICA PARA AGREGAR/SACAR (AJAX)
if ($action === 'agregar' && $producto_id) {
    $deseo_existente = $db->query("SELECT id FROM lista_deseados WHERE usuario_id = :uid AND producto_id = :pid", ['uid' => $usuario_id, 'pid' => $producto_id])->fetch();
    if ($deseo_existente) {
        $db->query("DELETE FROM lista_deseados WHERE id = :id", ['id' => $deseo_existente['id']]);
        $action_taken = 'removed';
    } else {
        $db->query("INSERT INTO lista_deseados (usuario_id, producto_id) VALUES (:uid, :pid)", ['uid' => $usuario_id, 'pid' => $producto_id]);
        $action_taken = 'added';
    }
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'action' => $action_taken]);
    exit();
}


//  LÓGICA PARA MOSTRAR LA VISTA DE LA LISTA 

$deseados_ids = $db->query(
    "SELECT producto_id FROM lista_deseados WHERE usuario_id = :usuario_id",
    ['usuario_id' => $usuario_id]
)->fetchAll(PDO::FETCH_COLUMN);

$productos_deseados = [];
if (!empty($deseados_ids)) {
    // Generamos parámetros con nombre para la cláusula IN
    $in_params = [];
    $param_keys = [];
    foreach ($deseados_ids as $i => $id) {
        $key = ":id{$i}";
        $param_keys[] = $key;
        $in_params[$key] = $id;
    }
    $placeholders = implode(',', $param_keys);
    
    $productos_deseados = $db->query(
        "SELECT id, nombre, precio, imagen_principal, slug FROM productos WHERE id IN ($placeholders)",
        $in_params
    )->fetchAll();
}

require BASE_PATH . '/views/deseados.php';