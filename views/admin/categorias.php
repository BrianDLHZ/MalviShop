<?php require(BASE_PATH . '/views/admin/partials/header.php'); ?>

<main class="admin-main">
    <div class="admin-container">
        <div class="admin-page-header">
            <h1 class="admin-title">Gestionar Categorías</h1>
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/agregar_categoria" class="button button-primary">Añadir Nueva Categoría</a>
        </div>

        <?php
        if (isset($_SESSION['flash_message'])) {
            $alert = $_SESSION['flash_message'];
            require(BASE_PATH . '/views/partials/alert.php');
            unset($_SESSION['flash_message']);
        }
        ?>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th>Categoría Padre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
    <?php if (empty($categorias)): ?>
        <tr>
            <td colspan="5" style="text-align: center;">No hay categorías para mostrar.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($categorias as $categoria): ?>
            <tr>
                <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                <td><strong><?php echo htmlspecialchars($categoria['nombre']); ?></strong></td>
                <td><?php echo htmlspecialchars($categoria['slug']); ?></td>
                <td><?php echo htmlspecialchars($categoria['nombre_padre'] ?? 'Ninguna'); ?></td>
                <td class="actions-cell">
                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/editar_categoria/<?php echo $categoria['id']; ?>" class="action-btn edit-btn">Editar</a>
                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/eliminar_categoria/<?php echo $categoria['id']; ?>" class="action-btn delete-btn" onclick="return confirm('¿Estás seguro de que quieres eliminar esta categoría?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>
            </table>
        </div>
    </div>
</main>

<?php require(BASE_PATH . '/views/admin/partials/footer.php'); ?>