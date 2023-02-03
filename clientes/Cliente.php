<?php
class Cliente
{
    private $nome;
    private $email;
    private $dataNascimento;
    private $telefone;
    private $cpf;
    private $cep;
    private $rua;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;

    public function __construct($DadosDoCliente = "") {
        $this->nome = $DadosDoCliente['nome'] ?? '';
        $this->email = $DadosDoCliente['email'] ?? '';
        $this->dataNascimento = $DadosDoCliente['data_nascimento'] ?? '';
        $this->telefone = $DadosDoCliente['telefone'] ?? '';
        $this->cpf = $DadosDoCliente['cpf'] ?? '';
        $this->cep = $DadosDoCliente['cep'] ?? '';
        $this->rua = $DadosDoCliente['rua'] ?? '';
        $this->numero = $DadosDoCliente['numero'] ?? '';
        $this->complemento = $DadosDoCliente['complemento'] ?? '';
        $this->bairro = $DadosDoCliente['bairro'] ?? '';
        $this->cidade = $DadosDoCliente['cidade'] ?? '';
        $this->estado = $DadosDoCliente['estado'] ?? '';
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getCPF()
    {
        return $this->cpf;
    }

    public function getCEP()
    {
        return $this->cep;
    }

    public function getRua()
    {
        return $this->rua;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function getComplemento()
    {
        return $this->complemento;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function getEstado()
    {
        return $this->estado;
    }
}
