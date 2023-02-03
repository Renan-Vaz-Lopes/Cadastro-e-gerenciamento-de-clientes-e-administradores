<?php
require_once('../db/conexao.php');
require_once('../db/admServices.php');

class ValidacaoFormCadastrarAdministrador
{
    private $message = "";
    private $nome;
    private $email;
    private $senha;
    private $confirma_senha;
    private $formData;

    const FIELDS_TO_CHECK_EMPTY = [
        'nome',
        'email',
        'senha',
        'confirma_senha'
    ];

    public function __construct(Administrador $administrador)
    {
        $this->nome = $administrador->getNome();
        $this->email = $administrador->getEmail();
        $this->senha =$administrador->getSenha();
        $this->confirma_senha = $administrador->getConfirmaSenha();
        $this->verificaSeExistePOST();
    }

    private function verificaSeExistePOST()
    {
        if(isset($_POST['btn-cadastrar-adm'])) $this->validar();
    }

    private function validar()
    {
        $this->validateFields();
        $this->validarNome();
        $this->validarFormatoDoEmail();
        $this->validarSenha();
    }

    public function getMessage()
    {
        return $this->message;
    }

    private function validarNome()
    {
        if (!$this->validateOnlyText($this->nome)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Nome inválido</p>";
        }
    }

    private function validarSenha()
    {
        $this->verSePreencheRequisitosDeSenha();
        $this->verificaSeSenhaEhIgual();        
    }

    private function validateFields()
    {
        $request = $this->formData;
        foreach (self::FIELDS_TO_CHECK_EMPTY as $key => $field) {
            if (isset($request[$field]) && empty($request[$field])) {
                $this->message = "<p style='font-size:20px;' class='text-danger'>Preencha os campos destacados</p>";
            }
        }
    }

    private function validarFormatoDoEmail()
    {
        // Remove os caracteres ilegais, caso tenha
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);

        // Valida o e-mail
        $validEmail = filter_var($this->email, FILTER_VALIDATE_EMAIL);

        if (!$validEmail) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Email inválido</p>";
        }
    }

    private function verSePreencheRequisitosDeSenha()
    {
        if (!$this->validatePassword($this->senha) || !$this->validatePassword($this->confirma_senha)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Senha inválida:
            Tem que ter pelo menos: <br>
            -1 letra minúscula <br>
            -1 letra maiúscula <br>
            -1 número <br>
            -1 caractere especial <br>
            -8 caracteres</p>";
        }
    }

    private function verificaSeSenhaEhIgual()
    {
        if ($this->senha != $this->confirma_senha) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Senhas Novas não são iguais</p>";
        }
    }

    private function validateOnlyText($string)
    {
        if (!!preg_match('|^[\pL\s]+$|u', $string)) {
            return true;
        }
        return false;
    }

    private function validatePassword($password)
    {
        if (mb_strpos($password, ' ') !== false) {
            return false;
        }
        $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W|_).\S{8,36}$/';
        return preg_match($pattern, $password) ? true : false;
    }
}