<?php
class RankingModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function rankearUsuarios(){

        $sql = "SELECT nombre_usuario, foto_perfil as fotoPerfil, puntaje 
            FROM usuario 
            ORDER BY puntaje DESC, nombre_usuario ASC";
        Log::info("SQL Ranking: $sql");
        $usuarios = $this->database->query($sql);

        foreach ($usuarios as $indice => &$usuario) {
            $usuario['posicion'] = $indice + 1;
        }

        return $usuarios;
    }



}