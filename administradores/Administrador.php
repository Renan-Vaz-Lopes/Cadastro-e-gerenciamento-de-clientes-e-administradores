<?php

class Administrador {
    private $nome;
    private $email;
    private $senha;
    private $confirma_senha;
    private $nova_senha;
    private $confirmacao_nova_senha;
    private $ativo;

    public function __construct($DadosDoAdmin)
    {
        $this->nome  = $DadosDoAdmin['nome']  ?? '';
        $this->email = $DadosDoAdmin['email'] ?? '';
        $this->senha = $DadosDoAdmin['senha'] ?? '';
        $this->confirma_senha = $DadosDoAdmin['confirma_senha'] ?? '';
        $this->nova_senha = $DadosDoAdmin['nova_senha'] ?? '';  
        $this->confirmacao_nova_senha = $DadosDoAdmin['confirmacao_nova_senha'] ?? '';                
        $this->ativo = $DadosDoAdmin['ativo'] ?? '';        
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getSenha()
    {
        return $this->senha;
    }   
    
    public function getConfirmaSenha()
    {
        return $this->confirma_senha;
    }
    
    public function getNovaSenha()
    {
        return $this->nova_senha;
    }

    public function getConfirmacaoNovaSenha()
    {
        return $this->confirmacao_nova_senha;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }

    public function getEmail()
    {
        return $this->email;
    }  
}