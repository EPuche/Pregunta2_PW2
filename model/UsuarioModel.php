<?php

class UsuarioModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUsuarios()
    {
        $sql = "SELECT * FROM usuario";
        Log::info("SQL: $sql");
        return $this->database->query($sql);
    }

    public function getUsuario($id)
    {
        $sql = "SELECT * FROM usuario WHERE id = ?";
        Log::info("SQL: $sql [$id]");
        $filas = $this->database->query($sql, [$id]);
        return !empty($filas) ? $filas[0] : null;
    }
    public function getUsuarioByName($nombre_usuario)
    {
        $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?";
        Log::info("SQL: $sql [$nombre_usuario]");
        $filas = $this->database->query($sql, [$nombre_usuario]);
        return !empty($filas) ? $filas[0] : null;
    }

    public function alta(
        $nombreCompleto,
        $anioNacimiento,
        $sexo,
        $email,
        $nombreUsuario,
        $contrasena,
        $fotoPerfil = null,
        $longitud,
        $latitud
    ) {
        $sql = "INSERT INTO usuario 
                (nombre_completo, anio_nacimiento, sexo, email, nombre_usuario, contrasena, foto_perfil, longitud, latitud)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        Log::info("SQL: $sql");

        return $this->database->execute($sql, [
            $nombreCompleto,
            $anioNacimiento,
            $sexo,
            $email,
            $nombreUsuario,
            $contrasena,
            $fotoPerfil,
            $longitud,
            $latitud
        ]);
    }

    public function editar(
        $id,
        $nombreCompleto,
        $anioNacimiento,
        $sexo,
        $email,
        $nombreUsuario,
        $fotoPerfil = null,
        $longitud,
        $latitud
    ) {
        $sql = "UPDATE usuario
                SET nombre_completo = ?,
                    anio_nacimiento = ?,
                    sexo = ?,
                    email = ?,
                    nombre_usuario = ?,
                    foto_perfil = ?,
                    longitud = ?,
                    latitud = ?
                
                WHERE id = ?";

        Log::info("SQL: $sql");


        $this->database->execute($sql, [
            $nombreCompleto,
            $anioNacimiento,
            $sexo,
            $email,
            $nombreUsuario,
            $fotoPerfil,
            $longitud,
            $latitud,
            $id
        ]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM usuario WHERE id = ?";
        Log::info("SQL: $sql [$id]");
        $this->database->execute($sql, [$id]);
    }

    public function validarRegistro($email, $nombreUsuario, $contrasena, $repetirContrasena, $anioNacimiento) {
        if (empty($email) || empty($nombreUsuario) || empty($contrasena)) {
            return "Todos los campos obligatorios deben estar completos";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Correo con formato invalido";
        }
        if ($contrasena !== $repetirContrasena) {
            return "Las contraseñas no coinciden";
        }
        if (strlen($contrasena) < 8) {
            return "La contraseña debe tener al menos 8 caracteres.";
        }
        if (!is_numeric($anioNacimiento)) {
            return "El año de nacimiento debe ser un valor numérico.";
        }

        if ($this->existeCampo('nombre_usuario', $nombreUsuario)) {
            return "El nombre de usuario ya se encuentra registrado";
        }
        if ($this->existeCampo('email', $email)) {
            return "El correo electrónico ya se encuentra registrado";
        }
        return true;
    }
    private function existeCampo($columna, $valor): bool
    {
        $sql = "SELECT id FROM usuario WHERE $columna = ?";
        $resultado = $this->database->query($sql, [$valor]);
        return !empty($resultado);
    }






}