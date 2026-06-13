<?php

class UsuarioController {
    private $renderer;

    public function __construct($model, $renderer, $request) {
        $this->model = $model;
        $this->renderer = $renderer;
        $this->request = $request;
    }

    public function irAlRegistro() {
        // 1. Iniciamos un array de datos vacío para la plantilla
        $datos = [];

        // 2. Si existe un error en la sesión, se lo pasamos a Mustache
        if (isset($_SESSION['error_registro'])) {
            $datos['error_registro'] = $_SESSION['error_registro'];
            unset($_SESSION['error_registro']);
        }
        $this->renderer->render("registroView", $datos);
    }

    public function procesarRegistro()
    {
        $nombreCompleto   = $this->request->post('nombre_completo');
        $anioNacimiento   = $this->request->post('anio_nacimiento');
        $sexo             = $this->request->post('sexo');
        $email            = $this->request->post('email');
        $nombreUsuario    = $this->request->post('nombre_usuario');
        $contrasena       = $this->request->post('contrasena');
        $repetirContrasena= $this->request->post('repetir_contrasena');
        $latitud = $_POST['latitud'] ?? null;
        $longitud = $_POST['longitud'] ?? null;


        $imagenPerfil = null;
        $carpetaDestino = __DIR__ . '/../assets/imgPerfiles/';

        $validacion = $this->model->validarRegistro($email, $nombreUsuario, $contrasena, $repetirContrasena, $anioNacimiento);

        if ($validacion !== true) {
            Log::warning("UsuarioController::procesarRegistro - Falló la validación: $validacion");
            $_SESSION['error_registro'] = $validacion;
            header("Location: /Pregunta2_PW2/index.php?controller=usuario&method=irAlRegistro");
            exit;
        }

        Log::info("UsuarioController::procesarRegistro - Datos válidos para: $nombreUsuario");

        $hashContrasena = password_hash($contrasena, PASSWORD_BCRYPT);

        $registro = $this->model->alta(
            $nombreCompleto,
            $anioNacimiento,
            $sexo,
            $email,
            $nombreUsuario,
            $hashContrasena,
            $imagenPerfil,
            $longitud,
            $latitud
        );

        if ($registro) {
             $this->subirFotoPerfil($_FILES['foto_perfil'] ?? null, $nombreUsuario, $carpetaDestino);
            header("Location: /Pregunta2_PW2/index.php?controller=login&method=irAlLogin");
            exit;
        } else {
            $_SESSION['error_registro'] = "Hubo un problema. Intentalo mas tarde";
            header("Location: /Pregunta2_PW2/index.php?controller=usuario&method=irAlRegistro");
            exit;
        }

    }

    private function subirFotoPerfil($param, $nombreUsuario, string $carpetaDestino)
    {

        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $carpetaDestino = __DIR__ . '/../assets/imgPerfiles/';

            if (!file_exists($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            $pathInfo = pathinfo($_FILES['foto_perfil']['name']);
            $extension = $pathInfo['extension'];

            $imagenPerfil = $nombreUsuario . '_' . time() . '.' . $extension;


            $rutaCompletaDestino = $carpetaDestino . $imagenPerfil;

            if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaCompletaDestino)) {
                Log::error("UsuarioController::procesarRegistro - No se pudo mover la foto al servidor.");
                $_SESSION['error_registro'] = "Hubo un problema al guardar la foto de perfil.";
                header("Location: /Pregunta2_PW2/index.php?controller=usuario&method=irAlRegistro");
                exit;
            }
        }
    }
 public function verPerfil() {
    session_start();
    $id = $_SESSION["id"]; 
    $usuario = $this->model->getUsuario($id); 
    $this->renderer->render("verPerfilView", $usuario); 


}
}