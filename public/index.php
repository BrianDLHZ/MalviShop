<?php
session_start();

define('BASE_PATH', dirname(__DIR__));
$baseUrl = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
if ($baseUrl === '/') {
    $baseUrl = '';
}

require BASE_PATH . '/app/Database.php';
$config = require BASE_PATH . '/config/database.php';
$db = new Database($config);

$request_uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$request_path = str_replace($baseUrl, '', $request_uri);
if (empty($request_path)) {
    $request_path = '/';
}

$params = [];
$path_parts = explode('/', trim($request_path, '/'));

$route = $path_parts[0] ?: '/';
$params['action'] = $path_parts[1] ?? 'dashboard';
$params['id'] = $path_parts[2] ?? null;

switch ($route) {
    case '/':
        require BASE_PATH . '/controllers/home.php';
        break;
    case 'productos':
        require BASE_PATH . '/controllers/productos.php';
        break;
    case 'producto':
        $params['slug'] = $params['action'];
        require BASE_PATH . '/controllers/producto.php';
        break;
    case 'register':
        require BASE_PATH . '/controllers/register.php';
        break;
    case 'login':
        require BASE_PATH . '/controllers/login.php';
        break;
    case 'logout':
        require BASE_PATH . '/controllers/logout.php';
        break;
    case 'deseados':
    case 'carrito':
        require BASE_PATH . "/controllers/{$route}.php";
        break;
    case 'checkout':
        require BASE_PATH . '/controllers/checkout.php';
        break;
    case 'pedido_exitoso':
        require BASE_PATH . '/views/pedido_exitoso.php';
        break;
    case 'pedidos':
        require BASE_PATH . '/controllers/pedidos.php';
        break;
    case 'perfil':
        require BASE_PATH . '/controllers/perfil.php';
        break;
    case 'pedido_detalle':
        $params['id'] = $path_parts[1] ?? null; // El ID es la segunda parte de la URL
        require BASE_PATH . '/controllers/pedido_detalle.php';
        break;

        case 'admin':
        // enrutador interno para la sección de administración
        $action = $path_parts[1] ?? 'dashboard';
        $id = $path_parts[2] ?? null;
        
        $params['id'] = $id;

        // Construimos la ruta al controlador del admin
        $admin_controller = BASE_PATH . "/controllers/admin/{$action}.php";
        
        if (file_exists($admin_controller)) {
            require $admin_controller;
        } else {
            http_response_code(404);
            require BASE_PATH . '/views/404.php';
        }
        break; 

    default:
        http_response_code(404);
        require BASE_PATH . '/views/404.php';
        break;
}