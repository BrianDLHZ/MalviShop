<?php require(BASE_PATH . '/views/admin/partials/header.php'); ?>

<main class="admin-main">
    <div class="admin-container">
        <h1 class="admin-title">Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
        <p class="admin-subtitle">Este es el panel de control de MalviShop. Desde aquí podrás gestionar toda la tienda.</p>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Gestionar Productos</h3>
                <p>Añadir, editar o eliminar productos del catálogo.</p>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/productos" class="button">Ir a Productos</a>
            </div>
            <div class="dashboard-card">
                <h3>Ver Pedidos</h3>
                <p>Revisar y actualizar el estado de los pedidos de los clientes.</p>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/pedidos" class="button">Ir a Pedidos</a>
            </div>
            <div class="dashboard-card">
                <h3>Gestionar Usuarios</h3>
                <p>Ver la lista de clientes registrados.</p>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/usuarios" class="button">Ir a Usuarios</a>
            </div>
                <div class="dashboard-card">
                <h3>Gestionar Categorías</h3>
                <p>Ver la lista de las categorías.</p>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/categorias" class="button">Ir a Categorías</a>
            </div>
        </div>
    </div>
</main>

<?php require(BASE_PATH . '/views/admin/partials/footer.php'); ?>