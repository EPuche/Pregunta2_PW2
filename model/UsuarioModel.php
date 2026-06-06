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

    public function alta(
        $nombreCompleto,
        $anioNacimiento,
        $sexo,
        $pais,
        $ciudad,
        $email,
        $nombreUsuario,
        $contrasena,
        $fotoPerfil = null
    ) {
        $sql = "INSERT INTO usuario 
                (nombre_completo, anio_nacimiento, sexo, pais, ciudad, email, nombre_usuario, contrasena, foto_perfil)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        Log::info("SQL: $sql");

        return $this->database->execute($sql, [
            $nombreCompleto,
            $anioNacimiento,
            $sexo,
            $pais,
            $ciudad,
            $email,
            $nombreUsuario,
            $contrasena,
            $fotoPerfil
        ]);
    }

    public function editar(
        $id,
        $nombreCompleto,
        $anioNacimiento,
        $sexo,
        $pais,
        $ciudad,
        $email,
        $nombreUsuario,
        $fotoPerfil = null
    ) {
        $sql = "UPDATE usuario
                SET nombre_completo = ?,
                    anio_nacimiento = ?,
                    sexo = ?,
                    pais = ?,
                    ciudad = ?,
                    email = ?,
                    nombre_usuario = ?,
                    foto_perfil = ?
                WHERE id = ?";

        Log::info("SQL: $sql");

        $this->database->execute($sql, [
            $nombreCompleto,
            $anioNacimiento,
            $sexo,
            $pais,
            $ciudad,
            $email,
            $nombreUsuario,
            $fotoPerfil,
            $id
        ]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM usuario WHERE id = ?";
        Log::info("SQL: $sql [$id]");
        $this->database->execute($sql, [$id]);
    }
}