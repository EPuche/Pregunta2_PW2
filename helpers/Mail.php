<?php
// service/Mail.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class Mail
{
    private $mailer;

    public function __construct()
    {
        $config = parse_ini_file(__DIR__ . '/../config/config.ini', true);
        $this->mailer = new PHPMailer(true);
      $this->mailer->SMTPDebug = 2; 
      $this->mailer->Debugoutput = function($str, $level) {
    echo "DEBUG: $str<br>";
};
        try {
            // Configuración SMTP
            $this->mailer->isSMTP();
            $this->mailer->Host       = $config['mail']['host'];
            $this->mailer->SMTPAuth   = true;
            $this->mailer->Username   = $config['mail']['username'];
            $this->mailer->Password   = $config['mail']['password'];
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port       = $config['mail']['port'];

            $this->mailer->setFrom($config['mail']['from'], $config['mail']['from_name']);
        } catch (Exception $e) {
    echo "No se pudo enviar el correo: {$e->getMessage()} - {$this->mailer->ErrorInfo}";
    return false;
}
    }

    public function enviarConfirmacion($email, $token)
    {
        try {
            $config = parse_ini_file(__DIR__ . '/../config/config.ini', true);;
            $link = $config['url']['base_url'] . "/usuario/confirmarCuenta?token=$token";

            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Confirma tu cuenta en Pregunta2';
            $this->mailer->Body = "
                <h2>Bienvenido a Pregunta2</h2>
                <p>Para activar tu cuenta haz clic en el siguiente enlace:</p>
                <a href='$link'>Confirmar cuenta</a>
            ";

            return $this->mailer->send();
        } catch (Exception $e) {
            echo "No se pudo enviar el correo: {$this->mailer->ErrorInfo}";
            return false;
        }
    }

}