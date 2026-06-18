<?php

class PartidaModel
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function crearPartida($idUsuario){
        $sql = "INSERT INTO partida (idUsuario, preguntasCorrectas, puntaje) VALUES (?, 0, 0)";
        $this->database->execute($sql, [$idUsuario]);
        $idPartida = $this->database->getLastId();

        $partida = new Partida($idPartida, $idUsuario);

        return $partida;
    }

    public function respondeCorrectamente($elegida, $esCorrecta, $partida){
        if ($elegida == $esCorrecta) {
            $respuestasCorrectas = $partida->getRespuestasCorrectas();
            $puntaje = $partida->getPuntaje();
            $partida->setRespuestasCorrectas($respuestasCorrectas + 1);
            $partida->setPuntaje($puntaje + 1);
            return true;
        }else{
            $this->finalizarPartida($partida);
            return false;
        }
    }
    public function finalizoPartida($partida): bool{
        if($partida==null || $partida->getRespuestasCorrectas() == $partida->getLimitePreguntasCorrectas()){
            return true;
        }
        return false;
    }

    private function finalizarPartida($partida)
    {
        $idPartida = $partida->getIdPartida();
        $puntaje = $partida->getPuntaje();
        $preguntasCorrectas = $partida->getRespuestasCorrectas();
        $sql = "UPDATE partida 
            SET preguntasCorrectas = ?, puntaje = ? 
            WHERE idPartida = ?";
        $this->database->execute($sql, [$preguntasCorrectas, $puntaje, $idPartida]);

        $idUsuario = $partida->getIdUsuario();
        $sqlUsuario = "UPDATE usuario 
                   SET puntaje = puntaje + ? 
                   WHERE id = ?";
        $this->database->execute($sqlUsuario, [$puntaje, $idUsuario]);


    }




}