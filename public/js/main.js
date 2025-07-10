document.addEventListener('DOMContentLoaded', function() {
    
    // Temporizador para Alertas de PHP
    const alertElement = document.querySelector('.alert');
    if (alertElement) {
        setTimeout(() => {
            alertElement.classList.add('fade-out');
            alertElement.addEventListener('animationend', () => alertElement.remove());
        }, 3000);
    }

    // el cosito de productos el carrusel de inicio de home
    if (document.querySelector('.swiper-container')) {
        const swiper = new Swiper('.swiper-container', {
            loop: true, slidesPerView: 1, spaceBetween: 30,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                768: { slidesPerView: 3, spaceBetween: 30 },
                1024: { slidesPerView: 4, spaceBetween: 30 }
            }
        });
    }

    const sections = document.querySelectorAll('.scroll-section');
    const navLinks = document.querySelectorAll('header nav a[data-section]');
    if (sections.length > 0 && navLinks.length > 0) {
        window.addEventListener('scroll', () => {
            let currentSectionId = '';
            sections.forEach(section => {
                if (pageYOffset >= (section.offsetTop - 150)) {
                    currentSectionId = section.getAttribute('id');
                }
            });
            navLinks.forEach(link => {
                const li = link.parentElement;
                li.classList.remove('current');
                if (link.dataset.section === currentSectionId) {
                    li.classList.add('current');
                }
            });
        });
    }

    const hamburger = document.getElementById('hamburger-menu');
    const navWrapper = document.getElementById('navigation-wrapper');
    if (hamburger && navWrapper) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('is-active');
            navWrapper.classList.toggle('is-active');
        });
    }

    // AJAX LISTA DE DESEADOS
    document.querySelectorAll('.wishlist-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation(); 

            const url = this.href;
            const iconButton = this;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.action === 'added') {
                            iconButton.classList.add('is-active');
                            iconButton.title = 'Quitar de Deseados';
                        } else { // 'removed'
                            iconButton.classList.remove('is-active');
                            iconButton.title = 'Añadir a Deseados';
                        }
                    } else if (data.message === 'Login requerido') {
                        window.location.href = '/malvishop/public/login';
                    }
                })
                .catch(error => console.error('Error de red:', error));
        });
    });

    // Lógica AJAX para añadir al carrito y mostrar el minimodal
    const miniCartModal = document.getElementById('mini-cart-modal');
    
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            fetch(this.href)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if(miniCartModal) miniCartModal.classList.add('show');
                        updateCartCounter(data.cart_total);
                    } else if (data.message === 'Login requerido') {
                        window.location.href = '/malvishop/public/login';
                    }
                }).catch(error => console.error('Error:', error));
        });
    });

    // Lógica para cerrar el minimodal
    if (miniCartModal) {
        miniCartModal.addEventListener('click', function(event) {
            if (event.target.matches('.close-button') || event.target.matches('.close-modal-btn') || event.target.id === 'mini-cart-modal') {
                miniCartModal.classList.remove('show');
            }
        });
    }
    
    function updateCartCounter(count) {
        const cartCounter = document.querySelector('.cart-counter');
        if (cartCounter) {
            cartCounter.textContent = count;
            cartCounter.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    // Filtrado Automático de Productos
    const filtrosForm = document.querySelector('.filtros-form');
    if (filtrosForm) {
        const autoSubmitSelects = filtrosForm.querySelectorAll('select');
        const debouncedInputs = filtrosForm.querySelectorAll('input[type="number"], input[type="search"]');
        let debounceTimer;

        autoSubmitSelects.forEach(select => {
            select.addEventListener('change', () => {
                filtrosForm.submit();
            });
        });

        debouncedInputs.forEach(input => {
            input.addEventListener('input', () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    filtrosForm.submit();
                }, 600);
            });
        });
    }

    
});
