<?php 
if (isset($_SESSION['user_id'])) {
    require('partials/header_app.php');
} else {
    require('partials/header.php');
}
?>

<div class="container page-container">
    <?php
    if (isset($_SESSION['flash_message'])) {
        $alert = $_SESSION['flash_message'];
        require(BASE_PATH . '/views/partials/alert.php');
        unset($_SESSION['flash_message']);
    }
    ?>
    <h1 class="page-title">Nuestro Catálogo</h1>

    <form action="<?php echo htmlspecialchars($baseUrl); ?>/productos" method="GET" class="filtros-form">
        <div class="filtro-item filtro-busqueda">
            <label for="filtro_busqueda">Buscar Producto</label>
            <input type="search" id="filtro_busqueda" name="q" placeholder="Ej: Router, TP-Link, etc." value="<?php echo htmlspecialchars($termino_busqueda ?? ''); ?>">
        </div>

        <div class="filtro-item">
            <label for="filtro_categoria">Categoría</label>
            <select id="filtro_categoria" name="categoria">
                <option value="">Todas</option>
                <?php foreach ($categorias_filtro as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo (isset($filtro_categoria) && $filtro_categoria == $cat['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filtro-item">
            <label for="filtro_marca">Marca</label>
            <select id="filtro_marca" name="marca">
                <option value="">Todas</option>
                <?php foreach ($marcas_filtro as $m): ?>
                    <option value="<?php echo htmlspecialchars($m); ?>" <?php echo (isset($filtro_marca) && $filtro_marca == $m) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($m); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filtro-item">
            <label for="filtro_precio_min">Precio Mín.</label>
            <input type="number" id="filtro_precio_min" name="precio_min" step="0.01" value="<?php echo htmlspecialchars($filtro_precio_min ?? ''); ?>" placeholder="Desde">
        </div>

        <div class="filtro-item">
            <label for="filtro_precio_max">Precio Máx.</label>
            <input type="number" id="filtro_precio_max" name="precio_max" step="0.01" value="<?php echo htmlspecialchars($filtro_precio_max ?? ''); ?>" placeholder="Hasta">
        </div>
    </form>

    <?php if (!empty($productos)): ?>
        <div class="product-grid">
            <?php foreach ($productos as $producto): ?>
                <div class="producto-card">
                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/producto/<?php echo htmlspecialchars($producto['slug']); ?>">
                        <img src="<?php echo htmlspecialchars($baseUrl); ?>/images/productos/<?php echo htmlspecialchars($producto['imagen_principal'] ?? 'placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    </a>
                    <div class="producto-card-content">
                        <h3><a href="<?php echo htmlspecialchars($baseUrl); ?>/producto/<?php echo htmlspecialchars($producto['slug']); ?>"><?php echo htmlspecialchars($producto['nombre']); ?></a></h3>
                        <p class="precio">$<?php echo number_format($producto['precio'], 2, ',', '.'); ?></p>
                        
                        <div class="card-actions">
                            <a href="<?php echo htmlspecialchars($baseUrl); ?>/carrito/agregar/<?php echo htmlspecialchars($producto['id']); ?>" class="button add-to-cart-btn">Añadir al Carrito</a>
                            
                            <?php
                            $es_deseado = isset($deseados_ids) && in_array($producto['id'], $deseados_ids);
                            ?>
                            <a href="<?php echo htmlspecialchars($baseUrl); ?>/deseados/agregar/<?php echo htmlspecialchars($producto['id']); ?>" 
                               class="wishlist-btn <?php echo $es_deseado ? 'is-active' : ''; ?>" 
                               title="<?php echo $es_deseado ? 'Quitar de Deseados' : 'Añadir a Deseados'; ?>">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-products-found">No se encontraron productos que coincidan con tu búsqueda.</p>
    <?php endif; ?>

    <?php if ($total_paginas > 1): ?>
    <nav class="paginacion">
        <ul>
            <?php
            $queryParams = $_GET;
            unset($queryParams['pagina']);
            $queryString = http_build_query($queryParams);
            ?>

            <?php if ($pagina_actual > 1): ?>
                <li><a href="?pagina=<?php echo $pagina_actual - 1; ?>&<?php echo $queryString; ?>">Anterior</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="<?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                    <a href="?pagina=<?php echo $i; ?>&<?php echo $queryString; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            
            <?php if ($pagina_actual < $total_paginas): ?>
                <li><a href="?pagina=<?php echo $pagina_actual + 1; ?>&<?php echo $queryString; ?>">Siguiente</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php require('partials/footer.php'); ?>