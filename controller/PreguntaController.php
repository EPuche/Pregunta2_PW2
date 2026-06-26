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

    public function irACrearPregunta(){
        $this->renderer->render("crearPreguntaView");
    }


    public function enviarARevision() {
        if (empty($_POST['pregunta']) || empty($_POST['opcionCorrecta'])) {
            return;
        }
        $datosPregunta = new PreguntaDTO($_POST);
        $this->preguntaModel->crearNuevaPregunta($datosPregunta);
        header("Location: /lobby/irAlLobby");
    }


}