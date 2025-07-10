<?php
// malvishop/controllers/admin/agregar_categoria.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) { exit('Acceso denegado.'); }

$errors = [];
$todas_las_categorias = $db->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;

    if (empty($nombre)) {
        $errors[] = 'El nombre de la categoría es obligatorio.';
    }

    if (empty($errors)) {
        $slug_base = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nombre)));
        $slug = $slug_base;
        $counter = 1;
        while ($db->query("SELECT id FROM categorias WHERE slug = :slug", ['slug' => $slug])->fetch()) {
            $slug = $slug_base . '-' . $counter++;
        }

        $db->query(
            "INSERT INTO categorias (nombre, slug, parent_id) VALUES (:nombre, :slug, :parent_id)",
            ['nombre' => $nombre, 'slug' => $slug, 'parent_id' => $parent_id]
        );

        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Categoría añadida con éxito.'];
        header('Location: ' . $baseUrl . '/admin/categorias');
        exit();
    }
}

require BASE_PATH . '/views/admin/category_form.php';