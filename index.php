<?php
require_once __DIR__ . '/helpers/Autoloader.php';
require_once __DIR__ . '/vendor/autoload.php';
session_start();
$config = new Configurator();
$router = $config->getRouter();

$router->dispatch(
    $_GET['controller'] ?? '',
        $_GET['method'] ?? ''
);




