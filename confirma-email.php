<?php
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once('db/clientServices.php');
require_once('db/admServices.php');
require_once('db/conexao.php');

use PHPMailer\PHPMailer\PHPMailer;

$pdo = new Conexao();
$clientServices = new ClientServices($pdo);
$admServices = new AdmServices($pdo);

$dados = $clientServices->confirmaEmailClient($_GET['token']);

if ($dados) {
    $dadosEmail = $admServices->selectEmailsAtivosAdm();
    $numEmails = $admServices->selectNumeroEmailsAtivos();
    $total = $numEmails['total'];

    for ($i = 0; $i < $total; $i++) {

        $nome = $dados['nome'];
        $email = $dados['email'];
        $data_nascimento = $dados['data_nascimento'];
        $telefone = $dados['telefone'];
        $cpf = $dados['cpf'];
        $cep = $dados['cep'];
        $rua = $dados['rua'];
        $numero = $dados['numero'];
        $complemento = $dados['complemento'];
        $bairro = $dados['bairro'];
        $cidade = $dados['cidade'];
        $estado = $dados['estado'];

        $mail = new PHPMailer();
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; --> mostra o erro que ta dando
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = 'true';
        $mail->Username = 'et270855@gmail.com';
        $mail->Password = 'cjuplhdznhizdxhi';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('et270855@gmail.com', 'et27');
        $mail->addAddress($dadosEmail[$i]['email'], 'et');

        $mail->isHTML(true);
        $mail->Subject = '+1 Cliente Cadastrado';
        $mail->Body = "
        <html>
        <p><b>Nome: </b>$nome</p>
        <p><b>E-mail: </b>$email</p>
        <p><b>Data de Nascimento: </b>$data_nascimento</p>
        <p><b>Telefone: </b>$telefone</p>
        <p><b>CPF: </b>$cpf</p>
        <p><b>CEP: </b>$cep</p>
        <p><b>Rua: </b>$rua</p>
        <p><b>Numero: </b>$numero</p>
        <p><b>Complemento: </b>$complemento</p>
        <p><b>Bairro: </b>$bairro</p>
        <p><b>Cidade: </b>$cidade</p>
        <p><b>Estado: </b>$estado</p>
        </html>
        ";

        $mail->send();

        $clientServices->updateTokenClient();
    }
    echo "Cliente inserido com successo!";
} else {
    echo "Token inválido!";
}
