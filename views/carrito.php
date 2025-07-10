<?php require('partials/header_app.php'); ?>

<div class="container page-container">
    <h1 class="page-title">Tu Carrito de Compras</h1>

    <?php if (empty($items_del_carrito)): ?>
        <div class="cart-empty">
            <p>Tu carrito está vacío.</p>
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/productos" class="button">Ver Productos</a>
        </div>
    <?php else: ?>
        <div class="cart-layout">
            <div class="cart-items">
                <?php foreach ($items_del_carrito as $item): ?>
                    <div class="cart-item" id="item-<?php echo $item['id']; ?>">
                        <img src="<?php echo htmlspecialchars($baseUrl); ?>/images/productos/<?php echo htmlspecialchars($item['imagen'] ?? 'placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>" class="cart-item-image">
                        <div class="cart-item-details">
                            <h3><a href="<?php echo htmlspecialchars($baseUrl); ?>/producto/<?php echo htmlspecialchars($item['slug']); ?>"><?php echo htmlspecialchars($item['nombre']); ?></a></h3>
                            <p class="cart-item-price">$<?php echo number_format($item['precio'], 2, ',', '.'); ?></p>
                            <div class="cart-item-quantity">
                                <button class="quantity-btn decrease-btn" data-id="<?php echo $item['id']; ?>">-</button>
                                <input type="text" class="quantity-input" value="<?php echo $item['cantidad']; ?>" readonly>
                                <button class="quantity-btn increase-btn" data-id="<?php echo $item['id']; ?>">+</button>
                            </div>
                        </div>
                        <div class="cart-item-subtotal">
                            <p>Subtotal: <strong id="subtotal-<?php echo $item['id']; ?>">$<?php echo number_format($item['subtotal'], 2, ',', '.'); ?></strong></p>
                            <a href="<?php echo htmlspecialchars($baseUrl); ?>/carrito/eliminar/<?php echo $item['id']; ?>" class="remove-item-btn" data-id="<?php echo $item['id']; ?>">Quitar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <h2>Resumen del Pedido</h2>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="cart-subtotal">$<?php echo number_format($total_carrito, 2, ',', '.'); ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span id="cart-total">$<?php echo number_format($total_carrito, 2, ',', '.'); ?></span>
                </div>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/checkout" class="button checkout-btn">Finalizar Compra</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require('partials/footer.php'); ?>