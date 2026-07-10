<?php

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Resources\Preference;

class TrampitasModel
{
    private $database;
    private $baseUrl;

    public function __construct($database)
    {
        $this->database = $database;

        $config = parse_ini_file(__DIR__ . "/../config/config.ini", true);
      //$this->baseUrl = $config['url']['base_url'] ?? 'http://localhost';
       $this->baseUrl = $config['url']['base_url'] ?? 'https://ultra-freely-jackknife.ngrok-free.dev';

       MercadoPagoConfig::setAccessToken("APP_USR-3445563162809404-070912-df9b08b9f4d86088ed8ba29bb0ebc334-3530882052");
    }

    public function agregarTrampitasAlUsuario($idUsuario, $cantidad) {
        $sql = "UPDATE Usuario 
                 SET trampitas = trampitas + ?
                 WHERE id = ?";

        return $this->database->execute($sql, [$cantidad, $idUsuario]);

    }


    public function crearPreferenciaDePago($idUsuario, $cantidad, $totalPagar): Preference
    {
        $urlFija = "https://pregunta2pw2.freehosting.dev";
        $preferenceData = [
            "items" => [
                [
                    "title" => "Pack de " . $cantidad . " Trampitas - Preguntados",
                    "quantity" => 1,
                    "unit_price" => (float)$totalPagar,
                    "currency_id" => "ARS"
                ]
            ],
            "back_urls" => [
                "success" =>$urlFija . "/trampitas/pagoExitoso",
                "failure" => $urlFija . "/lobby/irAlLobby?error=pago_fallido",
                "pending" => $urlFija . "/lobby/irAlLobby?error=pago_pendiente"
            ],
            "auto_return" => "approved",
            "external_reference" => (string)($idUsuario . "-" . $cantidad),

        ];

        $client = new PreferenceClient();
        return $client->create($preferenceData);
    }





}