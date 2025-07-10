<?php
// malvishop/controllers/admin/editar_categoria.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) { exit('Acceso denegado.'); }

$categoria_id = $params['id'] ?? null;
if (!$categoria_id) { header('Location: ' . $baseUrl . '/admin/categorias'); exit(); }

$errors = [];
$todas_las_categorias = $db->query("SELECT id, nombre FROM categorias WHERE id != :id ORDER BY nombre ASC", ['id' => $categoria_id])->fetchAll();
$categoria = $db->query("SELECT * FROM categorias WHERE id = :id", ['id' => $categoria_id])->fetch();

if (!$categoria) { header('Location: ' . $baseUrl . '/admin/categorias'); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;

    if (empty($nombre)) {
        $errors[] = 'El nombre de la categoría es obligatorio.';
    }

    if (empty($errors)) {
        $db->query(
            "UPDATE categorias SET nombre = :nombre, parent_id = :parent_id WHERE id = :id",
            ['nombre' => $nombre, 'parent_id' => $parent_id, 'id' => $categoria_id]
        );

        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Categoría actualizada con éxito.'];
        header('Location: ' . $baseUrl . '/admin/categorias');
        exit();
    }
}

require BASE_PATH . '/views/admin/category_form.php';