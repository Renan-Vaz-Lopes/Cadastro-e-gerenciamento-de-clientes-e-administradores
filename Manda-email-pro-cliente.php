<?php
require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

class MandaEmailProCliente
{
    
    public function mandarEmailProClienteConfirmarEAdicionaNoBd($dadosDoCliente,$clientServices)
    {
        
        //manda msg pro cliente pra ele confirmar
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = 'true';
        $mail->Username = 'et270855@gmail.com';
        $mail->Password = 'cjuplhdznhizdxhi';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('et270855@gmail.com', 'et');
        $mail->addAddress($dadosDoCliente['email'], 'user');

        $dadosDoCliente['token'] = uniqid(true);
        $clientServices->insertClient($dadosDoCliente);

        $mail->isHTML(true);
        $mail->Subject = 'Email pra confirmacao';
        $mail->Body = "
            <html>
            <p>Aperte no botão 'Confirmar' pra confirmar a existência do seu email</p>
            <a href='http://localhost/crud2-php-POO/confirma-email.php?token=" . $dadosDoCliente['token'] . "'>
                            <button type='button'>Confirmar</button>
                        </a>
            </html>
            ";

        if ($mail->send()) {
            header("location: ../Login.php");
        } else {
            print 'O email nao foi enviado';
        }
    }
}
