<?php

class LobbyController
{
    private $renderer;
    private $usuarioModel;
    private $rankingModel;

    public function __construct($usuarioModel, $renderer, $rankingModel)
    {
        $this-> usuarioModel= $usuarioModel;
        $this->renderer = $renderer;
        $this->rankingModel = $rankingModel;
    }

    public function irAlLobby()
    {
        if(!isset($_SESSION["id"])){
            header("Location:/login/irAlLogin");
            exit;
        }

    $usuario= $this->usuarioModel->getUsuario($_SESSION["id"]);
    /*$partidasActivas = $this->usuarioModel->getPartidasActivas($_SESSION["id"]);*/
    $historial = $this->usuarioModel->getHistorial($_SESSION["id"]) ?? [];
    $puntajeTotal = $this->usuarioModel->getPuntajeTotal($_SESSION["id"]);
    $rankingUsuarios = $this->rankingModel->rankearUsuarios();
    $posicion="-";
    foreach($rankingUsuarios as $u){
        if($u["id"] == $usuario["id"]){
            $posicion = $u["posicion"];
            break;
        }
    }
    $data=[
         "nombreUsuario" => $usuario["nombre_usuario"],
         "puntaje" => $puntajeTotal,
         "fotoPerfil" => $usuario["foto_perfil"],
         "ranking" => $posicion,
       /*  "partidasActivas" => $partidasActivas,*/
         "historial" => $historial
    ];


    $this->renderer->render("lobbyView", $data);
}
















}