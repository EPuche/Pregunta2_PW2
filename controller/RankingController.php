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

    public function __construct($model, $rankingModel, $renderer, $request)
    {
        $this->rankingModel = $rankingModel;
        $this->model = $model;
        $this->renderer = $renderer;
        $this->request = $request;
    }


    public function irAlRanking()
    {
        $datosRanking = $this->rankingModel->rankearUsuarios();
     
        foreach ($datosRanking as &$usuario) {

            $foto = $usuario["foto_perfil"];

            if (
                empty($foto) ||
                !file_exists($_SERVER["DOCUMENT_ROOT"] . $foto)
            ) {
                $usuario["foto_perfil"] = "/assets/imgPerfiles/default-user.png";
            }
        }

        unset($usuario);


        $data = [
            'usuarios' => $datosRanking
        ];

        $this->renderer->render("rankingView", $data);
    }
}
