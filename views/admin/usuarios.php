<?php require(BASE_PATH . '/views/admin/partials/header.php'); ?>

<main class="admin-main">
    <div class="admin-container">
        <div class="admin-page-header">
            <h1 class="admin-title">Gestionar Usuarios</h1>
        </div>

        <?php
        if (isset($_SESSION['flash_message'])) {
            $alert = $_SESSION['flash_message'];
            require(BASE_PATH . '/views/partials/alert.php');
            unset($_SESSION['flash_message']);
        }
        ?>

        <!-- buscador dinámico -->
        <form method="get" class="admin-search-form" style="margin-bottom: 20px;">
            <input type="text" id="buscar" name="buscar" placeholder="Buscar por nombre, apellido o email..." value="<?php echo htmlspecialchars($_GET['buscar'] ?? ''); ?>" autocomplete="off">
        </form>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No hay usuarios para mostrar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td class="product-image-cell">
                                    <img src="<?php echo htmlspecialchars($baseUrl); ?>/images/users/<?php echo htmlspecialchars($usuario['foto_perfil'] ?? 'default.png'); ?>" alt="Foto de <?php echo htmlspecialchars($usuario['nombre']); ?>" class="product-list-image">
                                </td>
                                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td><?php echo htmlspecialchars(ucfirst($usuario['nombre_rol'])); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $usuario['activo'] ? 'status-active' : 'status-inactive'; ?>">
                                        <?php echo $usuario['activo'] ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/editar_usuario/<?php echo $usuario['id']; ?>" class="action-btn edit-btn">Editar</a>
                                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/eliminar_usuario/<?php echo $usuario['id']; ?>" class="action-btn delete-btn" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario? Esta acción no se puede deshacer.');">Eliminar</a>
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
                // Conservar filtros al paginar
                $query_string = http_build_query(['buscar' => $_GET['buscar'] ?? '']);
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
// buscador dinámico con debounce
const inputBuscar = document.getElementById('buscar');
let timeoutId;

inputBuscar.addEventListener('input', () => {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
        const query = inputBuscar.value.trim();
        const url = new URL(window.location.href);
        if (query) {
            url.searchParams.set('buscar', query);
        } else {
            url.searchParams.delete('buscar');
        }
        url.searchParams.delete('pagina'); // resetear página al buscar
        window.location.href = url.toString();
    }, 600); // espera 600ms después de que el usuario deja de tipear
});
</script>

<?php require(BASE_PATH . '/views/admin/partials/footer.php'); ?>
