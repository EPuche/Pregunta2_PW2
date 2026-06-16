<?php

class PartidaController
{
    private $model;
    private $renderer;
    private $request;

    public function __construct($model, $renderer, $request)
    {
        $this->model    = $model;
        $this->renderer = $renderer;
        $this->request  = $request;
    }

    public function crearPartida()
    {
        $this->renderer->render("ruletaView");
    }
    public function procesarRuleta() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $categoria = $_POST['categoria'];
            $preguntaSeleccionada = $this->model->getPreguntaAleatoriaPorCategoria($categoria);
            $idPregunta = $preguntaSeleccionada['id'];
            $opciones = $this->model->getOpcionesPorPregunta($idPregunta);

            $_SESSION['pregunta_actual'] = $preguntaSeleccionada;
            $_SESSION['opciones_actuales'] = $opciones;
            header("Location: /partida/verPregunta");
            exit;
        }

    }

    public function verPregunta() {
        $pregunta = $_SESSION['pregunta_actual'];
        $opciones = $_SESSION['opciones_actuales'];
        $data = [
            "id" => $pregunta['id'],
            "contenido" => $pregunta['contenido'],
            "color" => $pregunta['color'],
            "opciones"  => $opciones
        ];
        $this->renderer->render("partidaView", $data);
    }


    public function verificarRespuesta() {
        if (isset($_POST['opcion_elegida'])) {
            $idOpcionElegida = $_POST['opcion_elegida'];
            $opciones = $_SESSION['opciones_actuales'];
            $pregunta = $_SESSION['pregunta_actual'];

            foreach ($opciones as &$opcion) {
                $opcion['es_elegida'] = ($opcion['id'] == $idOpcionElegida);

                $opcion['mostrar_correcta'] = ($opcion['es_correcta'] == 1);
                $opcion['mostrar_incorrecta'] = ($opcion['es_elegida'] && $opcion['es_correcta'] == 0);
            }

            $data = [
                "id" => $pregunta['id'],
                "contenido" => $pregunta['contenido'],
                "opciones"  => $opciones,
                "ya_respondio" => true
            ];

            unset($_SESSION['pregunta_actual']);
            unset($_SESSION['opciones_actuales']);
            $this->renderer->render("partidaView", $data);
        } else {
            header("Location: /partida/crearPartida");
            exit;
        }
    }






}