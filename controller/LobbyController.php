<?php

class LobbyController
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }

    public function irAlLobby()
    {
        $this->renderer->render("lobbyView");
    }
}