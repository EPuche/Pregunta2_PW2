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


        $sqlPregunta = "SELECT id, contenido 
                        FROM pregunta 
                        WHERE categoria_id = ? 
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
    public function esCorrecta($opcion){
        return ($opcion['es_correcta'] == 1);
    }
    public function esElegida($opcion, $idOpcionElegida){
        return ($opcion['id'] == $idOpcionElegida);
    }
    public function esIncorrecta($elegida, $opcion){
        return $elegida && $opcion['es_correcta'] == 0;
    }

    public function procesarOpcionesDeRonda(&$opciones, $idOpcionElegida) {
        $idOpcionCorrecta = null;
        foreach ($opciones as &$opcion) {
            $opcion['es_elegida'] = $this->esElegida($opcion, $idOpcionElegida);
            $opcion['opcion_correcta'] = $this->esCorrecta($opcion);
            $opcion['es_incorrecta'] = $this->esIncorrecta($opcion['es_elegida'], $opcion);

            if ($opcion['opcion_correcta']) {
                $idOpcionCorrecta = $opcion['id'];
            }
        }
        return $idOpcionCorrecta;
    }



}