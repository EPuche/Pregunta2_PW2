<?php

class PreguntaController
{
    private $renderer;
    private $preguntaModel;

    public function __construct($preguntaModel, $renderer)
    {
        $this->preguntaModel = $preguntaModel;
        $this->renderer = $renderer;
    }

    public function irACrearPregunta()
    {
        $data = [];

        $data['logoHref'] = $_SESSION['logoHref'] ?? '/lobby/irAlLobby';
        $this->renderer->render("crearPreguntaView", $data);
    }


    public function enviarARevision()
    {
        $opcionCorrecta = (int)($_POST['opcionCorrecta'] ?? 0);
        if (empty($_POST['pregunta']) || empty($_POST['opcionCorrecta']) || empty($_POST['categoria'])) {
            return;
        }
        if ($opcionCorrecta < 1 || $opcionCorrecta > 4) {
            return;
        }
        $datosPregunta = new PreguntaDTO($_POST);
        $this->preguntaModel->crearNuevaPregunta($datosPregunta);
        $redirect = $_SESSION['logoHref'];
        header("Location: $redirect");
        exit();
    }
    public function reportarPregunta()
    {
        $idPregunta = $_POST['id_pregunta'];
        $motivo = $_POST['motivo'];

        if (!empty($idPregunta) && !empty($motivo)) {
            $this->preguntaModel->guardarReporte($idPregunta, $motivo);
        }
        $redirect = $_SESSION['logoHref'];
        header("Location: $redirect");
        exit();
    }
}
