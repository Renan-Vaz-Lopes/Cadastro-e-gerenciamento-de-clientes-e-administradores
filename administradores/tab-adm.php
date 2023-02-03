<?php
require_once('../db/admServices.php');
require_once('../db/conexao.php');
require_once('../protect-adm-cli.php');

echo "<p style='font-size:20px; color:white; text-align:center'>Bem vindo " . $_SESSION['nome'] . ".";
"</p>";

echo "<p style='font-size:20px; color:white; text-align:center; margin-top:55px;'>Tabela de Administradores.</p>";

$pdo = new Conexao();
$admServices = new admServices($pdo);
$dados = $admServices->selectAllAdms();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/tab-adm.css">
    <script src="js/jquery-3.6.1.min.js" type="text/javascript"></script>
    <script src="../js/tabs.js"></script>

    <title>Tabela de Administradores</title>



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
                                <th scope='col'>Ativo</th>
                                <th scope='col'>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($dados as $chave => $valor) {
                                $id = $valor['id'];
                                $nome = $valor['nome'];
                                $email = $valor['email'];
                                $ativo = $valor['ativo'];
                            ?>

                                <tr scope='row'>
                                    <td>
                                        <?= $nome ?>
                                    </td>
                                    <td>
                                        <?= $email ?>
                                    </td>
                                    <td>
                                        <?= $ativo ?>
                                    </td>
                                    <td>
                                        <a class="btn-atualizar-adm" href="http://localhost/crud2-php-POO/administradores/atualizar-adm.php?id=<?= $id ?>">Atualizar</a>
                                        <a class="btn-deletar-adm" onclick="deletar_adm(<?= $id ?>)">Deletar</a>
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

        <div class=adm_buttons>
            <a class="enviar" href="cadastrar-adm.php">Cadastrar novo administrador</a>
        </div>

        <div class=adm_buttons>
            <a class="enviar" href="../Dashboard.php">Voltar ao Dashboard</a>
        </div>

        <div class=sair_button>
            <a class="enviar" href="../logout.php">Sair</a>
        </div>
</body>

</html>