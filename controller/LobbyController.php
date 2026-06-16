<?php

class LobbyController
{
    private $renderer;
    private $usuarioModel;

    public function __construct($usuarioModel, $renderer)
    {
        $this-> usuarioModel= $usuarioModel;
        $this->renderer = $renderer;
    }

    public function irAlLobby()
    {
        if(!isset($_SESSION["id"])){
            header("Location:/login/irAlLogin");
            exit;
        }
        /*$this->renderer->render("lobbyView");*/
    

    $usuario= $this -> usuarioModel-> getUsuario($_SESSION["id"]);

    /*$partidasActivas = $this->usuarioModel->getPartidasActivas($_SESSION["id"]);*/
    $historial = $this->usuarioModel->getHistorial($_SESSION["id"]) ?? [];


    $data=[
         "nombreUsuario" => $usuario["nombre_usuario"],
         "puntaje" => $usuario["puntaje"] ?? 0,
         "fotoPerfil" => $usuario["foto_perfil"],
       /*  "partidasActivas" => $partidasActivas,*/
         "historial" => $historial
    ];


    $this->renderer->render("lobbyView", $data);
}
}