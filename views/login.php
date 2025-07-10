<?php require('partials/header.php'); ?>

<div class="form-container">
    <form action="<?php echo htmlspecialchars($baseUrl); ?>/login" method="POST" id="login-form" novalidate>
        <h2>Iniciar Sesión</h2>

        <?php
        // si hay un mensaje de éxito desde la pag de registro
        if (isset($_SESSION['flash_message'])) {
            $alert = $_SESSION['flash_message'];
            require(BASE_PATH . '/views/partials/alert.php');
            unset($_SESSION['flash_message']);
        }
        
        // Si hay un error de login en esta misma página
        if (isset($errors['general'])) {
            $alert = ['type' => 'error', 'message' => $errors['general']];
            require(BASE_PATH . '/views/partials/alert.php');
        }
        ?>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            <small class="error-message"></small>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
            <small class="error-message"></small>
        </div>
        <button type="submit" class="button">Iniciar Sesión</button>
        <p class="form-footer">¿No tienes una cuenta? <a href="<?php echo htmlspecialchars($baseUrl); ?>/register">Regístrate aquí</a></p>
    </form>
</div>

<?php require('partials/footer.php'); ?>