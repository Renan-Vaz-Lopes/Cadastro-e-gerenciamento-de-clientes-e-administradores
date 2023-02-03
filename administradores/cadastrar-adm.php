<?php
require_once('../db/conexao.php');
require_once('../limpar.php');
require_once('../db/admServices.php');
require_once('./Administrador.php');
require_once('./ValidacaoFormCadastrarAdministrador.php');
require_once('../protect-adm-cli.php');

setlocale(LC_ALL, 'pt_BR', 'pt_BR.UTF-8', 'pt_BR.UTF-8', 'portuguese');

$limparPost = new Limpar();
$pdo = new Conexao();
$admServices = new AdmServices($pdo);
$administrador = new Administrador($_POST);
$validacaoFormAdministrador = new ValidacaoFormCadastrarAdministrador($administrador);

if (isset($_POST['btn-cadastrar-adm'])) {
    $_POST = $limparPost->limpaPostCadastraAdm($_POST);
    $administrador = new Administrador($_POST);
    $validacaoFormCadastrarAdministrador = new ValidacaoFormCadastrarAdministrador($administrador);
    if (empty($validacaoFormAdministrador->getMessage())) {
        $admServices->insertAdm($_POST);
    } else {
        $administrador = new Administrador($_POST);
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <link href="../css/_reboot.scss" rel="stylesheet">
    <link href="../css/cadastrar-adm.css" rel="stylesheet">
    <script src="js/jquery-3.6.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js" nonce="26ea8bec-8388-4993-b040-aa998d6957b9"></script>
    <script src="https://use.fontawesome.com/936d3b3449.js"></script>
    <meta name="robots" content="noindex, follow">
    <title>Cadastrar Administrador</title>
</head>

<body>
    <section>
        <div class="container">
            <form method="post" action="#">
                <div class="box1">
                    <div class="box2">
                        <h4 class="t">Preencha com suas informações pessoais</h4>
                        <div class="message"> <?= $validacaoFormAdministrador->getMessage() ?> </div>

                        <div>
                            <label class="l">Nome</label>
                            <input value="<?= $administrador->getNome() ?>" class="input-padrao <?= (empty($administrador->getNome()) && !empty($validacaoFormAdministrador->getMessage()) ? 'border-danger' : '') ?>" type="text" id="nome" name="nome" placeholder="Seu nome completo">
                        </div>

                        <div>
                            <label class="l">E-mail</label>
                            <input value="<?= $administrador->getEmail() ?>" class="input-padrao <?= (empty($administrador->getEmail()) && !empty($validacaoFormAdministrador->getMessage()) ? 'border-danger' : '') ?>" type="email" id="email" name="email" placeholder="email@email.com">
                        </div>

                        <div>
                            <label class="l">Senha</label>
                            <input value="<?= $administrador->getSenha() ?>" class="input-padrao <?= (empty($administrador->getSenha()) && !empty($validacaoFormAdministrador->getMessage()) ? 'border-danger' : '') ?>" type="password" id="senha" name="senha" placeholder="Senha">
                        </div>

                        <div>
                            <label class="l">Confirme a senha</label>
                            <input value="<?= $administrador->getSenha() ?>" class="input-padrao <?= (empty($administrador->getSenha()) && !empty($validacaoFormAdministrador->getMessage()) ? 'border-danger' : '') ?>" type="password" id="confirma_senha" name="confirma_senha" placeholder="Confirme Senha">
                        </div>

                        <div>
                            <input value="<?= $administrador->getAtivo() ?>" checked="checked" type="checkbox" id="ativo" name="ativo" value="1">
                            <label style="font-size:20px;">Ativo</label>
                        </div>

                    </div>

                    <div class="c">
                        <a href="tab-adm.php">
                            <button id="voltar_cadastrar_adm" class="enviar" type="button">Voltar</button>
                        </a>
                        <button id="cadastrar_cadastrar_adm" class="enviar" name="btn-cadastrar-adm" type="submit">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>

</html>