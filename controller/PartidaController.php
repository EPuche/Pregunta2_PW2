<?php

class PartidaController
{
    private $preguntaModel;
    private $partidaModel;
    private $renderer;
    private $request;

    public function __construct($preguntaModel, $partidaModel ,$renderer, $request)
    {
        $this->preguntaModel = $preguntaModel;
        $this->partidaModel = $partidaModel;
        $this->renderer = $renderer;
        $this->request  = $request;
    }

    public function crearPartida()
    {
        $this->limpiarDatosDePartidaDeLaSession();

        $idUsuario = $_SESSION["id"];
        $partida = $this->partidaModel->crearPartida($idUsuario);
        $_SESSION["partida"] = $partida;
        $this->renderer->render("ruletaView");

    }

    public function jugar()
    {
        if (!isset($_SESSION["partida"]) || $this->partidaModel->finalizoPartida($_SESSION["partida"])) {
            header("Location: /lobby/irAlLobby");
            exit;
        }

        $this->renderer->render("ruletaView");
    }
    public function procesarRuleta() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $categoria = $_POST['categoria'];
            $preguntaSeleccionada = $this->preguntaModel->getPreguntaAleatoriaPorCategoria($categoria);
            $idPregunta = $preguntaSeleccionada['id'];
            $opciones = $this->preguntaModel->getOpcionesPorPregunta($idPregunta);

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
            "opciones"  => $opciones
        ];
        $this->renderer->render("partidaView", $data);
    }

    public function verificarRespuesta() {
        if (!isset($_POST['opcion_elegida'])) {
            header("Location: /partida/crearPartida");
            exit;
        }
        $idOpcionElegida = $_POST['opcion_elegida'];
        $opciones = $_SESSION['opciones_actuales'];
        $pregunta = $_SESSION['pregunta_actual'];
        $partida = $_SESSION['partida'];

        $idOpcionCorrecta = $this->preguntaModel->procesarOpcionesDeRonda($opciones, $idOpcionElegida);

        $this->partidaModel->respondeCorrectamente($idOpcionElegida, $idOpcionCorrecta, $partida);
        $data = [
            "id"           => $pregunta['id'],
            "contenido"    => $pregunta['contenido'],
            "opciones"     => $opciones,
            "ya_respondio" => true,
            "puntaje"      => $partida->getPuntaje()
        ];

        $this->limpiarPreguntaYOpcionesDeLaSession();
        $this->renderer->render("partidaView", $data);
    }

    /**
     * @return void
     */
    public function limpiarDatosDePartidaDeLaSession(): void
    {
        unset($_SESSION["partida"]);
        unset($_SESSION["pregunta_actual"]);
        unset($_SESSION["opciones_actuales"]);
    }

    /**
     * @return void
     */
    public function limpiarPreguntaYOpcionesDeLaSession(): void
    {
        unset($_SESSION['pregunta_actual']);
        unset($_SESSION['opciones_actuales']);
    }


}