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
            $this->renderer->render("loginView", ["error" => "campos vacios"]);
            return;
        }

        $user = $this->model->getUsuarioByName($usuario);

        if ($user == null || !password_verify($contrasenia, $user["contrasena"])) {
            $this->renderer->render("loginView", ["error" => "usuario o contraseña incorrectos"]);
            return;
        }

        if ($user["verificado"] == 0) {
            $this->renderer->render("loginView", ["error" => "Debes verificar tu correo antes de iniciar sesión"]);
            return;
        }

        // Guardar datos en sesión
        $_SESSION["id"] = $user["id"];
        $_SESSION["usuario"] = $user["nombre_usuario"];
        $_SESSION["rol"] = $user["rol"];

        // Definir logoHref según rol
        switch ($user["rol"]) {
            case "admin":
                $_SESSION["logoHref"] = "/admin/verEstadisticas";
                header("Location: /admin/verEstadisticas");
                break;
            case "editor":
                $_SESSION["logoHref"] = "/editor/irAPanelEditor";
                header("Location: /editor/irAPanelEditor");
                break;
            default:
                $_SESSION["logoHref"] = "/lobby/irAlLobby";
                header("Location: /lobby/irAlLobby");
                break;
        }

        exit();
    }

    public function logout()
    {
        session_destroy();

        header("Location:/login/irAlLogin");
        exit;
    }
}
