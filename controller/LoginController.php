<?php
class LoginController{
    private $model;
    private $renderer;
    private $request;

    public function __construct($model, $renderer, $request){
        $this->model    = $model;
        $this->renderer = $renderer;
        $this->request  = $request;
    }
    public function irAlLogin(){
        $this->renderer->render("loginView");
    }
    public function autenticar(){
        $usuario= $this->request->post("usuario");
        $contrasenia= $this->request->post("contrasenia");

        if(empty($usuario) || empty($contrasenia)){
            $this->renderer->render("loginView",[
                "error" =>"campos vacios"
            ]);
            return;
        }
        $user= $this->model->getUsuarioByName($usuario);

        if($user==null || !password_verify($contrasenia,$user["contrasena"])){
            $this->renderer->render("loginView",[
                "error" =>"usuario o contraseña incorrectos"
            ]);
            return;
        }
        $_SESSION["id"]=$user["id"];
        $_SESSION["usuario"]=$user["nombre_usuario"];

        Redirect::to("/Pregunta2_PW2/index.php?controller=home&method=irAlHome");
    }
}