
<?php require('partials/header_app.php');?>
<div class="container" style="text-align: center; padding: 60px 20px;">
    <div class="alert is-success">
        <div class="alert-icon">
            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <div class="alert-message">¡Tu pedido ha sido realizado con éxito!</div>
    </div>
    <p>Gracias por tu compra. Recibirás un correo con los detalles.</p>
    <a href="<?php echo htmlspecialchars($baseUrl); ?>/productos" class="button" style="margin-top: 20px;">Seguir Comprando</a>
</div>
<?php require('partials/footer.php'); ?>