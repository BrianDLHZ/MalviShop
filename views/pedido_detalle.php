<?php require('partials/header_app.php'); ?>

<div class="container page-container">
    <div class="page-header">
        <h1 class="page-title">Detalle del Pedido #<?php echo htmlspecialchars($pedido['id']); ?></h1>
        <a href="<?php echo htmlspecialchars($baseUrl); ?>/pedidos" class="button button-secondary">‹ Volver a Mis Pedidos</a>
    </div>

    <div class="order-detail-layout">
        <div class="order-items-panel">
            <h3>Productos Comprados</h3>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Imagen</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items_del_pedido as $item): ?>
                            <tr>
                                <td class="product-image-cell">
                                    <img src="<?php echo htmlspecialchars($baseUrl); ?>/images/productos/<?php echo htmlspecialchars($item['imagen_principal'] ?? 'placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($item['nombre_producto_snapshot']); ?>" class="product-list-image">
                                </td>
                                <td><?php echo htmlspecialchars($item['nombre_producto_snapshot']); ?></td>
                                <td>$<?php echo number_format($item['precio_unitario_snapshot'], 2, ',', '.'); ?></td>
                                <td>x <?php echo htmlspecialchars($item['cantidad']); ?></td>
                                <td><strong>$<?php echo number_format($item['precio_unitario_snapshot'] * $item['cantidad'], 2, ',', '.'); ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="order-summary-panel">
            <div class="summary-card">
                <h3>Resumen del Pedido</h3>
                <p><strong>Fecha:</strong> <?php echo date("d/m/Y", strtotime($pedido['fecha_pedido'])); ?></p>
                <p><strong>Total:</strong> <span class="total-price">$<?php echo number_format($pedido['total_pedido'], 2, ',', '.'); ?></span></p>
                <p><strong>Estado:</strong> <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $pedido['estado_nombre'])); ?>"><?php echo htmlspecialchars($pedido['estado_nombre']); ?></span></p>
            </div>
            <div class="summary-card">
                <h3>Datos de Envío</h3>
                <p><strong>Dirección:</strong><?php echo nl2br(htmlspecialchars($pedido['direccion_envio_texto'])); ?></p>
                
                <?php if (!empty($usuario['descripcion_fachada'])): ?>
                    <p><strong>Descripción de la Fachada:</strong><br><?php echo nl2br(htmlspecialchars($usuario['descripcion_fachada'])); ?></p>
                <?php endif; ?>

                <?php if (!empty($pedido['notas_cliente'])): ?>
                    <p><strong>Notas Adicionales:</strong><?php echo nl2br(htmlspecialchars($pedido['notas_cliente'])); ?></p>
                <?php endif; ?>

                <p><strong>Método de Pago:</strong> <?php echo htmlspecialchars($metodos_pago_formateados[$pedido['metodo_pago']] ?? $pedido['metodo_pago']); ?></p>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php'); ?>