document.addEventListener('DOMContentLoaded', () => {
    const filtrosForm = document.querySelector('.filtros-form');
    
    // Si el formulario de filtros no existe en la pag, no hacemos nada.
    if (!filtrosForm) return;

    // seleccionamos los diferentes tipos de filtros
    const autoSubmitSelects = filtrosForm.querySelectorAll('select');
    const debouncedInputs = filtrosForm.querySelectorAll('input[type="number"], input[type="search"]');
    let debounceTimer;

    // Para los menús desplegables (categoria y marca), el filtro se aplica al instante.
    autoSubmitSelects.forEach(select => {
        select.addEventListener('change', () => {
            filtrosForm.submit();
        });
    });

    // para los campos de texto (búsqueda, precios), esperamos a que el usuario deje de teclear.
    debouncedInputs.forEach(input => {
        input.addEventListener('input', () => {
            clearTimeout(debounceTimer); // Reinicia el temporizador con cada tecla presionada
            debounceTimer = setTimeout(() => {
                filtrosForm.submit();
            }, 600); // 600 milisegundos de espera
        });
    });
});