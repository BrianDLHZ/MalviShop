<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - MalviShop</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/admin.css">

<?php
// Evitar error si $params no está definido
if (!isset($params) || !is_array($params)) {
    $params = [];
}
// obtener la acción actual
$action = $params['action'] ?? '';

if (in_array($action, ['agregar_producto', 'editar_producto'])): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/agregar_producto.css">
<?php endif;

if (in_array($action, ['pedidos', 'pedido'])): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/style.css">
    <?php if ($action === 'pedido'): ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/pedido.css">
    <?php endif;
endif;

if ($action === 'editar_usuario'): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/user_form.css">
<?php endif;

if (in_array($action, ['agregar_categoria', 'editar_categoria'])): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/category_form.css">
<?php endif;

if ($action === 'categorias'): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($baseUrl); ?>/css/categorias.css">
<?php endif; ?>

</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin" class="admin-logo">MalviShop Admin</a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="<?php echo ($action === 'dashboard') ? 'active' : ''; ?>">
                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/dashboard">
                            <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="<?php echo (in_array($action, ['productos', 'agregar_producto', 'editar_producto'])) ? 'active' : ''; ?>">
                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/productos">
                            <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm-1 14H5c-.55 0-1-.45-1-1V8h16v9c0 .55-.45 1-1 1z"/></svg>
                            <span>Productos</span>
                        </a>
                    </li>
                    <li class="<?php echo ($action === 'pedidos') ? 'active' : ''; ?>">
                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/pedidos">
                            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4 0h2v7h-2zm4-3h2v10h-2z"/></svg>
                            <span>Pedidos</span>
                        </a>
                    </li>
                    <li class="<?php echo ($action === 'usuarios') ? 'active' : ''; ?>">
                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/usuarios">
                            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    <li class="<?php echo ($action === 'categorias') ? 'active' : ''; ?>">
                        <a href="<?php echo htmlspecialchars($baseUrl); ?>/admin/categorias">
                            <svg viewBox="0 0 24 24"><path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg>
                            <span>Categorías</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <a href="<?php echo htmlspecialchars($baseUrl); ?>/logout" class="logout-link">
                    <svg viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"></path></svg>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </aside>
