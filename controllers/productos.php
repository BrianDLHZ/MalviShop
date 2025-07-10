<?php
// malvishop/controllers/productos.php

$productos_por_pagina = 8;
$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_actual - 1) * $productos_por_pagina;

// agarramos todos los filtros y términos de búsqueda de la URL
$termino_busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';
$filtro_categoria = isset($_GET['categoria']) && $_GET['categoria'] !== '' ? (int)$_GET['categoria'] : null;
$filtro_marca = isset($_GET['marca']) && $_GET['marca'] !== '' ? trim($_GET['marca']) : '';
$filtro_precio_min = isset($_GET['precio_min']) && $_GET['precio_min'] !== '' ? (float)$_GET['precio_min'] : null;
$filtro_precio_max = isset($_GET['precio_max']) && $_GET['precio_max'] !== '' ? (float)$_GET['precio_max'] : null;


// consulta base de datos
$sql_base = "FROM productos WHERE activo = TRUE";
$condiciones = [];
$params = [];

// aplcamos cada filtro si están presente
if (!empty($termino_busqueda)) {
    $condiciones[] = "(nombre LIKE :termino_busqueda OR marca LIKE :termino_busqueda OR codigo LIKE :termino_busqueda)";
    $params[':termino_busqueda'] = "%$termino_busqueda%";
}
if ($filtro_categoria) {
    $condiciones[] = "categoria_id = :categoria_id";
    $params[':categoria_id'] = $filtro_categoria;
}
if ($filtro_marca) {
    $condiciones[] = "marca = :marca";
    $params[':marca'] = $filtro_marca;
}
if (!is_null($filtro_precio_min)) {
    $condiciones[] = "precio >= :precio_min";
    $params[':precio_min'] = $filtro_precio_min;
}
if (!is_null($filtro_precio_max)) {
    $condiciones[] = "precio <= :precio_max";
    $params[':precio_max'] = $filtro_precio_max;
}

$sql_where = "";
if (!empty($condiciones)) {
    $sql_where = " AND " . implode(" AND ", $condiciones);
}


// paginacion
$total_productos = $db->query("SELECT COUNT(id) " . $sql_base . $sql_where, $params)->fetchColumn();
$total_paginas = $total_productos > 0 ? ceil($total_productos / $productos_por_pagina) : 1;


// obtner productos
$sql_productos = "SELECT id, nombre, precio, imagen_principal, slug " . $sql_base . $sql_where . " ORDER BY nombre ASC LIMIT :limit OFFSET :offset";

$params_paginated = array_merge($params, [
    ':limit' => $productos_por_pagina,
    ':offset' => $offset
]);

$productos = $db->query($sql_productos, $params_paginated)->fetchAll();


//  datos para los desplegables de Filtros
$categorias_filtro = $db->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC")->fetchAll();
$marcas_filtro = $db->query("SELECT DISTINCT marca FROM productos WHERE activo = TRUE AND marca IS NOT NULL AND marca != '' ORDER BY marca ASC")->fetchAll(PDO::FETCH_COLUMN);


// obtenemos los IDs de los productos en la lista de deseados solo si el usuario inicio sesión
$deseados_ids = [];
if (isset($_SESSION['user_id'])) {
    $resultados_deseados = $db->query(
        "SELECT producto_id FROM lista_deseados WHERE usuario_id = :usuario_id",
        ['usuario_id' => $_SESSION['user_id']]
    )->fetchAll(PDO::FETCH_COLUMN);
    $deseados_ids = $resultados_deseados ?: [];
}

require BASE_PATH . '/views/productos.php';
