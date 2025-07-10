<?php
// iconos SVG para cada tipo de alerta
$icons = [
    'success' => '<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>',
    'error' => '<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>',
    'warning' => '<svg viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2V9h2v5z"/></svg>'
];
// obtenemos el tipo de alerta, por defecto error
$alert_type = $alert['type'] ?? 'error';
?>

<div class="alert is-<?php echo htmlspecialchars($alert_type); ?>">
    <div class="alert-icon">
        <?php echo $icons[$alert_type] ?? $icons['error']; // muestra el icono correspondiente ?>
    </div>
    <div class="alert-message">
        <?php echo htmlspecialchars($alert['message']); // Muestra el mensaje ?>
    </div>
</div>