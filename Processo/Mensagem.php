<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../bibliotecas/PHPMailer/Exception.php";
require "../bibliotecas/PHPMailer/PHPMailer.php";
require "../bibliotecas/PHPMailer/SMTP.php";


class Mensagem {
    private $email = null;
    private $assunto = null;
    private $mensagem = null;
    public $status = array('codigo_status' => null, 'descricao_status' => '' );

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function mensagemValida()
    {
        if(empty($this->email) || empty($this->assunto) || empty($this->mensagem)) {
            return false;
        }

        return true;
    }

    public function enviaEmail()
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = false;                     
            $mail->isSMTP();                                            
            $mail->Host = 'smtp.gmail.com';                    
            $mail->SMTPAuth = true;
            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );                                   
            $mail->Username = 'testeapresentacaopv@gmail.com'; 
            $mail->Password = '00134210';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
            $mail->Port = 587;                                   

            //Recipients
            $mail->setFrom('testeapresentacaopv@gmail.com', 'Site envia Emails');
            $mail->addAddress($this->__get('email'));

            //Content
            $mail->isHTML(true);                                 
            $mail->Subject = $this->__get('assunto');
            $mail->Body = $this->__get('mensagem');
            $mail->AltBody = 'É necessário que o seu email aceite HTML!';

            $mail->send();

            $this->status['codigo_status'] = 1;
			$this->status['descricao_status'] = 'E-mail enviado com sucesso';

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $this->status['codigo_status'] = 2;
			$this->status['descricao_status'] = 'Não foi possível enviar este e-mail! Por favor tente novamente mais tarde. Detalhes do erro: ' . $mail->ErrorInfo;
        }
    }
}