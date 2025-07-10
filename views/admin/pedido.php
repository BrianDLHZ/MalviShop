<?php require(BASE_PATH . '/views/admin/partials/header.php'); ?>

<main class="admin-main">
    <div class="admin-container">
        <div class="admin-page-header">
            <h1 class="admin-title">Detalle del Pedido #<?php echo htmlspecialchars($pedido['id']); ?></h1>
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/pedidos" class="button">Volver a la Lista</a>
        </div>

        <?php
        // Añadido para mostrar mensajes de éxito/error
        if (isset($_SESSION['flash_message'])) {
            $alert = $_SESSION['flash_message'];
            require(BASE_PATH . '/views/partials/alert.php');
            unset($_SESSION['flash_message']);
        }
        ?>

        <div class="order-detail-layout">
            <!-- columna principal con la lista de productos -->
            <div class="order-items-panel">
                <h3>Productos en este Pedido</h3>
                <div class="table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio (al comprar)</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items_del_pedido as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['nombre_producto_snapshot']); ?></td>
                                    <td>$<?php echo number_format($item['precio_unitario_snapshot'], 2, ',', '.'); ?></td>
                                    <td>x <?php echo htmlspecialchars($item['cantidad']); ?></td>
                                    <td>$<?php echo number_format($item['precio_unitario_snapshot'] * $item['cantidad'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- columna lateral con los detalles -->
            <div class="order-summary-panel">
                <div class="summary-card">
                    <h3>Resumen del Pedido</h3>
                    <p><strong>Fecha:</strong> <?php echo date("d/m/Y H:i", strtotime($pedido['fecha_pedido'])); ?></p>
                    <p><strong>Total:</strong> <span class="total-price">$<?php echo number_format($pedido['total_pedido'], 2, ',', '.'); ?></span></p>
                    <p><strong>Estado:</strong> <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $pedido['estado_nombre'])); ?>"><?php echo htmlspecialchars($pedido['estado_nombre']); ?></span></p>
                    
                    <!-- Formulario para cambiar el estado -->
                    <form class="change-status-form" action="<?php echo htmlspecialchars($baseUrl); ?>/admin/pedido/<?php echo $pedido['id']; ?>" method="POST">
                        <label for="estado_id">Cambiar Estado:</label>
                        <div class="status-update-action">
                            <select name="estado_id" id="estado_id">
                                <?php foreach($todos_los_estados as $estado): ?>
                                    <option value="<?php echo $estado['id']; ?>" <?php echo $estado['id'] == $pedido['estado_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($estado['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="button button-small">Actualizar</button>
                        </div>
                    </form>
                </div>
                <div class="summary-card">
                    <h3>Datos del Cliente</h3>
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($pedido['cliente_nombre']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($pedido['cliente_email']); ?></p>
                    <p><strong>Dirección de Envío:</strong><br><?php echo nl2br(htmlspecialchars($pedido['direccion_envio_texto'])); ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require(BASE_PATH . '/views/admin/partials/footer.php'); ?>