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
        $this->limpiarDatosDeRondaDeLaSession();
        $idUsuario = $_SESSION["id"];
        $partida = $this->partidaModel->crearPartida($idUsuario);
        $data['logoHref'] = $_SESSION['logoHref'];
        $_SESSION["partida"] = $partida;
        $this->renderer->render("ruletaView", $data);

    }

    public function jugar()
    {
        if (!isset($_SESSION["partida"]) || $this->partidaModel->finalizoPartida($_SESSION["partida"])) {
            header("Location: /lobby/irAlLobby");
            exit;
        }
         $data['logoHref'] = $_SESSION['logoHref'];

        $this->renderer->render("ruletaView", $data);
    }
    public function procesarRuleta() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $categoria = $_POST['categoria'];
            $usuarioId = $_SESSION['id'];
            $preguntaSeleccionada = $this->preguntaModel->getPreguntaAleatoriaPorCategoria($categoria, $usuarioId);
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

        if(!isset($_SESSION['tiempo_limite'])){
          $_SESSION['tiempo_limite'] = $this->partidaModel->asignarUnTiempoDeFinalizacionALaRonda();
        }
        $segundos_restantes = $this->partidaModel->calcularSegundosRestantes($_SESSION['tiempo_limite']);
        $data = [
            "id" => $pregunta['id'],
            "contenido" => $pregunta['contenido'],
            "color" => $pregunta['color'],
            "opciones"  => $opciones,
            "tiempo_restante" => $segundos_restantes // Lo mandamos a la vista
        ];
        $data['logoHref'] = $_SESSION['logoHref'];
        $this->renderer->render("partidaView", $data);
    }


    public function verificarRespuesta() {
        $pregunta = $_SESSION['pregunta_actual'];
        $partida = $_SESSION['partida'];

        $idOpcionElegida = $_POST['opcion_elegida'];
        $opciones = $_SESSION['opciones_actuales'];

        $idOpcionCorrecta = $this->preguntaModel->procesarOpcionesDeRonda($opciones, $idOpcionElegida);
        $esCorrecta = $this->partidaModel->respondeCorrectamente($idOpcionElegida, $idOpcionCorrecta, $partida);

        $this->preguntaModel->registrarPreguntaVista($_SESSION['id'], $pregunta['id'], $esCorrecta);
        $data = [
            "id"           => $pregunta['id'],
            "contenido"    => $pregunta['contenido'],
            "opciones"     => $opciones,
            "color"        => $pregunta['color'],
            "ya_respondio" => true,
            "puntaje"      => $partida->getPuntaje()
        ];
        $data['logoHref'] = $_SESSION['logoHref'];
        $this->limpiarDatosDeRondaDeLaSession();
      
        $this->renderer->render("partidaView", $data);
    }
    public function tiempoExpirado(){
        $partida = $_SESSION['partida'];
        $data = [
            "puntaje" => $partida->getPuntaje(),
            "tiempo_expirado" => true
        ];
        $this->limpiarDatosDeRondaDeLaSession();
        $this->partidaModel->finalizarPartida($partida);
        $data['logoHref'] = $_SESSION['logoHref'];
        $this->renderer->render("partidaView", $data);
    }

    /**
     * @return void
     */
    public function limpiarDatosDePartidaDeLaSession(): void
    {
        unset($_SESSION["partida"]);
    }

    /**
     * @return void
     */
    public function limpiarDatosDeRondaDeLaSession(): void
    {
        unset($_SESSION['pregunta_actual']);
        unset($_SESSION['opciones_actuales']);
        unset($_SESSION['tiempo_limite']);
    
        
    }


}