<?php require('partials/header.php'); ?>

<div class="form-container">
    <form action="<?php echo htmlspecialchars($baseUrl); ?>/register" method="POST" id="register-form" novalidate>
        <h2>Crear una Cuenta</h2>

        <?php if (isset($errors['general'])): ?>
            <p class="error-message general-error"><?php echo $errors['general']; ?></p>
        <?php endif; ?>
        
        <fieldset>
            <legend>Información Personal</legend>
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($old_input['nombre'] ?? ''); ?>" required>
                    <small class="error-message"><?php echo $errors['nombre'] ?? ''; ?></small>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($old_input['apellido'] ?? ''); ?>" required>
                    <small class="error-message"><?php echo $errors['apellido'] ?? ''; ?></small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="dni">DNI (formato: XX.XXX.XXX)</label>
                    <input type="text" id="dni" name="dni" value="<?php echo htmlspecialchars($old_input['dni'] ?? ''); ?>" maxlength="10" required>
                    <small class="error-message"><?php echo $errors['dni'] ?? ''; ?></small>
                </div>
                <div class="form-group">
                    <label for="cuit_cuil">CUIL/CUIT (formato: XX-XXXXXXXX-X)</label>
                    <input type="text" id="cuit_cuil" name="cuit_cuil" value="<?php echo htmlspecialchars($old_input['cuit_cuil'] ?? ''); ?>" maxlength="13" required>
                    <small class="error-message"><?php echo $errors['cuit_cuil'] ?? ''; ?></small>
                </div>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono (Opcional)</label>
                <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($old_input['telefono'] ?? ''); ?>" maxlength="15">
                <small class="error-message"><?php echo $errors['telefono'] ?? ''; ?></small>
            </div>
        </fieldset>

        <fieldset>
            <legend>Información de Cuenta</legend>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" required>
                <small class="error-message"><?php echo $errors['email'] ?? ''; ?></small>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Contraseña (mínimo 8 caracteres)</label>
                    <input type="password" id="password" name="password" required>
                    <div id="password-strength-meter" class="password-strength-meter"></div>
                    <small id="password-strength-text" class="strength-text"></small>
                    <small class="error-message"><?php echo $errors['password'] ?? ''; ?></small>
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirmar Contraseña</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                    <small class="error-message"><?php echo $errors['password_confirm'] ?? ''; ?></small>
                </div>
            </div>
        </fieldset>
        
        <fieldset>
            <legend>Información de Envío</legend>
            <div class="form-row">
                <div class="form-group">
                    <label for="direccion">Dirección (Calle y Número)</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($old_input['direccion'] ?? ''); ?>" required>
                    <small class="error-message"><?php echo $errors['direccion'] ?? ''; ?></small>
                </div>
                <div class="form-group">
                    <label for="codigo_postal">Código Postal</label>
                    <input type="text" id="codigo_postal" name="codigo_postal" value="<?php echo htmlspecialchars($old_input['codigo_postal'] ?? ''); ?>" required>
                    <small class="error-message"><?php echo $errors['codigo_postal'] ?? ''; ?></small>
                </div>
            </div>
            <div class="form-group">
                <label for="descripcion_fachada">Descripción de la fachada (Opcional)</label>
                <textarea id="descripcion_fachada" name="descripcion_fachada" rows="3" maxlength="255"><?php echo htmlspecialchars($old_input['descripcion_fachada'] ?? ''); ?></textarea>
                <small class="error-message"><?php echo $errors['descripcion_fachada'] ?? ''; ?></small>
            </div>
        </fieldset>

        <button type="submit" class="button">Crear Cuenta</button>
        <p class="form-footer">¿Ya tienes una cuenta? <a href="<?php echo htmlspecialchars($baseUrl); ?>/login">Inicia sesión</a></p>
    </form>
</div>

<?php require('partials/footer.php'); ?>