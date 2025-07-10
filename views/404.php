<?php 
require('partials/header.php'); 
?>

<div class="container" style="text-align: center; padding: 80px 20px;">
    <h1 style="font-size: 5rem; margin:0;">404</h1>
    <h2>Página No Encontrada</h2>
    <p style="margin-top: 20px;">Lo sentimos, la página que estás buscando no se ha podido encontrar.</p>
    <p style="margin-top: 30px;">
        <a href="<?php echo empty($baseUrl) ? '/' : htmlspecialchars($baseUrl); ?>" class="button">Volver al Inicio</a>
    </p>
</div>

<?php require('partials/footer.php'); ?>