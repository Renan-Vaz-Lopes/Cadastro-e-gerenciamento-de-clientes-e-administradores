<?php
require_once('protect.php');

class Dashboard
{
    public function goTabelaClientes()
    {
        if (isset($_POST['tabela-clientes'])) {
            header("location: clientes/tab-cli.php");
        }
    }

    public function goTabelaAdms()
    {
        if (isset($_POST['tabela-adms'])) {
            header("location: administradores/tab-adm.php");
        }
    }

    public function goLogin()
    {
        if (isset($_POST['voltar-login'])) {
            header("location: logout.php");
        }
    }

    public function __construct()
    {
        $this->goTabelaClientes();
        $this->goTabelaAdms();
        $this->goLogin();
    }
}

$dashboard = new Dashboard();
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
    <link href="css/dash.css" rel="stylesheet">
    <script src="js/jquery-3.6.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js" nonce="26ea8bec-8388-4993-b040-aa998d6957b9"></script>
    <script src="https://use.fontawesome.com/936d3b3449.js"></script>
    <meta name="robots" content="noindex, follow">
    <title>Dashboard</title>
</head>

<body>
    <div class="limiter">
        <div class="container-dash" style="background-image: url('img/3.jpg');">
            <div class="wrap-dash">
                <form action="Dashboard.php" method="post">
                    <h1 class="">Selecione</h1>
                    <button name="tabela-clientes" class="dash_buttons" type="submit">Clientes</button>
                    <button name="tabela-adms" class="dash_buttons" type="submit">Administradores</button>
                    <button name="voltar-login" id="dash_exit" class="dash_buttons" type="submit">Sair</a> </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>