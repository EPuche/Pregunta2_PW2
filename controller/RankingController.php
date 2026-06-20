<?php

class RankingController
{
private $renderer;
private $model;
private $request;
    /**
     * @var mixed
     */
    private $rankingModel;

    public function __construct($model, $rankingModel,$renderer, $request)
{
    $this->rankingModel = $rankingModel;
    $this->model = $model;
    $this->renderer = $renderer;
    $this->request = $request;
}


    public function irAlRanking(){
        $datosRanking = $this->rankingModel->rankearUsuarios();
        $data = [
            'usuarios' => $datosRanking
        ];

        $this->renderer->render("rankingView", $data);
    }



}