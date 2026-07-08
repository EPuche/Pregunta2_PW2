<?php

class AdminController
{
    private $usuarioModel;
    private $partidaModel;
    private $preguntaModel;
    private $renderer;

    public function __construct($usuarioModel, $partidaModel, $preguntaModel, $renderer)
    {
        $this->usuarioModel = $usuarioModel;
        $this->partidaModel = $partidaModel;
        $this->preguntaModel = $preguntaModel;
        $this->renderer = $renderer;
    }

    public function verEstadisticas()
    {
        $filtro = $_GET['filtro'] ?? 'mes';

        $intervalos = [
            'dia' => '1 DAY',
            'semana' => '7 DAY',
            'mes' => '30 DAY',
            'anio' => '365 DAY'
        ];

        $intervalo = $intervalos[$filtro] ?? '30 DAY';

        $data = [
            "filtro" => $filtro,
            "usuariosTotales" => $this->usuarioModel->contarUsuarios(),
            "usuariosNuevos" => $this->usuarioModel->contarUsuariosNuevos($intervalo),
            "partidasTotales" => $this->partidaModel->contarPartidasPorIntervalo($intervalo),
            "preguntasTotales" => $this->preguntaModel->contarPreguntasPorIntervalo($intervalo),
            "preguntasCreadas" => $this->preguntaModel->contarPreguntasCreadas(),
            "usuariosPorSexo" => $this->usuarioModel->usuariosPorSexo($intervalo),
            "usuariosPorEdad" => $this->usuarioModel->usuariosPorEdad($intervalo),
            "usuariosPorPais" => $this->usuarioModel->usuariosPorPais($intervalo),
            "porcentajeCorrectas" => $this->partidaModel->porcentajeCorrectasPorUsuario($intervalo),
            "esDia" => $filtro === 'dia',
            "esSemana" => $filtro === 'semana',
            "esMes" => $filtro === 'mes',
            "esAnio" => $filtro === 'anio'
        ];


        $data['sexoLabels'] = json_encode(array_column($data['usuariosPorSexo'], 'sexo'));
        $data['sexoDatos'] = json_encode(array_column($data['usuariosPorSexo'], 'cantidad'));

        $data['edadLabels'] = json_encode(array_column($data['usuariosPorEdad'], 'grupo'));
        $data['edadDatos'] = json_encode(array_column($data['usuariosPorEdad'], 'cantidad'));

        $data['paisLabels'] = json_encode(array_column($data['usuariosPorPais'], 'pais'));
        $data['paisDatos'] = json_encode(array_column($data['usuariosPorPais'], 'cantidad'));

        $labels = [];
        $datos = [];
        foreach ($data['porcentajeCorrectas'] as $fila) {
            $labels[] = $fila['usuario_id'];
            $datos[] = $fila['porcentaje'];
        }

        $data['correctasLabels'] = json_encode($labels);
        $data['correctasDatos'] = json_encode($datos);
        $data['logoHref'] = $_SESSION['logoHref'];
        $this->renderer->render("adminEstadisticasView.mustache", $data);
    }


    public function usuarios()
    {
        $busqueda = $_GET['q'] ?? null;

        if ($busqueda) {
            // método que filtre por nombre o email
            $usuarios = $this->usuarioModel->buscarUsuarios($busqueda);
        } else {
            $usuarios = $this->usuarioModel->getAll();
        }

        $data = [
            "usuarios" => $usuarios,
            "logoHref" => $_SESSION['logoHref']
        ];

        $this->renderer->render("adminUsuariosView.mustache", $data);
    }

    /*
     public function partidas()
     {
         $data = [
             "partidas" => $this->partidaModel->getAll()
         ];
         $data['logoHref'] = $_SESSION['logoHref'];
         $this->renderer->render("adminPartidasView.mustache", $data);
     }


     public function preguntas()
     {
         $data = [
             "preguntas" => $this->preguntaModel->getAll()
         ];
         $data['logoHref'] = $_SESSION['logoHref'];
         $this->renderer->render("adminPreguntasView.mustache", $data);
     }*/

    /*Trampitas / Ventas
    public function trampitas()
    {

        $data = [
            "ventas" => []
        ];
        $data['logoHref'] = $_SESSION['logoHref'];
        $this->renderer->render("adminTrampitasView.mustache", $data);
    }*/

    public function irAlHome()
    {
        header("Location: /admin/verEstadisticas");
        exit;
    }
}
