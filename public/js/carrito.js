document.addEventListener('DOMContentLoaded', () => {
    const cartContainer = document.querySelector('.cart-items');
    if (!cartContainer) return;

    cartContainer.addEventListener('click', e => {
        if (e.target.matches('.increase-btn')) {
            updateCart(e.target.dataset.id, 'incrementar');
        }
        if (e.target.matches('.decrease-btn')) {
            updateCart(e.target.dataset.id, 'decrementar');
        }
        if (e.target.matches('.remove-item-btn')) {
            e.preventDefault();
            if (confirm) {
                updateCart(e.target.dataset.id, 'eliminar');
            }
        }
    });
});

function formatPrice(number) {
    // convierte el numero a un string con 2 decimales usando la coma como separador decimal
    const options = {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    };
    return new Intl.NumberFormat('es-AR', options).format(number);
}


function updateCart(id, action) {
    const baseUrl = '/malvishop/public';
    fetch(`${baseUrl}/carrito/${action}/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // actualizamos contador del header
                const cartCounter = document.querySelector('.cart-counter');
                if (cartCounter) {
                    cartCounter.textContent = data.cart_total_items;
                    cartCounter.style.display = data.cart_total_items > 0 ? 'flex' : 'none';
                }

                // si el item todavia existe, se actualiza
                if (data.items && data.items[id]) {
                    const item = data.items[id];
                    document.querySelector(`#item-${id} .quantity-input`).value = item.cantidad;
                    const subtotalElement = document.querySelector(`#subtotal-${id}`);
                    if (subtotalElement) {
                        // usamos la nueva función de formateo
                        subtotalElement.textContent = `$${formatPrice(item.subtotal)}`;
                    }
                } else { // si el item fue eliminado
                    const itemElement = document.querySelector(`#item-${id}`);
                    if (itemElement) itemElement.remove();
                }

                // actualizamos los totales del resumen
                const subtotalSummaryElement = document.querySelector('#cart-subtotal');
                if (subtotalSummaryElement) {
                    subtotalSummaryElement.textContent = `$${formatPrice(data.cart_total_price)}`;
                }
                const totalElement = document.querySelector('#cart-total');
                if (totalElement) {
                    totalElement.textContent = `$${formatPrice(data.cart_total_price)}`;
                }
                
                // Si el carrito queda vacio recargamos la página
                if (data.cart_total_items === 0) {
                    location.reload();
                }
            }
        }).catch(error => console.error('Error:', error));
}