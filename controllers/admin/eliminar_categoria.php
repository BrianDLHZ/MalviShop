<?php
// malvishop/controllers/admin/eliminar_categoria.php

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol_id'] < 2) { exit('Acceso denegado.'); }

$categoria_id = $params['id'] ?? null;
if ($categoria_id) {
    // Por seguridad, primero desvinculamos los productos de esta categoría asi no se nos borra todo a la gaver
    $db->query("UPDATE productos SET categoria_id = NULL WHERE categoria_id = :id", ['id' => $categoria_id]);
    // Dsp, eliminamos la categoría
    $db->query("DELETE FROM categorias WHERE id = :id", ['id' => $categoria_id]);
    $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Categoría eliminada correctamente.'];
}

header('Location: ' . $baseUrl . '/admin/categorias');
exit();