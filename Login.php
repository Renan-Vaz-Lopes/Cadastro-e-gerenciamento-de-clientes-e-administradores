<!-- //abaixo um exemplo do uso da tag <pre> pra ver melhor o conteudo de uma string ou de um objeto que está sendo passado
//ou que está na mesma página
echo "<pre>";
print_r($usuario);
echo "</pre>";
exit;
-->

<?php
require_once('db/conexao.php');
require_once('db/admServices.php');

class Login
{
    private string $email;
    private string $senha;
    private string $message;

    public function __construct(string $email = '', string $senha = '', string $message = '')
    {
        $this->email = $email;
        $this->senha = $senha;
        $this->message = $message;

        $this->mandarCadastroCliente();
        $this->logar();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function mandarCadastroCliente()
    {
        if (isset($_POST['mandar-para-cadastro-cliente'])) {
            header("location: clientes/cadastrar-cli.php");
        }
    }

    public function logar()
    {
        if (isset($_POST['logar'])) {
            $_POST = $this->popularLogin($_POST);

            $this->verificaSeEstaVazioOsCampos();

            $this->fazLoginOuMostraMensagemDeErro();
        }
    }
    private function popularLogin($login)
    {
        $this->email = isset($login['email']) ? $login['email'] : '';
        $this->senha = isset($login['senha']) ? $login['senha'] : '';

        return $login;
    }
    
    private function verificaSeEstaVazioOsCampos()
    {
        if (empty($this->email)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Preencha os campos destacados</p>";
        } else if (empty($this->senha)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Preencha os campos destacados</p>";
        }
    }

    private function fazLoginOuMostraMensagemDeErro()
    {
        if (empty($this->message)) {
            $pdo = new Conexao();
            $admServices = new AdmServices($pdo);
            $usuario = $admServices->selectAdmLogin($this->email);
            if ($usuario !== false) {
                if (password_verify($this->senha, $usuario['senha']) && $usuario['ativo'] == 1) {
                    if (!isset($_SESSION)) {
                        session_start();
                    }

                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['nome'] = $usuario['nome'];
                    header("location: Dashboard.php");
                } else {
                    $this->message .= "<p style='font-size:20px;' class='text-danger'>Usuário/Senha inválidos</p>";
                }
            } else {
                $this->message .= "<p style='font-size:20px;' class='text-danger'>Usuário/Senha inválidos</p>";
            }
        }
    }
}

$login = new Login();
?>

<!-- EU MUDEI O PHP DO HTML, TROQUEI POR EXEMPLO: "$email" pra "$login->getEmail()" -->

<head>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
        <link href="css/_reboot.scss" rel="stylesheet">
        <link href="css/login.css" rel="stylesheet">
        <script src="js/jquery-3.6.1.min.js" type="text/javascript"></script>
        <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js" nonce="26ea8bec-8388-4993-b040-aa998d6957b9"></script>
        <script src="https://use.fontawesome.com/936d3b3449.js"></script>
        <meta name="robots" content="noindex, follow">
        <title>Login</title>
    </head>

<body>

    <div class="limiter">
        <div class="container-login" style="background-image: url('img/3.jpg');">
            <div class="wrap-login">
                <h1 class="distancia1">Acesse sua conta</h1>
                <div class="message"> <?= $login->getMessage() ?> </div>
                <form class="login-form" action="Login.php" method="post">
                    <div class="wrap-input validate-input m-b-10">
                        <input value="<?= $login->getEmail() ?>" class="input-padrao <?= (empty($login->getEmail()) && !empty($login->getMessage()) ? 'border-danger' : '') ?>" type="text" name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input-user">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="wrap-input validate-input m-b-10">
                        <input value="<?= $login->getSenha() ?>" class="input-padrao <?= (empty($login->getSenha()) && !empty($login->getMessage()) ? 'border-danger' : '') ?>" type="password" name="senha" placeholder="Senha">
                        <span class="focus-input100"></span>
                        <span class="symbol-input-pass">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <button name="logar" class="enviar" type="submit">Login</button>
                    <button name="mandar-para-cadastro-cliente" class="enviar" type="submit">Cadastrar novo cliente</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>