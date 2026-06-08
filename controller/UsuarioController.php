<?php

class UsuarioController {
    private $renderer;

    public function __construct($model, $renderer, $request) {
        $this->model = $model;
        $this->renderer = $renderer;
        $this->request = $request;
    }

    public function irAlRegistro() {
        $this->renderer->render("registroView"); //
    }

    public function procesarRegistro()
    {
        $nombreCompleto   = $this->request->post('nombre_completo');
        $anioNacimiento   = $this->request->post('anio_nacimiento');
        $sexo             = $this->request->post('sexo');
        $pais             = $this->request->post('pais');
        $ciudad           = $this->request->post('ciudad');
        $email            = $this->request->post('email');
        $nombreUsuario    = $this->request->post('nombre_usuario');
        $contrasena       = $this->request->post('contrasena');
        $repetirContrasena= $this->request->post('repetir_contrasena');
        $fotoPerfil       = $this->request->post('foto_perfil'); // opcional

        // Validaciones básicas
        if ($contrasena !== $repetirContrasena) {
            Log::warning("UsuarioController::procesarAlta - contraseñas no coinciden para usuario: $nombreUsuario");
            Redirect::toIndex();
            return;
        }

        if (!is_numeric($anioNacimiento)) {
            Log::warning("UsuarioController::procesarAlta - año de nacimiento inválido: $anioNacimiento");
            Redirect::toIndex();
            return;
        }

        Log::info("UsuarioController::procesarAlta - nombreUsuario=$nombreUsuario");

        // Para mayor seguridad, siempre guardar la contraseña hasheada
        $hashContrasena = password_hash($contrasena, PASSWORD_BCRYPT);

        $this->model->alta(
            $nombreCompleto,
            $anioNacimiento,
            $sexo,
            $pais,
            $ciudad,
            $email,
            $nombreUsuario,
            $hashContrasena,
            $fotoPerfil
        );

        Redirect::toIndex();
    }
 public function verPerfil() {
    session_start();
    $id = $_SESSION["id"]; 
    $usuario = $this->model->getUsuario($id); 
    $this->renderer->render("verPerfilView", $usuario); 


}
}