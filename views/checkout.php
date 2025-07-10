<?php require('partials/header_app.php'); ?>

<div class="container page-container checkout-page">
    <h1 class="page-title">Finalizar Compra</h1>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert is-error">
            <div class="alert-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            </div>
            <div class="alert-message"><?php echo $errors['general']; ?></div>
        </div>
    <?php endif; ?>

    <div class="checkout-layout">
        <div class="checkout-form">
            <form action="<?php echo htmlspecialchars($baseUrl); ?>/checkout" method="POST">
                <fieldset>
                    <legend>1. Dirección de Envío</legend>
                    <div class="form-group">
                        <label for="direccion_envio">Confirmar Dirección</label>
                        <textarea id="direccion_envio" name="direccion_envio" rows="3" required><?php echo htmlspecialchars($usuario['direccion']); ?>, <?php echo htmlspecialchars($usuario['codigo_postal']); ?></textarea>
                        <small>Tu pedido se enviará a esta dirección. Puedes editarla si es necesario.</small>
                    </div>
                    <div class="form-group">
                        <label for="notas_cliente">Notas adicionales (opcional)</label>
                        <textarea id="notas_cliente" name="notas_cliente" rows="2" placeholder="Ej: Dejar en portería."></textarea>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>2. Método de Pago</legend>
                    <div class="form-group">
                        <select name="metodo_pago" required>
                            <option value="" disabled selected>Selecciona un método...</option>
                            <option value="transferencia">Transferencia Bancaria</option>
                            <option value="tarjeta_credito">Tarjeta de Crédito (Simulado)</option>
                            <option value="mercado_pago">Mercado Pago (Simulado)</option>
                        </select>
                    </div>
                </fieldset>

                <button type="submit" class="button checkout-btn">Realizar Pedido</button>
            </form>
        </div>

        <div class="order-summary">
            <h3>Resumen de tu Pedido</h3>
            <ul class="summary-item-list">
                <?php foreach ($items_del_carrito as $item): ?>
                    <li>
                        <span><?php echo htmlspecialchars($item['nombre']); ?> (x<?php echo $item['cantidad']; ?>)</span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="summary-row total">
                <span>Total a Pagar</span>
                <span>$<?php echo number_format($total_carrito, 2, ',', '.'); ?></span>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>