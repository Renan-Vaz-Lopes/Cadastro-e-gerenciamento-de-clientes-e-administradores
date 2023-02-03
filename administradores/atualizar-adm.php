<?php
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); --> pra aparecer erros
require_once('../db/admServices.php');
require_once('../Limpar.php');
require_once('../db/conexao.php');
require_once('./administrador.php');
require_once('./validacaoFormAtualizarAdministrador.php');
require_once('../protect-adm-cli.php');

setlocale(LC_ALL, 'pt_BR', 'pt_BR.UTF-8', 'pt_BR.UTF-8', 'portuguese');

$id = (trim(strip_tags($_GET['id'])));
$limparPost = new Limpar();
$pdo = new Conexao();
$admServices = new AdmServices($pdo);
$dataAdministrador = $admServices->carregaAdministrador($id);
$administrador = new Administrador($dataAdministrador);
$validacaoFormAdministrador = new ValidacaoFormAtualizarAdministrador($administrador,"");

if (isset($_POST['btn-atualizar-adm'])) {
    $_POST = $limparPost->limpaPostAtualizaAdm($_POST);
    $validacaoFormAdministrador = new ValidacaoFormAtualizarAdministrador($administrador, $_POST);
    if (empty($validacaoFormAdministrador->getMessage())) {
        $admServices->updateNewPassAdm($_POST);
    } else {
        $administrador = new Administrador($_POST);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <script src="js/jquery-3.6.1.min.js" type="text/javascript"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/_reboot.scss" rel="stylesheet">
    <link href="../css/atualizar-adm.css" rel="stylesheet">
    <title>Atualizar Administrador</title>
</head>

<body>
    <div class="container">
        <form method="post" action="#">
            <input type="hidden" id="id" name="id" placeholder="ID" value="<?= $id ?>">
            <div class="box1">
                <div class="box2">
                    <h4 class="t">Atualizar Administrador</h4>
                    <div class="message"> <?= !is_null($validacaoFormAdministrador) ? $validacaoFormAdministrador->getMessage() : '' ?> </div>

                    <div>
                        <label class="l">Nome</label>
                        <input value="<?= $administrador->getNome() ?>" class="input-padrao <?= (empty($administrador->getNome()) && !empty($validacaoFormAdministrador->getMessage()) ? 'border-danger' : '') ?>" type="text" id="nome" name="nome" placeholder="Seu nome completo">
                    </div>

                    <div>
                        <label class="l">E-mail</label>
                        <input value="<?= $dataAdministrador['email'] ?>" class="input-padrao" disabled>
                    </div>

                    <div>
                        <label class="l">Senha Atual</label>
                        <input value="" class="input-padrao" type="password" id="senha" name="senha" placeholder="Senha Atual">
                    </div>

                    <div>
                        <label class="l">Senha Nova</label>
                        <input value="" class="input-padrao" type="password" id="nova_senha" name="nova_senha" placeholder="Senha Nova">
                    </div>

                    <div>
                        <label class="l">Confirma Senha Nova</label>
                        <input value="" class="input-padrao" type="password" id="confirmacao_nova_senha" name="confirmacao_nova_senha" placeholder="Confirma Senha Nova">
                    </div>

                    <div>
                        <input <?= $administrador->getAtivo() ? 'checked' : '' ?> value="" type="checkbox" id="ativo" name="ativo">
                        <label style="font-size:20px;">Ativo</label>
                    </div>

                </div>

                <div class="c">
                    <a href="tab-adm.php">
                        <button id="voltar_atualizar_adm" class="enviar" type="button">Voltar</button>
                    </a>
                    <button id="atualizar_atualizar_adm" class="enviar" name="btn-atualizar-adm" type="submit">Atualizar</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>