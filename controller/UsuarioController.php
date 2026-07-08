<?php

class UsuarioController
{
    private $renderer;
    private $model;
    private $request;

    public function __construct($model, $renderer, $request)
    {
        $this->model = $model;
        $this->renderer = $renderer;
        $this->request = $request;
    }

    public function irAlRegistro()
    {
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
        $repetirContrasena = $this->request->post('repetir_contrasena');
        $latitud = $_POST['latitud'] ?? null;
        $longitud = $_POST['longitud'] ?? null;
        $imagenPerfil = null;
        $carpetaDestino = __DIR__ . '/../assets/imgPerfiles/';

        $validacion = $this->model->validarRegistro($email, $nombreUsuario, $contrasena, $repetirContrasena, $anioNacimiento);

        if ($validacion !== true) {
            Log::warning("UsuarioController::procesarRegistro - Falló la validación: $validacion");
            $_SESSION['error_registro'] = $validacion;
            header("Location: /usuario/irAlRegistro");
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


            require_once __DIR__ . '/../helpers/Mail.php';
            $mail = new Mail();
            $mailEnviado = $mail->enviarConfirmacion($email, $registro); // $registro ahora es el token

            if ($mailEnviado) {
                $_SESSION['mensaje'] = "Registro exitoso. Revisa tu email para confirmar tu cuenta.";
            } else {
                $_SESSION['error_registro'] = "Registro exitoso, pero no se pudo enviar el correo de confirmación.";
            }

            header("Location:/login/irAlLogin");
            exit;
        } else {
            $_SESSION['error_registro'] = "Hubo un problema. Inténtalo más tarde";
            header("Location:/usuario/irAlRegistro");
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
                header("Location: usuario/irAlRegistro");
                exit;
            }
            $rutaFoto = '/assets/imgPerfiles/' . $imagenPerfil;

            $this->model->actualizarFoto(
                $nombreUsuario,
                $rutaFoto
            );
        }
    }




    public function verPerfil()
    {
        $id = $this->request->get("id") ?? $_SESSION["id"];
        $usuario = $this->model->getUsuario($id);
        $fotoPerfil = $usuario["foto_perfil"];
        if (
            empty($fotoPerfil) ||
            !file_exists($_SERVER["DOCUMENT_ROOT"] . $fotoPerfil)
        ) {
            $fotoPerfil = "/assets/imgPerfiles/default-user.png";
        }
        $historial = $this->model->getHistorial($id);
        $esPropio = ($id == $_SESSION["id"]);

        $data = [
            "nombreUsuario"   => $usuario["nombre_usuario"],
            "nombre_completo" => $usuario["nombre_completo"],
            "nombre_usuario"  => $usuario["nombre_usuario"],
            "puntaje"         => $usuario["puntaje"] ?? 0,
            "anio_nacimiento" => $usuario["anio_nacimiento"],
            "sexo"            => $usuario["sexo"],
            "email"           => $usuario["email"],
            "foto_perfil"     => $fotoPerfil,
            "latitud"         => $usuario["latitud"],
            "longitud"        => $usuario["longitud"],
            "id"              => $usuario["id"],
            "historial"       => $historial,
            "esPropio"        => $esPropio

        ];

        $this->renderer->render("verPerfilView", $data);
    }

    public function editarPerfil()
    {
        $id = $_SESSION["id"];

        $usuario = $this->model->getUsuario($id);

        $this->renderer->render("editarPerfilView", $usuario);
    }
    public function guardarPerfil()
    {
        $fotoPerfil = null;

        $usuarioActual = $this->model->getUsuario($_POST["id"]);

        if (
            isset($_FILES['foto_perfil']) &&
            $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK
        ) {

            $carpetaDestino = __DIR__ . '/../assets/imgPerfiles/';

            if (!file_exists($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            $extension = pathinfo(
                $_FILES['foto_perfil']['name'],
                PATHINFO_EXTENSION
            );

            $nombreArchivo =
                $_POST["nombre_usuario"] . "_" . time() . "." . $extension;

            $rutaCompleta = $carpetaDestino . $nombreArchivo;

            move_uploaded_file(
                $_FILES['foto_perfil']['tmp_name'],
                $rutaCompleta
            );

            $fotoPerfil = '/assets/imgPerfiles/' . $nombreArchivo;
        } else {

            $fotoPerfil = $usuarioActual["foto_perfil"];
        }

        $nuevaContrasena = $_POST["contrasena"] ?? null;
        $repetirContrasena = $_POST["repetir_contrasena"] ?? null;

        if ($nuevaContrasena && $nuevaContrasena === $repetirContrasena) {
            $hashContrasena = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
        } else {
            $hashContrasena = $usuarioActual["contrasena"];
        }

        $this->model->editar(

            $_POST["id"],
            $_POST["nombre_completo"],
            $_POST["anio_nacimiento"],
            $_POST["sexo"],
            $_POST["email"],
            $_POST["nombre_usuario"],
            $fotoPerfil,
            $_POST["longitud"],
            $_POST["latitud"],
            $hashContrasena

        );

        header("Location: /usuario/verPerfil");
        exit;
    }

    public function confirmarCuenta()
    {
        $token = $_GET['token'] ?? null;

        if (!$token) {
            $_SESSION['error'] = "Token no recibido";
            header("Location: /login");
            exit;
        }

        if ($this->model->confirmarCuenta($token) > 0) {
            $_SESSION['mensaje'] = 'Cuenta verificada correctamente';
        } else {
            $_SESSION['error'] = 'Token inválido o ya utilizado';
        }

        header("Location: /login/irAlLogin");
        exit;
    }

    /*  public function verLobby()
    {
        if (!isset($_SESSION["id"])) {
            header("Location: /login/irAlLogin");
            exit;
        }

        $usuario = $this->model->getUsuario($_SESSION["id"]);

        $data = [
            "nombreUsuario" => $usuario["nombre_usuario"],
            "puntaje" => $usuario["puntaje"] ?? 0,
            "partidasActivas" => [],
            "historial" => []
        ];

        $this->renderer->render("lobbyView", $data);
    }*/
}
