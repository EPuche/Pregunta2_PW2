<?php

class EditorController{
    private $renderer;
    private $model;
    private $request;

    public function __construct($model, $renderer, $request)
    {
        $this->model = $model;
        $this->renderer = $renderer;
        $this->request = $request;
    }
    public function irAPanelEditor(){
        $preguntas=$this->model->getPreguntas();

        foreach ($preguntas as &$p) {
            $p['es_activa']    = ($p['estado'] == 'aprobada');
            $p['es_rechazada'] = ($p['estado'] == 'rechazada');
            $p['es_reportada'] = ($p['estado'] == 'reportada');
            $p['es_sugerida']  = ($p['estado'] == 'pendiente');
        }
        unset($p);

        $data["preguntas"]=$preguntas;
        $this->renderer->render('panelEditorView', $data);
    }
    public function mostrarPreguntasReportadas()
    {
        $reportadas= $this->model->getPreguntasReportadas();

        foreach ($reportadas as &$reporte){
            $reporte['opciones']=$this->model->getOpcionesPorPregunta($reporte['id']);
        }
        unset($reporte);
        $data['reportadas']=$reportadas;
        $this->renderer->render('panelEditorReportadas', $data);
    }
    public function mostrarPreguntasSugeridas()
    {
        $sugeridas= $this->model->getPreguntasSugeridas();
        foreach ($sugeridas as &$sugerida) {
            $sugerida['opciones'] = $this->model->getOpcionesPorPregunta($sugerida['id']);
        }
        unset($sugerida);

        $data['sugeridas']=$sugeridas;
        $this->renderer->render('panelEditorSugeridas', $data);

    }
    public function aprobarPreguntaSugerida()
    {
        $idPregunta = $this->request->get('id');

        if($idPregunta){
            $this->model->aprobarPreguntaSugerida($idPregunta);
        }

        header("Location: /editor/mostrarPreguntasSugeridas");
        exit();
    }
    public function rechazarPreguntaSugerida()
    {

        $idPregunta = $this->request->get('id');

        if($idPregunta){
            $this->model->rechazarPreguntaSugerida($idPregunta);
        }

        header("Location: /editor/mostrarPreguntasSugeridas");
        exit();
    }
    public function mostrarFormularioModificar()
    {
        $data['origen'] = $_GET['origen'] ?? 'catalogo';
        $id_pregunta = isset($_GET['id']) ? $_GET['id'] : null;

        if(!$id_pregunta){
            header("Location: /editor/irAPanelEditor");
            exit();
        }
        $resultadoPregunta = $this->model->getPreguntaPorId($id_pregunta);

        $data['pregunta'] = isset($resultadoPregunta[0]) ? $resultadoPregunta[0] : $resultadoPregunta;
        $data['opciones'] = $this->model->getOpcionesPorPregunta($id_pregunta);

        $this->renderer->render('modificarPreguntaView', $data);
    }

    public function modificarPregunta()
    {
        $idPregunta = $_POST['id_pregunta'] ?? null;
        $nuevoContenido= $_POST['contenido'] ?? null;
        $origen = $_POST['origen'] ?? 'catalogo';

        $opcionesIds = $_POST['opciones_ids'] ?? [];
        $opcionesTextos = $_POST['opciones_textos'] ?? [];
        $opcionCorrectaId = $_POST['opcion_correcta_id'] ?? null;

        if($idPregunta && $nuevoContenido){
            $this->model->editarPregunta($idPregunta,$nuevoContenido);

            foreach ($opcionesIds as $index => $idOpcion) {
                $textoOpcion = $opcionesTextos[$index];
                $esCorrecta = ($idOpcion == $opcionCorrectaId) ? 1 : 0;
                $this->model->editarOpcion($idOpcion, $textoOpcion, $esCorrecta);
                }
            $this->model->limpiarPregunta($idPregunta);
        }
        if($origen === 'reportadas'){
            header("Location: /editor/mostrarPreguntasReportadas");
        }else{
            header("Location: /editor/irAPanelEditor");
        }
        exit();

    }
    public function ignorarReporte()
    {
        $idPregunta = $this->request->get('id');

        if($idPregunta){
            $this->model->ignorarReporte($idPregunta);
        }
        header("Location: /editor/mostrarPreguntasReportadas");
        exit();
    }
    public function darDeBajaPregunta()
    {
        $idPregunta = $this->request->get('id');

        if($idPregunta){
            $this->model->darDeBajaPregunta($idPregunta);
        }
        header("Location: /editor/irAPanelEditor");
        exit();
    }
    public function irACrearCategoria()
    {
        $this->renderer->render('crearCategoriaView');

    }
    public function agregarCategoria()
    {
        $nuevaCategoria = $_POST['nombre_categoria'] ?? null;
        $colorCategoria = $_POST['color_categoria'] ?? null;

        if($nuevaCategoria) {
            $this->model->agregarCategoria($nuevaCategoria, $colorCategoria);
        }
        header("Location: /editor/irAPanelEditor");
        exit();

    }
}
