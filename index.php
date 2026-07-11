<?php
require_once __DIR__ . '/helpers/Autoloader.php';
require_once __DIR__ . '/vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None',
    ]);
    session_start();
}

$controllerNombre = $_GET['controller'] ?? '';
$methodNombre     = $_GET['method'] ?? '';

if ($controllerNombre === '' || $controllerNombre === 'index.php') {
    $controllerNombre = 'home';
}
if ($methodNombre === '') {
    $methodNombre = 'irAlHome';
}

$permisos = require __DIR__ . '/config/permisos.php';

$rolesPermitidos = $permisos[$controllerNombre][$methodNombre] ?? null;

if ($rolesPermitidos === null) {
    http_response_code(404);
    die('Acción no definida');
}

if (!in_array(PUBLICO, $rolesPermitidos, true)) {
    $rol = $_SESSION['rol'] ?? null;
    if ($rol === null || !in_array($rol, $rolesPermitidos, true)) {
        http_response_code(403);
        die('Acceso denegado: no tenés permisos para esta acción');
    }
}

$config = new Configurator();
$router = $config->getRouter();

$router->dispatch($controllerNombre, $methodNombre);