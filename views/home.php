<?php require('partials/header.php'); ?>

<section id="hero" class="scroll-section">
    <div class="container">
        <h1>Tu Conexión al Mundo Digital</h1>
        <p>Encuentra los mejores insumos de red para tu hogar y empresa en Malvishop.</p>
        <p><a href="#productos-destacados-slider" class="button">Ver Destacados</a></p>
        
        <a href="#productos-destacados-slider" class="scroll-down-arrow" aria-label="Ir a destacados">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6-1.41-1.41z" />
            </svg>
        </a>
    </div>
</section>

<section id="productos-destacados-slider" class="featured-slider-section scroll-section">
    <div class="container">
        <h2>Destacados de la Semana</h2>
        
        <?php if (!empty($productos_destacados)): ?>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($productos_destacados as $producto): ?>
                    <div class="swiper-slide">
                        <div class="producto-card">
                            <a href="<?php echo htmlspecialchars($baseUrl); ?>/producto/<?php echo htmlspecialchars($producto['slug']); ?>">
                                <img src="<?php echo htmlspecialchars($baseUrl); ?>/images/productos/<?php echo htmlspecialchars($producto['imagen_principal'] ?? 'placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            </a>
                            <div class="producto-card-content">
                                <h3><a href="<?php echo htmlspecialchars($baseUrl); ?>/producto/<?php echo htmlspecialchars($producto['slug']); ?>"><?php echo htmlspecialchars($producto['nombre']); ?></a></h3>
                                <p class="precio">$<?php echo number_format($producto['precio'], 2, ',', '.'); ?></p>
                                
                                <div class="card-actions">
                                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/carrito/agregar/<?php echo htmlspecialchars($producto['id']); ?>" class="button add-to-cart-btn">Añadir al Carrito</a>
                                    
                                    <?php
                                    $es_deseado = isset($deseados_ids) && in_array($producto['id'], $deseados_ids);
                                    ?>
                                    <a href="<?php echo htmlspecialchars($baseUrl); ?>/deseados/agregar/<?php echo htmlspecialchars($producto['id']); ?>" 
                                       class="wishlist-btn <?php echo $es_deseado ? 'is-active' : ''; ?>" 
                                       title="<?php echo $es_deseado ? 'Quitar de Deseados' : 'Añadir a Deseados'; ?>">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        <?php else: ?>
            <p style="text-align: center;">No hay productos destacados esta semana. ¡Vuelve pronto!</p>
        <?php endif; ?>
        
        <div class="view-all-products">
            <a href="<?php echo htmlspecialchars($baseUrl); ?>/productos" class="button">Ver todo el catálogo</a>
        </div>
    </div>
</section>

<section id="quienes-somos" class="scroll-section">
    <div class="container">
        <h2>Sobre Malvishop</h2>
        <p>
            En Malvishop, nacimos de la pasión por la conectividad y la tecnología. Entendemos que una red estable y veloz es la columna vertebral del mundo digital actual, tanto para el trabajo y el estudio como para el entretenimiento.
        </p>
        <p>
            Por eso, nuestra misión es simple: ofrecer una cuidada selección de insumos de red de alta calidad, desde routers y switches hasta cables y accesorios, para satisfacer las necesidades de nuestros clientes. Ya seas un entusiasta que busca optimizar su red doméstica o una empresa que necesita una infraestructura robusta, en Malvishop encontrarás productos confiables y el mejor asesoramiento técnico para llevar tu conexión al siguiente nivel.
        </p>
    </div>
</section>

<?php require('partials/footer.php'); ?>