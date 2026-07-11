<?php
const PUBLICO = '__publico__';

return [
    'home' => [
        'irAlHome' => [PUBLICO],
    ],
    'login' => [
        'irAlLogin'  => [PUBLICO],
        'autenticar' => [PUBLICO],
        'logout'     => ['jugador', 'editor', 'admin'],
    ],
    'usuario' => [
        'irAlRegistro'     => [PUBLICO],
        'procesarRegistro' => [PUBLICO],
        'confirmarCuenta'  => [PUBLICO],
        'verPerfil'        => ['jugador', 'editor', 'admin'],
        'editarPerfil'     => ['jugador', 'editor', 'admin'],
        'guardarPerfil'    => ['jugador', 'editor', 'admin'],
    ],
    'editor' => [
        'irAPanelEditor'              => ['editor'],
        'mostrarPreguntasReportadas'  => ['editor'],
        'mostrarPreguntasSugeridas'   => ['editor'],
        'aprobarPreguntaSugerida'     => ['editor'],
        'rechazarPreguntaSugerida'    => ['editor'],
        'mostrarFormularioModificar'  => ['editor'],
        'modificarPregunta'           => ['editor'],
        'ignorarReporte'              => ['editor'],
        'darDeBajaPregunta'           => ['editor'],
        'irACrearCategoria'           => ['editor'],
        'agregarCategoria'            => ['editor'],
    ],
    'admin' => [
        'verEstadisticas' => ['admin'],
        'usuarios'        => ['admin'],
        'irAlHome'        => ['admin'],
    ],
    'partida' => [
        'crearPartida'       => ['jugador'],
        'jugar'              => ['jugador'],
        'procesarRuleta'     => ['jugador'],
        'verPregunta'        => ['jugador'],
        'verificarRespuesta' => ['jugador'],
        'tiempoExpirado'     => ['jugador'],
    ],
    'lobby' => [
        'irAlLobby' => ['jugador'],
    ],
    'ranking' => [
        'irAlRanking' => ['jugador', 'editor', 'admin'],
    ],
    'pregunta' => [
        'irACrearPregunta' => ['jugador'],
        'enviarARevision'  => ['jugador'],
        'reportarPregunta' => ['jugador'],
    ],
];