<?php require('partials/header.php'); ?>

<div class="container" style="text-align: center; padding: 60px 20px; max-width: 600px; margin: 60px auto;">
    
    <?php 
    // usamos el componente de alerta para mostrar el mensaje de éxito
    require(BASE_PATH . '/views/partials/alert.php'); 
    ?>

    <p style="margin-top: 30px; font-size: 1.1rem; color: #555;">
        Serás redirigido a la página de inicio en 3 segundos...
    </p>

    <p style="margin-top: 20px;">
        Si no eres redirigido, <a href="<?php echo empty($baseUrl) ? '/' : htmlspecialchars($baseUrl); ?>">haz clic aquí</a>.
    </p>

</div>

<script>
    setTimeout(function() {
        window.location.href = '<?php echo empty($baseUrl) ? '/' : htmlspecialchars($baseUrl); ?>';
    }, 3000); 
</script>

<?php require('partials/footer.php'); ?>