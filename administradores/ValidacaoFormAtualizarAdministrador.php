<?php
require_once('../db/conexao.php');
require_once('../db/admServices.php');

class ValidacaoFormAtualizarAdministrador
{
    private $message = "";
    private $nome;
    private $senha;
    private $nova_senha;
    private $confirmacao_nova_senha;
    private $administrador;
    private $formData;

    const FIELDS_TO_CHECK_EMPTY = [
        'nome',
    ];

    public function __construct(Administrador $administrador, $formData)
    {
        if ($formData == "") return;
        $this->nome = $formData['nome'];
        $this->senha = $formData['senha'];
        $this->nova_senha = $formData['nova_senha'];
        $this->confirmacao_nova_senha = $formData['confirmacao_nova_senha'];
        $this->administrador = $administrador;
        $this->formData = $formData;
        $this->validar();
    }

    private function validar()
    {
        $this->validarCamposVazios();
        $this->validarNome();
        $this->validarMudancaDeSenha();
    }

    public function getMessage()
    {
        return $this->message;
    }

    private function validarMudancaDeSenha()
    {

        if (!empty($this->senha) || !empty($this->nova_senha) || !empty($this->confirmacao_nova_senha)) {

            $this->validarSenhaAtual();
            $this->verSePreencheRequisitosDeSenha();
            $this->verificaSeSenhaEhIgual();

        }
    }


    private function validarSenhaAtual()
    {
        if (!password_verify($this->senha, $this->administrador->getSenha())) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Senha Atual não corresponde</p>";
        }
    }

    private function verSePreencheRequisitosDeSenha()
    {
        if (!$this->validatePassword($this->nova_senha) || !$this->validatePassword($this->confirmacao_nova_senha)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Senha Nova inválida:
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
        if ($this->nova_senha != $this->confirmacao_nova_senha) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Senhas novas não são iguais</p>";
        }
    }

    private function validarNome()
    {
        if (!$this->validateOnlyText($this->nome)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Nome inválido</p>";
        }
    }

    private function validarCamposVazios()
    {
        $request = $this->formData;
        foreach (self::FIELDS_TO_CHECK_EMPTY as $key => $field) {
            if (isset($request[$field]) && empty($request[$field])) {
                $this->message = "<p style='font-size:20px;' class='text-danger'>Preencha os campos destacados</p>";
            }
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
