<?php
require_once('../db/clientServices.php');
require_once('../Limpar.php');
require_once('../db/conexao.php');
require_once('./Cliente.php');
require_once('./ValidacaoFormAtualizarCliente.php');
require_once('../protect-adm-cli.php');

setlocale(LC_ALL, 'pt_BR', 'pt_BR.UTF-8', 'pt_BR.UTF-8', 'portuguese');

$id = (trim(strip_tags($_GET['id'])));
$limparPost = new Limpar();
$pdo = new Conexao();
$clientServices = new ClientServices($pdo);
$dataCliente = $clientServices->selectClientById($id);
$cliente = new Cliente($dataCliente);
$validacaoFormCliente = null;

if (isset($_POST['btn-atualizar-cli'])) {
    $_POST = $limparPost->limpaPostCliente($_POST);
    $validacaoFormCliente = new ValidacaoFormCliente($_POST);
    if (empty($validacaoFormCliente->getMessage())) {
        $clientServices->updateClient($_POST);  
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
    <link href="../css/atualizar-cli.css" rel="stylesheet">
    <script src="../js/jquery-3.6.1.min.js" type="text/javascript"></script>
    <script src="../js/jquery.mask.min.js" type="text/javascript"></script>
    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js" nonce="26ea8bec-8388-4993-b040-aa998d6957b9"></script>
    <script src="https://use.fontawesome.com/936d3b3449.js"></script>
    <script type="text/javascript" src="../js/viacep.js"></script>
    <meta name="robots" content="noindex, follow">

    <script type="text/javascript">
        // MÁSCARAS
        $(document).ready(function() {
            $("#telefone").mask("(00) 00000-0000");
            $("#cpf").mask("000.000.000-00");
            $("#cep").mask("00000-000");
            $("#data_nascimento").mask("00/00/0000");
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

    <title>Atualizar Clientes</title>
</head>


<body>
    <div class="container">
        <div class="box1">
            <h4 class="t"><label class="m">Atualizar Cliente</label></h4>
            <div class="message"> <?= !is_null($validacaoFormCliente) ? $validacaoFormCliente->getMessage() : '' ?> </div>
            <form method="post" action="#">
                <input type="hidden" id="id" name="id" placeholder="ID" value="<?= $id ?>">
                <div class="grid-container">

                    <div class="grid-item item1">
                        <div class="boxflex">
                            <label class="l">CPF</label>
                            <input maxlength="14" oninput="validarCPF(this.value);" class="input-padrao <?= (empty($cliente->getCPF()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="cpf" name="cpf" placeholder="Editar CPF" value="<?= $cliente->getCPF() ?>">
                        </div>
                    </div>
                    
                    <div class="grid-item item2">
                        <div class="boxflex">
                            <label class="l">Nome</label>
                            <input class="input-padrao <?= (empty($cliente->getNome()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="nome" name="nome" placeholder="Editar nome" value="<?= $cliente->getNome() ?>">
                        </div>
                    </div>

                    <div class="grid-item item3">
                        <div class="boxflex">
                            <label class="l">Email</label>
                            <input onblur="validarEmail(this.value);" class="input-padrao <?= (empty($cliente->getEmail()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" type="email" id="email" name="email" placeholder="Editar email" value="<?= $cliente->getEmail() ?>">
                        </div>
                    </div>

                    <div class="grid-item item4">
                        <div class="boxflex">
                            <label class="l">Data de nascimento</label>
                            <input maxlength="10" class="input-padrao <?= (empty($cliente->getDataNascimento()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" oninput="validardataDeNascimento(this.value);" type="text" id="data_nascimento" name="data_nascimento" placeholder="Editar data de nascimento" value="<?= $cliente->getDataNascimento() ?>">
                        </div>
                    </div>

                    <div class="grid-item item5">
                        <div class="boxquebratelefone">
                            <label class="l">Telefone</label>
                            <input maxlength="14" value="<?= $cliente->getTelefone() ?>" id="telefone" class="input-padrao <?= (empty($cliente->getTelefone()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" name="telefone" placeholder="Editar telefone">
                        </div>
                    </div>

                    <div class="grid-item item6">
                        <label class="l">Endereço</label>
                    </div>

                    <div class="grid-item item7">
                        <div class="boxflex">
                            <label class="l">CEP</label>
                            <input value="<?= $cliente->getCEP() ?>" id="cep" class="input-padrao <?= (empty($cliente->getCEP()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" name="cep" placeholder="Editar CEP" size="10" maxlength="9" oninput="pesquisacep(this.value);">
                        </div>
                    </div>

                    <div class="grid-item item8">
                        <div class="boxflex">
                            <label class="l">Rua</label>
                            <input class="input-padrao <?= (empty($cliente->getRua()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="rua" name="rua" placeholder="Editar rua" value="<?= $cliente->getRua() ?>">
                        </div>
                    </div>

                    <div class="grid-item item9">
                        <div class="boxquebranumero">
                            <label class="l">Numero</label>
                            <input class="input-padrao <?= (empty($cliente->getNumero()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="numero" name="numero" placeholder="Editar número da rua" value="<?= $cliente->getNumero() ?>">
                        </div>
                    </div>

                    <div class="grid-item item10">
                        <div class="boxflex">
                            <label class="l">Complemento</label>
                            <input class="input-padrao" type="text" id="complemento" name="complemento" placeholder="Editar complemento da rua" value="<?= $cliente->getComplemento() ?>">
                        </div>
                    </div>

                    <div class="grid-item item11">
                        <div class="boxquebraresto">
                            <label class="l">Bairro</label>
                            <input class="input-padrao <?= (empty($cliente->getBairro()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="bairro" name="bairro" placeholder="Editar bairro" value="<?= $cliente->getBairro() ?>">
                        </div>
                    </div>

                    <div class="grid-item item12">
                        <div class="boxflex">
                            <label class="l">Cidade</label>
                            <input class="input-padrao <?= (empty($cliente->getCidade()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="cidade" name="cidade" placeholder="Editar cidade" value="<?= $cliente->getCidade() ?>">
                        </div>
                    </div>

                    <div class="grid-item item13">
                        <div class="boxquebraresto">
                            <label class="l">Estado</label>
                            <input class="input-padrao <?= (empty($cliente->getEstado()) && !empty($validacaoFormCliente->getMessage()) ? 'border-danger' : '') ?>" type="text" id="uf" name="estado" placeholder="Editar estado" value="<?= $cliente->getEstado() ?>">
                        </div>
                    </div>
                </div>

                <div class="c">
                    <a href="tab-cli.php">
                        <button id="voltar_atualizar_cliente" class="enviar" type="button" id="cancelar" name="cancelar">Cancelar</button>
                    </a>
                    <button id="enviar_atualizar_cliente" class="enviar" type="submit" name="btn-atualizar-cli">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>