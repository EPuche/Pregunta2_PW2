<?php
class Partida
{
    private $idPartida;
    private $idUsuario;
    private $puntaje;
    private $respuestasCorrectas;

    private $limitePreguntasCorrectas;

    public function __construct(
        int $idPartida,
        int $idUsuario) {
        $this->respuestasCorrectas = 0;
        $this->puntaje = 0;
        $this->idUsuario = $idUsuario;
        $this->idPartida = $idPartida;
        $this->limitePreguntasCorrectas=5;
    }

    public function getLimitePreguntasCorrectas(): int { return $this->limitePreguntasCorrectas; }
    public function getIdPartida(): int { return $this->idPartida; }
    public function getIdUsuario(): int { return $this->idUsuario; }
    public function getPuntaje(): int { return $this->puntaje; }

    public function getRespuestasCorrectas(): int { return $this->respuestasCorrectas; }

    public function setRespuestasCorrectas(int $respuestasCorrectas): void
    {
        $this->respuestasCorrectas = $respuestasCorrectas;
    }

    public function setPuntaje(int $puntaje): void
    {
        $this->puntaje = $puntaje;
    }





}