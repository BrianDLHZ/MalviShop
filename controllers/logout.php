<?php
// malvishop/controllers/logout.php

//Limpiamos y destruimos la sesión del usuario
$_SESSION = [];
session_destroy();

// Borramos la cookie de sesión del navegador
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 3600,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
);

// Preparamos el mensaje para la vista del logout
$alert = [
    'type' => 'success', 
    'message' => 'Has cerrado sesión correctamente. ¡Vuelve pronto!'
];

require BASE_PATH . '/views/logout.php';

exit();