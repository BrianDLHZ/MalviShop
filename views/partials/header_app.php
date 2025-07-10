<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MalviShop</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/footer.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/header_app.css">
    
    <?php
    if ($request_path === '/productos' || strpos($request_path, '/producto/') === 0) {
        echo '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl) . '/css/productos.css">';
        echo '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl) . '/css/producto.css">';
    }
    if ($request_path === '/carrito') {
        echo '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl) . '/css/carrito.css">';
    }

    if ($request_path === '/checkout') {
        echo '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl) . '/css/checkout.css">';
    }

    if ($request_path === '/pedidos') {
        echo '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl) . '/css/pedidos.css">';
    }

    if ($request_path === '/perfil') {
        echo '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl) . '/css/perfil.css">';
    }

        if (strpos($request_path, '/pedido_detalle/') === 0) {
        echo '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl) . '/css/pedido_detalle.css">';
    }

        if ($request_path === '/deseados') {
        // Cargamos el CSS de productos porque la grilla es la misma
        echo '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl) . '/css/productos.css">';
        echo '<link rel="stylesheet" href="' . htmlspecialchars($baseUrl) . '/css/deseados.css">';
    }
    ?>
    
    
    
</head>
<body>
    <header id="app-header">
        <div class="container">
            <div class="branding">
                <a href="<?php echo htmlspecialchars($baseUrl); ?>"><span class="logo-text">Malvi</span>Shop</a>
            </div>

            <div class="header-actions">
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/deseados" class="action-icon" title="Lista de Deseados">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                </a>
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/carrito" class="action-icon" title="Carrito de Compras">
                    <?php
                    // Calculamos el total de items en el carrito sumando las cantidades
                    $cart_item_count = isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0;
                    if ($cart_item_count > 0):
                    ?>
                        <span class="cart-counter"><?php echo $cart_item_count; ?></span>
                    <?php endif; ?>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </a>

                <div class="user-profile">
                    <img src="<?php echo htmlspecialchars($baseUrl); ?>/images/users/<?php echo htmlspecialchars($_SESSION['user_foto'] ?? 'default.png'); ?>" alt="Foto de perfil">
                    
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_nombre'] . ' ' . $_SESSION['user_apellido']); ?></span>
                    <div class="user-dropdown">
                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/perfil" class="perfil">Perfil</a>
                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/pedidos" class="pedidos">Mis Pedidos</a>
                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/logout" class="logout">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>