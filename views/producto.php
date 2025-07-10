<?php 
// decidimos qué o cual header cargar
if (isset($_SESSION['user_id'])) {
    require('partials/header_app.php');
} else {
    require('partials/header.php');
}
?>

<div class="container product-detail-container">
    
    <?php
    if (isset($_SESSION['flash_message'])) {
        $alert = $_SESSION['flash_message'];
        require(BASE_PATH . '/views/partials/alert.php');
        unset($_SESSION['flash_message']);
    }
    ?>

    <div class="back-to-catalog">
        <a href="<?php echo htmlspecialchars($baseUrl); ?>/productos">&larr; Volver al Catálogo</a>
    </div>

    <div class="product-layout">
        <div class="product-image-gallery">
            <img src="<?php echo htmlspecialchars($baseUrl); ?>/images/productos/<?php echo htmlspecialchars($producto['imagen_principal'] ?? 'placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="main-product-image">
        </div>

        <div class="product-info">
            <h1 class="product-title"><?php echo htmlspecialchars($producto['nombre']); ?></h1>
            <p class="product-brand">Marca: <strong><?php echo htmlspecialchars($producto['marca']); ?></strong></p>
            <p class="product-price">$<?php echo number_format($producto['precio'], 2, ',', '.'); ?></p>
            
            <div class="product-short-description">
                <?php 
                $descripcion_corta = strlen($producto['descripcion']) > 150 ? substr($producto['descripcion'], 0, 150) . '...' : $producto['descripcion'];
                echo nl2br(htmlspecialchars($descripcion_corta)); 
                ?>
            </div>

            <div class="product-actions">
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

    <div class="product-long-details">
        <h2>Detalles del Producto</h2>
        <p><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></p>
        
        <?php if (!empty($producto['especificaciones']) && is_array($producto['especificaciones'])): ?>
            <h3>Especificaciones Técnicas</h3>
            <ul class="product-specs">
                <?php foreach ($producto['especificaciones'] as $key => $value): ?>
                    <li><strong><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $key))); ?>:</strong> <?php echo htmlspecialchars($value); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?php require('partials/footer.php'); ?>