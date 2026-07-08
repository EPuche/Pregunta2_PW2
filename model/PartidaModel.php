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

    public function finalizarPartida($partida)
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

    public function asignarUnTiempoDeFinalizacionALaRonda(){
        $tiempoLimite = time() + 15;
        return $tiempoLimite;

    }

    public function calcularSegundosRestantes($tiempoLimite){
        return  $tiempoLimite - time();
    }


    public function contarPartidas() {
    $sql = "SELECT COUNT(*) AS total FROM partida";
    Log::info("SQL: $sql");
    $filas = $this->database->query($sql);
    return !empty($filas) ? $filas[0]['total'] : 0;
}

public function contarPartidasPorIntervalo($intervalo = "30 DAY") {
    $sql = "SELECT COUNT(*) AS total 
            FROM partida 
            WHERE fecha >= NOW() - INTERVAL $intervalo";
    Log::info("SQL: $sql");
    $filas = $this->database->query($sql);
    return !empty($filas) ? $filas[0]['total'] : 0;
}
public function porcentajeCorrectasPorUsuario($intervalo) {
    $sql = "SELECT usuario_id,
                   ROUND((SUM(respondida_correctamente) / COUNT(*)) * 100, 2) AS porcentaje
            FROM usuario_pregunta
            WHERE fecha >= NOW() - INTERVAL $intervalo
            GROUP BY usuario_id";
    return $this->database->query($sql);
}


}