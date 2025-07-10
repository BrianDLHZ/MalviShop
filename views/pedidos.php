<?php require('partials/header_app.php'); ?>

<div class="container page-container">
    <h1 class="page-title">Mis Pedidos</h1>

    <?php if (empty($pedidos)): ?>
        <div class="cart-empty">
            <p>Aún no has realizado ningún pedido.</p>
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/productos" class="button">Explorar Productos</a>
        </div>
    <?php else: ?>
        <div class="orders-table-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Pedido #</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($pedido['id']); ?></td>
                            <td><?php echo date("d/m/Y", strtotime($pedido['fecha_pedido'])); ?></td>
                            <td>$<?php echo number_format($pedido['total_pedido'], 2, ',', '.'); ?></td>
                            <td>
                                <?php 
                                // creamos una clase CSS a partir del nombre del estado para darle color
                                $estado_clase = strtolower(str_replace(' ', '-', $pedido['estado_nombre'])); 
                                ?>
                                <span class="status-badge status-<?php echo $estado_clase; ?>">
                                    <?php echo htmlspecialchars($pedido['estado_nombre']); ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="<?php echo htmlspecialchars($baseUrl); ?>/pedido_detalle/<?php echo $pedido['id']; ?>" class="button button-secondary button-small">Ver Detalles</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require('partials/footer.php'); ?>