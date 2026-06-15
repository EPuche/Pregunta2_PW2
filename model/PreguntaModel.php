<?php
class PreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPreguntaAleatoriaPorCategoria($categoria)
    {
        //consulto la categoria
        $sqlCategoria = "SELECT id FROM categoria WHERE nombre = ? LIMIT 1";
        $resultadoCategoria = $this->database->query($sqlCategoria, [$categoria]);

        $categoriaId = $resultadoCategoria[0]['id'];


        $sqlPregunta = "SELECT p.id, p.contenido, c.color
                        FROM pregunta p
                        JOIN categoria c ON p.categoria_id = c.id
                        WHERE p.categoria_id = ? 
                        ORDER BY RAND() 
                        LIMIT 1";

        $resultadoPregunta = $this->database->query($sqlPregunta, [$categoriaId]);

        Log::info("SQL: $sqlPregunta");
        return $resultadoPregunta[0];
    }

    public function getOpcionesPorPregunta($preguntaId) {
        $sql = "SELECT id, contenido, es_correcta 
                FROM opcion
                WHERE pregunta_id = ?";


        return $this->database->query($sql, [$preguntaId]);
    }




}