<div id="mini-cart-modal" class="mini-cart-modal">
    <div class="mini-cart-content">
        <span class="close-button" onclick="document.getElementById('mini-cart-modal').classList.remove('show');">&times;</span>
        <p><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg> ¡Producto añadido al carrito!</p>
        <div class="mini-cart-actions">
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/carrito" class="button">Ver Carrito</a>
            <button onclick="document.getElementById('mini-cart-modal').classList.remove('show');">Seguir Comprando</button>
        </div>
    </div>
</div>