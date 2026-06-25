<?php
class PreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPreguntaAleatoriaPorCategoria($categoria, $usuarioId)
    {
        $sqlCategoria = "SELECT id FROM categoria WHERE nombre = ? LIMIT 1";
        $resultadoCategoria = $this->database->query($sqlCategoria, [$categoria]);
        $categoriaId = $resultadoCategoria[0]['id'];

        $sqlNivel = "SELECT COALESCE(SUM(respondida_correctamente) / NULLIF(COUNT(*), 0), 0.5) as ratio
                 FROM usuario_pregunta WHERE usuario_id = ?";
        $resultadoNivel = $this->database->query($sqlNivel, [$usuarioId]);
        $ratioUsuario = $resultadoNivel[0]['ratio'];

        if ($ratioUsuario >= 0.70) {
            $nivelUsuario = 'dificil';
        } elseif ($ratioUsuario <= 0.30) {
            $nivelUsuario = 'facil';
        } else {
            $nivelUsuario = null;
        }

        $whereNoVista = "AND p.id NOT IN (
        SELECT DISTINCT pregunta_id FROM usuario_pregunta WHERE usuario_id = ?
    )";

        $whereDificultad = "";
        if ($nivelUsuario !== null) {
            $whereDificultad = "AND (
            (
                SELECT COALESCE(SUM(up.respondida_correctamente) / NULLIF(COUNT(*), 0), NULL)
                FROM usuario_pregunta up WHERE up.pregunta_id = p.id
            ) " . ($nivelUsuario === 'facil' ? '>= 0.70' : '<= 0.30') . "
            OR NOT EXISTS (
                SELECT 1 FROM usuario_pregunta up WHERE up.pregunta_id = p.id
            )
        )";
        }

        $sql = "SELECT p.id, p.contenido, c.color
            FROM pregunta p
            JOIN categoria c ON p.categoria_id = c.id
            WHERE p.categoria_id = ?
            AND p.estado = 'aprobada'
            $whereNoVista
            $whereDificultad
            ORDER BY RAND() LIMIT 1";

        $resultado = $this->database->query($sql, [$categoriaId, $usuarioId]);

        if (empty($resultado)) {
            $sql = "SELECT p.id, p.contenido, c.color
                FROM pregunta p
                JOIN categoria c ON p.categoria_id = c.id
                WHERE p.categoria_id = ?
                AND p.estado = 'aprobada'
                $whereNoVista
                ORDER BY RAND() LIMIT 1";
            $resultado = $this->database->query($sql, [$categoriaId, $usuarioId]);
        }

        if (empty($resultado)) {
            $sql = "SELECT p.id, p.contenido, c.color
                FROM pregunta p
                JOIN categoria c ON p.categoria_id = c.id
                WHERE p.categoria_id = ?
                AND p.estado = 'aprobada'
                ORDER BY RAND() LIMIT 1";
            $resultado = $this->database->query($sql, [$categoriaId]);
        }

        return $resultado[0] ?? null;
    }

    public function registrarPreguntaVista($usuarioId, $preguntaId, $esCorrecta)
    {
        $sql = "INSERT INTO usuario_pregunta (usuario_id, pregunta_id, respondida_correctamente) 
            VALUES (?, ?, ?)";
        $this->database->execute($sql, [$usuarioId, $preguntaId, $esCorrecta ? 1 : 0]);
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