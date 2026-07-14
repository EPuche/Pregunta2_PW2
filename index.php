<?php
require_once __DIR__ . '/helpers/Autoloader.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers/VerificarPermisos.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

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

verificarPermisos($controllerNombre, $methodNombre);

$config = new Configurator();
$router = $config->getRouter();

$router->dispatch($controllerNombre, $methodNombre);