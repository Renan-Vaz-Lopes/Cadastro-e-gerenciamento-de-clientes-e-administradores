<?php
require_once('../db/conexao.php');
require_once('../Limpar.php');
require_once('../db/clientServices.php');
require_once('./Cliente.php');
require_once('./ValidacaoFormCadastrarCliente.php');
require_once('../manda-email-pro-cliente.php');

setlocale(LC_ALL, 'pt_BR', 'pt_BR.UTF-8', 'pt_BR.UTF-8', 'portuguese');

$limparPost = new Limpar();
$pdo = new Conexao();
$clientServices = new ClientServices($pdo);
$cliente = new Cliente($_POST);
$validacaoFormCadastrarCliente = new ValidacaoFormCadastrarCliente($cliente,$_POST);
$mandaEmail = new MandaEmailProCliente();

if (isset($_POST['btn-cadastrar-cli'])) {
    $_POST = $limparPost->limpaPostCliente($_POST);
    $cliente = new Cliente($_POST);
    $validacaoFormCadastrarCliente = new ValidacaoFormCadastrarCliente($cliente,$_POST);
    if (empty($validacaoFormCadastrarCliente->getMessage())) {
        $mandaEmail->mandarEmailProClienteConfirmarEAdicionaNoBd($_POST, $clientServices);
    } else {
        $cliente = new Cliente($_POST);
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
    <link href="../css/cadastrar-cli.css" rel="stylesheet">
    <script src="../js/jquery-3.6.1.min.js" type="text/javascript"></script>
    <script src="../js/jquery.mask.min.js" type="text/javascript"></script>
    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js" nonce="26ea8bec-8388-4993-b040-aa998d6957b9"></script>
    <script src="https://use.fontawesome.com/936d3b3449.js"></script>
    <script src="../js/viacep.js" type="text/javascript"></script>
    <meta name="robots" content="noindex, follow">

    <script type="text/javascript">
        // MÁSCARAS
        $(document).ready(function() {
            $("#telefone").mask("(00) 00000-0000");
            $("#cpf").mask("000.000.000-00");
            $("#cep").mask("00000-000");
            $("#dataDeNascimento").mask("00/00/0000");
        })
    </script>

    <script>
        function validardataDeNascimento(strData) {
            if (strData.length == 10) {
                var partesData = strData.split("/")
                var data = new Date(partesData[2], partesData[1] - 1, partesData[0])

                if (partesData[0] > 31) {
                    alert("Data Inválida")
                    return false;
                } else if (partesData[1] > 12) {
                    alert("Data Inválida")
                    return false;
                } else if (data > new Date()) {
                    alert("Data Inválida")
                    return false;
                } else {
                    return true;
                }
            }
        }

        function validarCPF(strcpf) {
            if (strcpf.length == 14) {
                strcpf = strcpf.replace(/[^\d]+/g, '');

                if (strcpf == '') {
                    alert("CPF Inválido")
                    return false
                }
                // Elimina CPFs invalidos conhecidos	
                if (strcpf.length != 11 ||
                    strcpf == "00000000000" ||
                    strcpf == "11111111111" ||
                    strcpf == "22222222222" ||
                    strcpf == "33333333333" ||
                    strcpf == "44444444444" ||
                    strcpf == "55555555555" ||
                    strcpf == "66666666666" ||
                    strcpf == "77777777777" ||
                    strcpf == "88888888888" ||
                    strcpf == "99999999999") {
                    alert("CPF Inválido")
                    return false;
                }

                // Valida 1o digito	
                add = 0;
                for (i = 0; i < 9; i++)
                    add += parseInt(strcpf.charAt(i)) * (10 - i);
                rev = 11 - (add % 11);
                if (rev == 10 || rev == 11)
                    rev = 0;
                if (rev != parseInt(strcpf.charAt(9))) {
                    alert("CPF Inválido")
                    return false;
                }

                // Valida 2o digito	
                add = 0;
                for (i = 0; i < 10; i++)
                    add += parseInt(strcpf.charAt(i)) * (11 - i);
                rev = 11 - (add % 11);
                if (rev == 10 || rev == 11)
                    rev = 0;
                if (rev != parseInt(strcpf.charAt(10))) {
                    alert("CPF Inválido")
                    return false;
                }
                return true;
            }
        }

        function validarEmail(email) {
            var re = /\S+@\S+\.\S+/;
            if (!re.test(email)) {
                alert("Email Inválido")
            }
        }
    </script>

    <title>Cadastrar Clientes</title>

</head>

<body>
    <section>
        <div class="container">
            <div class="box1">
                <h4 class="t"><label class="m">Preencha com suas informações pessoais</label></h4>
                <div class="message"> <?= $validacaoFormCadastrarCliente->getMessage() ?> </div>
                <form method="post" action="#">
                    <input type="hidden" name="token">
                    <div class="grid-container">

                        <div class="grid-item item1">
                            <div class="boxflex">
                                <label class="l">CPF</label>
                                <?php
                                ?>
                                <input maxlength="14" id="cpf" oninput="validarCPF(this.value);" value="<?= $cliente->getCPF()  ?>" class="input-padrao <?= (empty($cliente->getCPF()) && !empty($validacaoFormCadastrarCliente->getMessage()) ) ? 'border-danger' : '' ?>" type="text" name="cpf" placeholder="000.000.000-00">
                            </div>
                        </div>

                        <div class="grid-item item2">
                            <div class="boxflex">
                                <label class="l">Nome</label>
                                <input value="<?= $cliente->getNome() ?>" class="input-padrao <?= (empty($cliente->getNome()) && !empty($validacaoFormCadastrarCliente->getMessage()) ) ? 'border-danger' : '' ?>" type="text" name="nome" placeholder="Seu nome completo">
                            </div>
                        </div>

                        <div class="grid-item item3">
                            <div class="boxflex">
                                <label class="l">Email</label>
                                <input value="<?= $cliente->getEmail() ?>" id="email" onblur="validarEmail(this.value);" class="input-padrao <?= (empty($cliente->getEmail()) && !empty($validacaoFormCadastrarCliente->getMessage()) ? 'border-danger' : '') ?>" type="email" name="email" placeholder="email@email.com">
                            </div>
                        </div>

                        <div class="grid-item item4">
                            <div class="boxflex">
                                <label class="l">Data de Nascimento</label>
                                <input maxlength="10" id="dataDeNascimento" oninput="validardataDeNascimento(this.value);" value="<?= $cliente->getDataNascimento() ?>" class="input-padrao <?= (empty($cliente->getDataNascimento()) && !empty($validacaoFormCadastrarCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" name="data_nascimento" placeholder="__/__/____">
                            </div>
                        </div>

                        <div class="grid-item item5">
                            <div class="boxquebratelefone">
                                <label>Telefone</label>
                                <input maxlength="14" value="<?= $cliente->getTelefone() ?>" id="telefone" class="input-padrao <?= (empty($cliente->getTelefone()) && !empty($validacaoFormCadastrarCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" name="telefone" placeholder="(__) _____-____">
                            </div>
                        </div>

                        <div class="grid-item item6">
                            <label class="l">Endereço</label>
                        </div>

                        <div class="grid-item item7">
                            <div class="boxflex">
                                <label class="l">CEP</label>
                                <input value="<?= $cliente->getCEP() ?>" id="cep" class="input-padrao <?= (empty($cliente->getCEP()) && !empty($validacaoFormCadastrarCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" name="cep" placeholder="_____-___" size="10" maxlength="9" oninput="pesquisacep(this.value);">
                            </div>
                        </div>

                        <div class="grid-item item8">
                            <div class="boxflex">
                                <label class="l">Rua</label>
                                <input value="<?= $cliente->getRua() ?>" class="input-padrao <?= (empty($cliente->getRua()) && !empty($validacaoFormCadastrarCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="rua" name="rua" placeholder="Rua">
                            </div>
                        </div>

                        <div class="grid-item item9">
                            <div class="boxquebranumero">
                                <label>Número</label>
                                <input value="<?= $cliente->getNumero() ?>" class="input-padrao <?= (empty($cliente->getNumero()) && !empty($validacaoFormCadastrarCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" name="numero" placeholder="Nº">
                            </div>
                        </div>

                        <div class="grid-item item10">
                            <div class="boxflex">
                                <label class="l">Complemento</label>
                                <input value="<?= isset($_POST['complemento']) ? $_POST['complemento'] : '' ?>" class="input-padrao" type="text" name="complemento" placeholder="Complemento">
                            </div>
                        </div>

                        <div class="grid-item item11">
                            <div class="boxquebraresto">
                                <label>Bairro</label>
                                <input value="<?= $cliente->getBairro() ?>" class="input-padrao <?= (empty($cliente->getBairro()) && !empty($validacaoFormCadastrarCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="bairro" name="bairro" placeholder="Bairro">
                            </div>
                        </div>

                        <div class="grid-item item12">
                            <div class="boxflex">
                                <label class="l">Cidade</label>
                                <input value="<?= $cliente->getCidade() ?>" class="input-padrao <?= (empty($cliente->getCidade()) && !empty($validacaoFormCadastrarCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="cidade" name="cidade" placeholder="Cidade">
                            </div>
                        </div>

                        <div class="grid-item item13">
                            <div class="boxquebraresto">
                                <label>Estado</label>
                                <input value="<?= $cliente->getEstado() ?>" class="input-padrao <?= (empty($cliente->getEstado()) && !empty($validacaoFormCadastrarCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="uf" name="estado" placeholder="Estado">
                            </div>
                        </div>
                    </div>

                    <div class="c">
                        <a href="../Login.php">
                            <button id="voltar_cadastrar_cliente" class="enviar" type="button" name="voltar-login">Voltar</button>
                        </a>
                        <button id="enviar_cadastrar_cliente" class="enviar" type="submit" name="btn-cadastrar-cli">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>