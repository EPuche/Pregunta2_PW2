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

    public function crearNuevaPregunta(PreguntaDTO $dto){
        $pregunta = $dto->pregunta;
        $categoria = $dto->categoria;
        $opciones = $dto->opciones;
        $opcionCorrecta = $dto->opcionCorrecta;

        $idPregunta = $this->addNuevaPregunta($pregunta, $categoria);
        $this->agregarOpciones($idPregunta, $opciones, $opcionCorrecta);

    }

    private function buscarIdCategoriaPorNombre(string $categoriaNombre)
    {
        $sql = "SELECT id
                FROM categoria
                WHERE nombre = ?";

        $resultado = $this->database->query($sql, [$categoriaNombre]);
        if (!empty($resultado)) {
            return $resultado[0]['id'];
        }
        return null;
    }

    private function addNuevaPregunta(mixed $pregunta, mixed $categoria)
    {
        $idCategoria = $this->buscarIdCategoriaPorNombre($categoria);
        if(!is_null($idCategoria)){
            $sql = "INSERT INTO pregunta (categoria_id, contenido, estado) 
                    VALUES (?, ?, 'pendiente')";
            $this->database->execute($sql, [$idCategoria, $pregunta]);
            return $this->database->getLastId();
        }
        return null;
    }

    private function agregarOpciones($idPregunta, array $opciones, mixed $opcionCorrecta)
    {
        if(!is_null($idPregunta)){
            $sql = "INSERT INTO opcion (pregunta_id, contenido, es_correcta) 
                VALUES (?, ?, ?)";
            foreach ($opciones as $posicion => $contenido) {
                $esCorrecta = ($posicion == $opcionCorrecta) ? 1 : 0;
                $this->database->execute($sql, [$idPregunta, $contenido, $esCorrecta]);
            }
        }
    }

    public function guardarReporte($id_pregunta, $motivo)
    {
        $sql = "INSERT INTO reporte (id_pregunta,motivo) 
                 VALUES (?, ?)";
        $this->database->execute($sql,[$id_pregunta,$motivo]);

        $sqlUpdate= "UPDATE pregunta SET estado = 'reportada' WHERE id= ?";
        $this->database->execute($sqlUpdate,[$id_pregunta]);
    }
    public function getPreguntasSugeridas()
    {
        $resultado=$this->database->query("SELECT * FROM pregunta WHERE estado= 'pendiente'");
        return $resultado;
    }
    public function getPreguntasReportadas()
    {
      $sql = "SELECT p.id, p.contenido, r.motivo
              FROM pregunta p 
              INNER JOIN reporte r ON p.id=r.id_pregunta
              WHERE p.estado = 'reportada'";

      return $this->database->query($sql);
    }
    public function aprobarPreguntaSugerida($idPregunta)
    {
      $sql = "UPDATE pregunta SET estado ='aprobada' WHERE id=?";
      return $this->database->execute($sql, [$idPregunta]);
    }
    public function editarPregunta($idPregunta,$nuevoContenido)
    {
        $sql = "UPDATE pregunta SET contenido = ? WHERE id= ?";
        return $this->database->execute($sql,[$nuevoContenido, $idPregunta]);

    }
    public function rechazarPreguntaSugerida($idPregunta)
    {
        $sql = "UPDATE pregunta SET estado ='rechazada' WHERE id=?";
        return $this->database->execute($sql, [$idPregunta]);

    }
    public function editarOpcion($idOpcion, $nuevoContenido, $esCorrecta)
    {
        $sql = "UPDATE opcion SET contenido = ?, es_correcta = ? WHERE id = ?";
        return $this->database->execute($sql, [$nuevoContenido, $esCorrecta, $idOpcion]);
    }
    public function limpiarPregunta($id_pregunta)
    {

        $sql= "UPDATE pregunta SET estado= 'aprobada' WHERE id= ? AND estado= 'reportada'";
        $this->database->execute($sql,[$id_pregunta]);

    }
    //sacar este metood de mas!!
    public function ignorarReporte($idPregunta)
    {
        $sqlDelete= "DELETE FROM reporte WHERE id_pregunta= ?";
        $this->database->execute($sqlDelete,[$idPregunta]);

        $sql= "UPDATE pregunta SET estado='aprobada' WHERE id= ? AND estado= 'reportada'";
        return $this ->database->execute($sql,[$idPregunta]);
    }

}