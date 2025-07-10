<?php require(BASE_PATH . '/views/admin/partials/header.php'); ?>

<main class="admin-main">
    <div class="admin-container">
        <div class="admin-page-header">
            <h1 class="admin-title"><?php echo isset($categoria) ? 'Editar Categoría' : 'Añadir Nueva Categoría'; ?></h1>
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/categorias" class="button">Volver a la Lista</a>
        </div>
        
        <div class="form-container-admin">
            <form action="<?php echo htmlspecialchars($baseUrl); ?>/admin/<?php echo isset($categoria) ? 'editar_categoria/' . $categoria['id'] : 'agregar_categoria'; ?>" method="POST">
                
                <?php if (!empty($errors)): ?>
                    <div class="alert is-error">
                        <div class="alert-message">
                            <strong>Por favor, corrige el siguiente error:</strong>
                            <p><?php echo $errors[0]; ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <fieldset>
                    <legend>Detalles de la Categoría</legend>
                    <div class="form-group-admin">
                        <label for="nombre">Nombre de la Categoría</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($categoria['nombre'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group-admin">
                        <label for="parent_id">Categoría Padre (opcional)</label>
                        <select id="parent_id" name="parent_id">
                            <option value="">Ninguna</option>
                            <?php foreach ($todas_las_categorias as $cat): ?>
                                <?php if (!isset($categoria) || $cat['id'] !== $categoria['id']): // Evita que una categoría sea su propio padre ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php if (isset($categoria) && $cat['id'] == $categoria['parent_id']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($cat['nombre']); ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </fieldset>

                <button type="submit" class="button button-primary"><?php echo isset($categoria) ? 'Actualizar Categoría' : 'Guardar Categoría'; ?></button>
            </form>
        </div>
    </div>
</main>

<?php require(BASE_PATH . '/views/admin/partials/footer.php'); ?>