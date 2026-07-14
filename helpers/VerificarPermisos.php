<?php
// helpers/verificarPermisos.php

function verificarPermisos(string $controllerNombre, string $methodNombre): void
{
    $permisos = require_once __DIR__ . '/../config/permisos.php';

    $rolesPermitidos = $permisos[$controllerNombre][$methodNombre] ?? null;

    if ($rolesPermitidos === null) {
        http_response_code(404);
        die('Acción no definida');
    }

    if (in_array(PUBLICO, $rolesPermitidos, true)) {
        return;
    }

    $rol = $_SESSION['rol'] ?? null;

    if ($rol === null) {
        header("Location: /");
        exit;
    }

    if (!in_array($rol, $rolesPermitidos, true)) {
        http_response_code(403);
        die('Acceso denegado: no tenés permisos para esta acción');
    }
}