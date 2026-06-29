<?php
class LoginController
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
    public function irAlLogin()
    {
        $data = [];

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }

        if (isset($_SESSION['error'])) {
            $data['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        $this->renderer->render("loginView", $data);
    }
    public function autenticar()
    {
        $usuario = $this->request->post("usuario");
        $contrasenia = $this->request->post("contrasenia");

        if (empty($usuario) || empty($contrasenia)) {
            $this->renderer->render("loginView", [
                "error" => "campos vacios"
            ]);
            return;
        }
        $user = $this->model->getUsuarioByName($usuario);

        if ($user == null || !password_verify($contrasenia, $user["contrasena"])) {
            $this->renderer->render("loginView", [
                "error" => "usuario o contraseña incorrectos"
            ]);
            return;
        }

        if ($user["verificado"] == 0) {
            $this->renderer->render("loginView", [
                "error" => "Debes verificar tu correo antes de iniciar sesión"
            ]);
            return;
        }
        $_SESSION["id"] = $user["id"];
        $_SESSION["usuario"] = $user["nombre_usuario"];
        $_SESSION["rol"] = $user["rol"];

        switch ($user["rol"]) {
            case "editor":
                header("Location: /editor/irAPanelEditor");
                break;

            case "jugador":
            default:
                header("Location: /lobby/irAlLobby");
                break;
        }

        exit();
//        $_SESSION["id"] = $user["id"];
//        $_SESSION["usuario"] = $user["nombre_usuario"];
//        header("Location: /lobby/irAlLobby");
//        exit;
    }
    public function logout()
    {
        session_destroy();

        header("Location:/login/irAlLogin");
        exit;
    }
}
