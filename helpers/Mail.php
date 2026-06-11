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
        $this->mailer = new PHPMailer(true);

        try {
            // Configuración SMTP
            $this->mailer->isSMTP();
            $this->mailer->Host       = 'smtp.office365.com'; // Cambia por tu servidor SMTP
            $this->mailer->SMTPAuth   = true;
            $this->mailer->Username   = 'esteban_alejo23@outlook.com'; // Tu correo
            $this->mailer->Password   = 'Cualquiera01_';      // Contraseña o App Password
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port       = 587;

            $this->mailer->setFrom('esteban_alejo23@outlook.com', 'Pregunta2');
        } catch (Exception $e) {
            echo "Error en la configuración del mail: {$e->getMessage()}";
        }
    }

    public function enviarConfirmacion($email, $token)
    {
        try {
            $link = "http://localhost/Pregunta2_PW2/index.php?controller=usuario&method=confirmarCuenta&token=$token";

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