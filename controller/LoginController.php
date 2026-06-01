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
        $user= $this->model->getUsuario($usuario);

        if($user && password_verify($contrasenia,$user["contrasenia"])){
            session_start();
            $_SESSION["id"]=$user["id"];
            $_SESSION["usuario"]=$user["usuario"];

            Redirect::to("homeView");
            return;
        }
        Redirect::to("loginView");
    }
}