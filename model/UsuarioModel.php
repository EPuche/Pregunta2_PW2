<?php
class UsuarioModel{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getUsuario($usuario){
        $sql= "SELECT * FROM Usuario WHERE usuario = ?";
        $filas = $this->database->query($sql, [$usuario]);
        return !empty($filas) ? $filas[0] : null;
    }
}