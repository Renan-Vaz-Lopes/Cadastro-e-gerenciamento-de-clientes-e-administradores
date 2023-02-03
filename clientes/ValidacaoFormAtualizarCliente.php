<?php
require_once('../db/conexao.php');
require_once('../db/clientServices.php');

class ValidacaoFormCliente
{
    private $message = "";
    private $nome;
    private $email;
    private $dataNascimento;
    private $telefone;
    private $cpf;
    private $cep;
    private $numero;
    private $cidade;
    private $estado;
    private $formData;

    const FIELDS_TO_CHECK_EMPTY = [
        'nome',
        'email',
        'data_nascimento',
        'telefone',
        'cpf',
        'cep',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
    ];

    public function __construct($formData = "")
    {
        if($formData=="") return;
        $this->nome = $formData['nome'];
        $this->email = $formData['email'];
        $this->dataNascimento = $formData['data_nascimento'];
        $this->telefone = $formData['telefone'];
        $this->cpf = $formData['cpf'];
        $this->cep = $formData['cep'];
        $this->numero = $formData['numero'];
        $this->cidade = $formData['cidade'];
        $this->estado = $formData['estado'];
        $this->formData = $formData;
        $this->validar();
    }

    private function validar()
    {
        $this->validateFields();
        $this->validarNome();
        $this->validarFormatoDoEmail();
        $this->validarDataDeNascimento();
        $this->validarTelefone();
        $this->validarCPF();
        $this->validarFormatoDoCEP();
        $this->validarCidade();
        $this->validarEstado();
        $this->validarNumero();

        if (isset($formData['salvar'])) {
            $this->veSeExisteCPF($formData);
        }
    }

    public function getMessage()
    {
        return $this->message;
    }

    private function validarCPF()
    {
        if (!$this->validateCPF($this->cpf)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>CPF inválido</p>";
        }
    }

    private function validarNome()
    {
        if (!$this->validateOnlyText($this->nome)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Nome inválido</p>";
        }
    }

    private function validarCidade()
    {
        if (!$this->validateOnlyText($this->cidade)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Cidade inválida</p>";
        }
    }

    private function validarEstado()
    {
        if (!$this->validateOnlyText($this->estado)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Estado inválido</p>";
        }
    }

    private function validarNumero()
    {
        if (!$this->validateNumber($this->numero)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Numero inválido</p>";
        }
    }

    private function validarTelefone()
    {
        if (!$this->validatePhone($this->telefone)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Telefone inválido</p>";
        }
    }

    private function validarFormatoDoEmail()
    {
        if (!$this->validateFormatEmail($this->email)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Formato do email inválido</p>";
        }
    }

    private function validarDataDeNascimento()
    {
        if (!$this->validateBirthdate($this->dataNascimento)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>Data de nascimento inválida</p>";
        }
    }

    private function validarFormatoDoCEP()
    {
        if (!$this->validateCEPformat($this->cep)) {
            $this->message .= "<p style='font-size:20px;' class='text-danger'>CEP inválido</p>";
        }
    }

    public function veSeExisteCPF($formData)
    {
        $pdo = new Conexao();
        $clientServices = new ClientServices($pdo);
        $cpf_existe = $clientServices->selectClientByCpf($formData['cpf']);
        if ($cpf_existe) {
            $this->message .= "<p style='font-size:20px; color:red;'>Esse cpf já existe</p>";
        }
    }

    private function validateFields()
    {
        $request = $this->formData;
        foreach (self::FIELDS_TO_CHECK_EMPTY as $key => $field) {
            if (isset($request[$field]) && empty($request[$field])) {
                $this->message = "<p style='font-size:20px;' class='text-danger'>Preencha os campos destacados</p>";
                return $this->message;
            }
        }
        return $this->message;
    }

    private function validateCPF($number)
    {
        $cpf = preg_replace('/[^0-9]/', "", $number);

        if (strlen($cpf) != 11 || preg_match('/([0-9])\1{10}/', $cpf)) {
            return false;
        }

        $number_quantity_to_loop = [9, 10];

        foreach ($number_quantity_to_loop as $item) {

            $sum = 0;
            $number_to_multiplicate = $item + 1;

            for ($index = 0; $index < $item; $index++) {

                $sum += $cpf[$index] * ($number_to_multiplicate--);
            }

            $result = (($sum * 10) % 11);

            if ($cpf[$item] != $result) {
                return false;
            }
        }

        return true;
    }

    private function validateOnlyText($string)
    {
        if (!!preg_match('|^[\pL\s]+$|u', $string)) {
            return true;
        }
        return false;
    }

    private function validateFormatEmail($email)
    {
        // Remove os caracteres ilegais, caso tenha
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Valida o e-mail
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function validateBirthdate($date)
    {
        if (empty($date) || !strpos($date, "/")) {
            return false;
        }

        list($dia, $mes, $ano) = explode("/", $date);
        $dataValida = checkdate($mes, $dia, $ano);
        $timestampDataAtual      = strtotime("now");
        $timestampDataNascimento = strtotime($ano . "-" . $mes . "-" . $dia);
        if (!$dataValida || $timestampDataNascimento > $timestampDataAtual || !$this->validateBirthdateFormat($date)) {
            return false;
        }

        return true;
    }

    private function validateBirthdateFormat($date)
    {
        if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $date)) {
            return false;
        }
        return true;
    }

    private function validateNumber($number)
    {
        if (!is_numeric($number)) {
            return false;
        }

        return true;
    }

    private function validatePhone($telefone)
    {
        if (!preg_match('^\([0-9]{2}\) [0-9]{5}-[0-9]{4}$^', $telefone)) {
            return false;
        }

        return true;
    }

    private function validateCEPformat($cep)
    {
        if (!preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cep)) {
            return false;
        }
        return true;
    }
}
