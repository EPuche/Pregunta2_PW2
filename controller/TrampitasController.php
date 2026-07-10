<?php




class TrampitasController
{
    private $model;
    private $renderer;
    private $request;
    private $trampitasModel;


    public function __construct($model, $renderer, $request, $trampitasModel)
    {
        $this->model = $model;
        $this->renderer = $renderer;
        $this->request = $request;
        $this->trampitasModel = $trampitasModel;
    }

    public function procesarPago() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        $idUsuario = $_SESSION['id'] ?? null;
        $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;
        $totalPagar = isset($_POST['total']) ? floatval($_POST['total']) : 0.0;

        if (!$idUsuario || $cantidad < 1 || $totalPagar <= 0) {
            header("Location: /lobby?error=datos_invalidos");
            exit;
        }

        try {

            $preference = $this->trampitasModel->crearPreferenciaDePago($idUsuario, $cantidad, $totalPagar);

            header("Location: " . $preference->sandbox_init_point);
            exit;
        } catch (Exception $e) {
            echo "<h3>Error detectado en Mercado Pago:</h3>";
            echo "<pre>" . $e->getMessage() . "</pre>";

            if (method_exists($e, 'getApiResponse')) {
                $response = $e->getApiResponse();
                echo "<pre>";
                print_r($response->getContent());
                echo "</pre>";
            }
            exit;
        }
    }

    public function pagoExitoso() {
        if (!isset($_GET['external_reference'])) {
            header("Location: /lobby?error=pago_invalido");
            exit;
        }

        $partes = explode("-", $_GET['external_reference']);
        $idUsuario  = isset($partes[0]) ? (int)$partes[0] : null;
        $cantidad   = isset($partes[1]) ? (int)$partes[1] : 0;

        if (!$idUsuario || $cantidad <= 0) {
            header("Location: /lobby?error=datos_corruptos");
            exit;
        }


        $seActualizo = $this->trampitasModel->agregarTrampitasAlUsuario($idUsuario, $cantidad);

        if ($seActualizo) {
            $_SESSION["cantidadTrampitas"]=$cantidad;
            $_SESSION["compra"]=true;
            header("Location: /lobby/irAlLobby");
        } else {
            header("Location: /lobby?error=error_actualizacion");
        }
        exit;
    }





}