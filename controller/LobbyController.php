<?php

class LobbyController
{
    private $renderer;
    private $usuarioModel;
    private $rankingModel;

    public function __construct($usuarioModel, $renderer, $rankingModel)
    {
        $this->usuarioModel = $usuarioModel;
        $this->renderer = $renderer;
        $this->rankingModel = $rankingModel;
    }

    public function irAlLobby()
    {

        if (!isset($_SESSION["id"])) {
            header("Location:/login/irAlLogin");
            exit;
        }

        $usuario = $this->usuarioModel->getUsuario($_SESSION["id"]);
        $historial = $this->usuarioModel->getHistorial($_SESSION["id"]) ?? [];
        $puntajeTotal = $this->usuarioModel->getPuntajeTotal($_SESSION["id"]);
        $trampitas = $this->usuarioModel->getTrampitasTotal($_SESSION["id"]);
        $rankingUsuarios = $this->rankingModel->rankearUsuarios();

        $posicion = "-";
        foreach ($rankingUsuarios as $u) {
            if ($u["id"] == $usuario["id"]) {
                $posicion = $u["posicion"];
                break;
            }
        }

        $fotoPerfil = $usuario["foto_perfil"];
        if (empty($fotoPerfil) || !file_exists($_SERVER["DOCUMENT_ROOT"] . $fotoPerfil)) {
            $fotoPerfil = "/assets/imgPerfiles/default-user.png";
        }

        $data = [
            "nombreUsuario" => $usuario["nombre_usuario"],
            "puntaje" => $puntajeTotal,
            "fotoPerfil" => $fotoPerfil,
            "ranking" => $posicion,
            "trampitas" => $trampitas,
            "historial" => $historial,
            "logoHref" => $_SESSION['logoHref'] ?? '/'
        ];


        if (isset($_SESSION['compra']) && $_SESSION['compra'] === true) {
            $data['compraExitosa'] = true;
            $data['cantidadTrampitas'] = $_SESSION['cantidadTrampitas'];


            unset($_SESSION['compra']);
            unset($_SESSION['cantidadTrampitas']);
        }

        if (isset($_GET['error']) && $_GET['error'] === 'pago_fallido') {
            $data['compraFallida'] = true;
        }

        $this->renderer->render("lobbyView", $data);
    }
}
