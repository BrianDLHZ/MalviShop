<?php require('partials/header_app.php'); ?>

<div class="container page-container">
    <h1 class="page-title">Mi Lista de Deseados</h1>

    <?php if (empty($productos_deseados)): ?>
        <div class="cart-empty">
            <p>Tu lista de deseados está vacía.</p>
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/productos" class="button">Ver Productos</a>
        </div>
    <?php else: ?>
        <div class="product-grid" id="wishlist-grid">
            <?php foreach ($productos_deseados as $producto): ?>
                <div class="producto-card" id="wishlist-item-<?php echo $producto['id']; ?>">
                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/producto/<?php echo htmlspecialchars($producto['slug']); ?>">
                        <img src="<?php echo htmlspecialchars($baseUrl); ?>/images/productos/<?php echo htmlspecialchars($producto['imagen_principal'] ?? 'placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    </a>
                    <div class="producto-card-content">
                        <h3><a href="<?php echo htmlspecialchars($baseUrl); ?>/producto/<?php echo htmlspecialchars($producto['slug']); ?>"><?php echo htmlspecialchars($producto['nombre']); ?></a></h3>
                        <p class="precio">$<?php echo number_format($producto['precio'], 2, ',', '.'); ?></p>

                        <div class="card-actions">
                            <a href="<?php echo htmlspecialchars($baseUrl); ?>/carrito/agregar/<?php echo htmlspecialchars($producto['id']); ?>" class="button add-to-cart-btn">Añadir al Carrito</a>

                            <a href="<?php echo htmlspecialchars($baseUrl); ?>/deseados/agregar/<?php echo htmlspecialchars($producto['id']); ?>" 
                               class="wishlist-btn is-active" 
                               title="Quitar de Deseados">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require('partials/footer.php'); ?>
