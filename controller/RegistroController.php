<?php

class RegistroController {
    private $renderer;

    public function __construct($renderer) {
        $this->renderer = $renderer;
    }

    public function irAlRegistro() {
        $this->renderer->render("registroView"); //
    }


}