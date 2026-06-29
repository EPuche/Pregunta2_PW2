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
        $sugeridas= $this->model->getPreguntasSugeridas();
        foreach ($sugeridas as &$sugerida) {
            $sugerida['opciones'] = $this->model->getOpcionesPorPregunta($sugerida['id']);
        }
        unset($sugerida);

         $reportadas= $this->model->getPreguntasReportadas();

        foreach ($reportadas as &$reporte){
            $reporte['opciones']=$this->model->getOpcionesPorPregunta($reporte['id']);
        }
        unset($reporte);

        $data['sugeridas']=$sugeridas;
        $data['reportadas']=$reportadas;
        $this->renderer->render('panelEditor', $data);
    }
    public function aprobarPreguntaSugerida()
    {
        $idPregunta = $this->request->get('id');

        if($idPregunta){
            $this->model->aprobarPreguntaSugerida($idPregunta);
        }

        header("Location: /editor/irAPanelEditor");
        exit();
    }
    public function rechazarPreguntaSugerida()
    {

        $idPregunta = $this->request->get('id');

        if($idPregunta){
            $this->model->rechazarPreguntaSugerida($idPregunta);
        }

        header("Location: /editor/irAPanelEditor");
        exit();
    }

    public function modificarPregunta()
    {
        $idPregunta = $_POST['id_pregunta'] ?? null;
        $nuevoContenido= $_POST['contenido'] ?? null;

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
        header("Location: /editor/irAPanelEditor");
        exit();

    }
    public function ignorarReporte()
    {
        $idPregunta = $this->request->get('id');

        if($idPregunta){
            $this->model->ignorarReporte($idPregunta);
        }
        header("Location: /editor/irAPanelEditor");
        exit();
    }

}
