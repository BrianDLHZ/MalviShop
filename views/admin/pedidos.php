<?php require(BASE_PATH . '/views/admin/partials/header.php'); ?>

<main class="admin-main">
    <div class="admin-container">
        <div class="admin-page-header">
            <h1 class="admin-title">Gestionar Pedidos</h1>
        </div>

        <?php
        if (isset($_SESSION['flash_message'])) {
            $alert = $_SESSION['flash_message'];
            require(BASE_PATH . '/views/partials/alert.php');
            unset($_SESSION['flash_message']);
        }
        ?>

        <!-- formulario de búsqueda y filtro -->
        <form method="get" class="admin-search-form" style="margin-bottom: 20px;">
            <input
                type="text"
                name="buscar"
                id="buscar"
                placeholder="Buscar por cliente o estado..."
                value="<?php echo htmlspecialchars($_GET['buscar'] ?? ''); ?>"
                autocomplete="off"
            >
            <select name="estado">
                <option value="">-- Estado --</option>
                <?php
                $estados = ['Pendiente', 'Procesando', 'Enviado', 'Completado', 'Cancelado'];
                $estado_seleccionado = $_GET['estado'] ?? '';
                foreach ($estados as $estado):
                    $selected = ($estado_seleccionado === $estado) ? 'selected' : '';
                ?>
                    <option value="<?php echo $estado; ?>" <?php echo $selected; ?>><?php echo $estado; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="button button-small">Filtrar</button>
        </form>

        <div class="table-container">
            <table class="admin-table orders-table">
                <thead>
                    <tr>
                        <th>Pedido #</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pedidos)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No hay pedidos para mostrar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($pedido['id']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['cliente_nombre']); ?></td>
                                <td><?php echo date("d/m/Y H:i", strtotime($pedido['fecha_pedido'])); ?></td>
                                <td>$<?php echo number_format($pedido['total_pedido'], 2, ',', '.'); ?></td>
                                <td>
                                    <?php 
                                    $estado_clase = strtolower(str_replace(' ', '-', $pedido['estado_nombre'])); 
                                    ?>
                                    <span class="status-badge status-<?php echo $estado_clase; ?>">
                                        <?php echo htmlspecialchars($pedido['estado_nombre']); ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/pedido/<?php echo $pedido['id']; ?>" class="action-btn view-btn">Ver</a>
                                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/eliminar_pedido/<?php echo $pedido['id']; ?>" class="action-btn delete-btn" onclick="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_paginas > 1): ?>
            <nav class="paginacion">
                <ul>
                    <?php
                    // Conservarmos los filtros al paginar
                    $query_string = http_build_query([
                        'buscar' => $_GET['buscar'] ?? '',
                        'estado' => $_GET['estado'] ?? ''
                    ]);
                    ?>
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="<?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                            <a href="?<?php echo $query_string . '&pagina=' . $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</main>

<script>
    // busqueda dinámica con debounce (espera a que el usuario termine de tipear para aplicar la busqueda)
    const buscarInput = document.getElementById('buscar');
    let timeoutId = null;

    buscarInput.addEventListener('input', () => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            // al cambiar el input, submitimos el formulario para filtrar
            buscarInput.form.submit();
        }, 600);
    });
</script>

<?php require(BASE_PATH . '/views/admin/partials/footer.php'); ?>
