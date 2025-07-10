<?php require('partials/header_app.php'); ?>

<div class="container page-container">
    <h1 class="page-title">Mi Perfil</h1>

    <?php if (!empty($success_message)): ?>
        <div class="alert is-success">
            <div class="alert-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></div>
            <div class="alert-message"><?php echo $success_message; ?></div>
        </div>
    <?php endif; ?>
        
    <div class="profile-layout">
        <div class="profile-section profile-picture-section">
            <h3>Foto de Perfil</h3>
            <img src="<?php echo htmlspecialchars($baseUrl); ?>/images/users/<?php echo htmlspecialchars($usuario['foto_perfil'] ?? 'default.png'); ?>" alt="Foto de Perfil" class="profile-pic-large">
            
            <form action="<?php echo htmlspecialchars($baseUrl); ?>/perfil" method="POST" enctype="multipart/form-data" onsubmit="return confirmarBorrado(event)">
                <div class="form-group">
                    <label for="foto_perfil">Cambiar foto (JPG, PNG - Máx 5MB)</label>
                    <input type="file" id="foto_perfil" name="foto_perfil" accept="image/jpeg, image/png" onchange="toggleSubir()">
                </div>

                <div class="form-button-group">
                    <button type="submit" name="upload_photo" class="button button-small" id="btnSubir" disabled>Subir Foto</button>
                    <button type="submit" name="delete_photo" value="1" class="button button-small is-danger" <?php if (empty($usuario['foto_perfil']) || $usuario['foto_perfil'] === 'default.png') echo 'disabled'; ?>> Eliminar Foto </button>
                </div>
            </form>

            <?php if (isset($errors['foto'])): ?><p class="error-text"><?php echo $errors['foto']; ?></p><?php endif; ?>
        </div>

        <div class="profile-section-group">
            <div class="profile-section">
                <form action="<?php echo htmlspecialchars($baseUrl); ?>/perfil" method="POST" id="personal-data-form">
                    <h3>Datos Personales y de Envío</h3>
                    <?php if (isset($errors['personal'])): ?><p class="error-text"><?php echo $errors['personal']; ?></p><?php endif; ?>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" maxlength="15" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="codigo_postal">Código Postal</label>
                        <input type="text" id="codigo_postal" name="codigo_postal" value="<?php echo htmlspecialchars($usuario['codigo_postal']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion_fachada">Descripción de la fachada</label>
                        <textarea id="descripcion_fachada" name="descripcion_fachada" rows="2"><?php echo htmlspecialchars($usuario['descripcion_fachada']); ?></textarea>
                    </div>

                    <button type="submit" name="update_personal_data" class="button">Guardar Datos</button>
                </form>
            </div>

            <div class="profile-section">
                <form action="<?php echo htmlspecialchars($baseUrl); ?>/perfil" method="POST" id="password-change-form">
                    <h3>Cambiar Contraseña</h3>
                    <?php if (isset($errors['password'])): ?><p class="error-text"><?php echo $errors['password']; ?></p><?php endif; ?>
                    
                    <div class="form-group">
                        <label for="current_password">Contraseña Actual</label>
                        <input type="password" id="current_password" name="current_password">
                    </div>
                    <div class="form-group">
                        <label for="new_password">Nueva Contraseña</label>
                        <input type="password" id="new_password" name="new_password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Nueva Contraseña</label>
                        <input type="password" id="confirm_password" name="confirm_password">
                    </div>
                    <button type="submit" name="change_password" class="button">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSubir() {
    const input = document.getElementById('foto_perfil');
    const btn = document.getElementById('btnSubir');
    btn.disabled = !input.files.length;
}

function confirmarBorrado(event) {
    const clicked = event.submitter;
    if (clicked && clicked.name === 'delete_photo') {
        return confirm('¿Estás seguro de que querés borrar tu foto de perfil? Esta acción no se puede deshacer.');
    }
    return true;
}
</script>

<?php require('partials/footer.php'); ?>
