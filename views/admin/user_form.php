<?php require(BASE_PATH . '/views/admin/partials/header.php'); ?>

<main class="admin-main">
    <div class="admin-container">
        <div class="admin-page-header">
            <h1 class="admin-title">Editar Usuario</h1>
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/usuarios" class="button">Volver a la Lista</a>
        </div>
        
        
        <div class="form-container-admin">
            <form action="<?php echo htmlspecialchars($baseUrl); ?>/admin/editar_usuario/<?php echo $usuario['id']; ?>" method="POST">
                
                <?php if (!empty($errors)): ?>
                    <?php endif; ?>

                <fieldset>
                    <legend>Datos del Usuario</legend>
                    <div class="form-row-admin">
                        <div class="form-group-admin">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                        </div>
                        <div class="form-group-admin">
                            <label for="apellido">Apellido</label>
                            <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group-admin">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

                </fieldset>

                <fieldset>
                    <legend>Rol y Estado</legend>
                     <div class="form-row-admin">
                        <div class="form-group-admin">
                            <label for="rol_id">Rol del Usuario</label>
                            <select id="rol_id" name="rol_id">
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?php echo $rol['id']; ?>" <?php if ($rol['id'] == $usuario['rol_id']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars(ucfirst($rol['nombre_rol'])); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group-admin form-checkbox-group" style="justify-content: flex-start;">
                            <label>
                                <input type="checkbox" name="activo" value="1" <?php if ($usuario['activo']) echo 'checked'; ?>>
                                Usuario Activo
                            </label>
                        </div>
                    </div>
                </fieldset>

                <button type="submit" class="button button-primary">Actualizar Usuario</button>
            </form>
        </div>
    </div>
</main>

<?php require(BASE_PATH . '/views/admin/partials/footer.php'); ?>