<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MalviShop - Insumos de Red</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/footer.css">
    
<?php if ($request_path === '/register' || $request_path === '/login'): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/register.css">
<?php endif; ?>

<?php if ($request_path === '/productos' || strpos($request_path, '/producto/') === 0): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/productos.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/producto.css">
<?php endif; ?>
    
</head>
<body>

    <header id="main-header">
        <div class="container">
            <div id="branding">
                <h1><a href="<?php echo empty($baseUrl) ? '/' : htmlspecialchars($baseUrl); ?>"><span class="logo-text">Malvi</span>Shop</a></h1>
            </div>
            
            <button class="hamburger-menu" id="hamburger-menu" aria-label="Abrir menú">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <div class="navigation-wrapper" id="navigation-wrapper">
                <nav>
                    <ul>
                        <li><a href="<?php echo empty($baseUrl) ? '/' : htmlspecialchars($baseUrl); ?>" data-section="hero">Inicio</a></li>
                        <li><a href="<?php echo empty($baseUrl) ? '/' : htmlspecialchars($baseUrl); ?>#productos-destacados-slider" data-section="productos-destacados-slider">Destacados</a></li>
                        <li><a href="<?php echo empty($baseUrl) ? '/' : htmlspecialchars($baseUrl); ?>#quienes-somos" data-section="quienes-somos">Quiénes Somos</a></li>
                        <li><a href="<?php echo htmlspecialchars($baseUrl); ?>/productos" class="button">Catálogo</a></li>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="<?php echo htmlspecialchars($baseUrl); ?>/logout" class="button button-highlight">Cerrar Sesión</a></li>
                            <li class="user-greeting">Hola, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></li>
                        <?php else: ?>
                            <li><a href="<?php echo htmlspecialchars($baseUrl); ?>/login" class="button button-highlight">Iniciar Sesión</a></li>
                            <li><a href="<?php echo htmlspecialchars($baseUrl); ?>/register" class="button button-highlight">Registrarse</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>