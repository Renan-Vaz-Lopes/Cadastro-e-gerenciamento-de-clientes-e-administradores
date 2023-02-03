<?php
require_once('../protect-adm-cli.php');
require_once('../db/clientServices.php');
require_once('../db/conexao.php');

echo "<p style='font-size:20px; color:white; text-align:center'>Bem vindo " . $_SESSION['nome'];
"</p>" . ".";

echo "<p style='font-size:20px; color:white; text-align:center; margin-top:55px;'>Tabela de Clientes</p>" . ".";

$pdo = new Conexao();
$clientServices = new clientServices($pdo);
$dados = $clientServices->selectAllClients();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/tab-cli.css">
    <script src="js/jquery-3.6.1.min.js" type="text/javascript"></script>
    <script src="../js/tabs.js"></script>
    <script src="js/jquery.mask.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        // MÁSCARAS
        $(document).ready(function() {
            $("#telefone").mask("(00) 00000-0000");
            $("#cpf").mask("000.000.000-00");
            $("#cep").mask("00000-000");
            $("#data_nascimento").mask("00/00/0000");
        })
    </script>

    <title>Tabela de clientes</title>
</head>

<body>

    <?php
    if (count($dados) > 0) {
    ?>
        <div class="content">
            <div class="container">
                <div class="table-responsive custom-table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th scope='col'>Nome</th>
                                <th scope='col'>Email</th>
                                <th scope='col'>Data de nascimento</th>
                                <th scope='col'>Telefone</th>
                                <th scope='col'>CPF</th>
                                <th scope='col'>CEP</th>
                                <th scope='col'>Rua</th>
                                <th scope='col'>Numero</th>
                                <th scope='col'>Complemento</th>
                                <th scope='col'>Bairro</th>
                                <th scope='col'>Cidade</th>
                                <th scope='col'>Estado</th>
                                <th scope='col'>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($dados as $chave => $valor) {
                                $id = $valor['id'];
                                $nome = $valor['nome'];
                                $email = $valor['email'];
                                $data_nascimento = $valor['data_nascimento'];
                                $telefone = $valor['telefone'];
                                $cpf = $valor['cpf'];
                                $cep = $valor['cep'];
                                $rua = $valor['rua'];
                                $numero = $valor['numero'];
                                $complemento = $valor['complemento'];
                                $bairro = $valor['bairro'];
                                $cidade = $valor['cidade'];
                                $estado = $valor['estado'];
                            ?>

                                <tr scope='row'>
                                    <td>
                                        <?= $nome ?>
                                    </td>
                                    <td>
                                        <?= $email ?>
                                    </td>
                                    <td>
                                        <?= $data_nascimento ?>
                                    </td>
                                    <td>
                                        <?= $telefone ?>
                                    </td>
                                    <td>
                                        <?= $cpf ?>
                                    </td>
                                    <td>
                                        <?= $cep ?>
                                    </td>
                                    <td>
                                        <?= $rua ?>
                                    </td>
                                    <td>
                                        <?= $numero ?>
                                    </td>
                                    <td>
                                        <?= $complemento ?>
                                    </td>
                                    <td>
                                        <?= $bairro ?>
                                    </td>
                                    <td>
                                        <?= $cidade ?>
                                    </td>
                                    <td>
                                        <?= $estado ?>
                                    </td>
                                    <td>
                                        <div>
                                            <a class="btn-atualizar-cli" href="http://localhost/crud2-php-POO/clientes/atualizar-cli.php?id=<?= $id ?>">Atualizar</a>
                                        </div>

                                        <div class="btn-deletar-acoes">
                                            <a class="btn-deletar-cli" onclick="deletar_cli(<?= $id ?>)">Deletar</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class='spacer'>
                                    <td colspan='100'></td>
                                </tr>

                        <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        </table>
        </div>
        </div>
        </div>

        <div class=cli_buttons>
            <a class="enviar" href="../Dashboard.php">Voltar ao Dashboard</a>
        </div>

        <div class=cli_buttons>
            <a class="enviar" href="../logout.php">Sair</a>
        </div>
</body>

</html>