<?php require(BASE_PATH . '/views/admin/partials/header.php'); ?>

<main class="admin-main">
    <div class="admin-container">
        <div class="admin-page-header">
            <h1 class="admin-title">Gestionar Productos</h1>
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/agregar_producto" class="button button-primary">Añadir Nuevo Producto</a>
        </div>

        <?php
        if (isset($_SESSION['flash_message'])) {
            $alert = $_SESSION['flash_message'];
            require(BASE_PATH . '/views/partials/alert.php');
            unset($_SESSION['flash_message']);
        }
        ?>

        <!-- formulario de busqueda y filtro -->
        <form method="get" class="admin-search-form" id="busquedaForm" style="margin-bottom: 20px; display: flex; gap: 10px; align-items: center;">
            <input type="text" name="buscar" id="buscarInput" placeholder="Buscar por nombre o marca..." value="<?php echo htmlspecialchars($buscar); ?>" class="input">
            <select name="estado" id="estadoSelect" class="input">
                <option value="">-- Estado --</option>
                <option value="1" <?php if ($estado === '1') echo 'selected'; ?>>Activo</option>
                <option value="0" <?php if ($estado === '0') echo 'selected'; ?>>Inactivo</option>
            </select>
            <!-- Botón oculto por si alguien presiona enter -->
            <button type="submit" style="display: none;">Buscar</button>
        </form>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($productos)): ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">No hay productos para mostrar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td class="product-image-cell">
                                    <img src="<?php echo htmlspecialchars($baseUrl); ?>/images/productos/<?php echo htmlspecialchars($producto['imagen_principal'] ?? 'placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="product-list-image">
                                </td>
                                <td><?php echo htmlspecialchars($producto['id']); ?></td>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                                <td>$<?php echo number_format($producto['precio'], 2, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $producto['activo'] ? 'status-active' : 'status-inactive'; ?>">
                                        <?php echo $producto['activo'] ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/editar_producto/<?php echo $producto['id']; ?>" class="action-btn edit-btn">Editar</a>
                                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/eliminar_producto/<?php echo $producto['id']; ?>" class="action-btn delete-btn" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_paginas > 1): ?>
            <?php
            // construir parámetros para conservar filtros en la paginación
            $query_params = [];
            if ($buscar !== '') $query_params['buscar'] = $buscar;
            if ($estado === '0' || $estado === '1') $query_params['estado'] = $estado;
            ?>
            <nav class="paginacion">
                <ul>
                    <?php for ($i = 1; $i <= $total_paginas; $i++):
                        $query_params['pagina'] = $i;
                        $url = '?' . http_build_query($query_params);
                    ?>
                        <li class="<?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                            <a href="<?php echo $url; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('buscarInput');
    const form = document.getElementById('busquedaForm');
    const estadoSelect = document.getElementById('estadoSelect');

    let timer;

    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => {
            form.submit();
        }, 500); // 500ms dsp de tipear
    });

    estadoSelect.addEventListener('change', function () {
        form.submit(); // se envía automáticamente al cambiar el estado
    });
});
</script>

<?php require(BASE_PATH . '/views/admin/partials/footer.php'); ?>
