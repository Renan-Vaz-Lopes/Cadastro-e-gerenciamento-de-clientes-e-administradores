<?php
// include ('protect.php');

class Limpar
{
    //FUNÇÃO PARA SANITIZAR (LIMPAR ENTRADAS)
    public function limparPost($dado)
    {
        $dado = trim($dado);
        $dado = stripslashes($dado);
        $dado = htmlspecialchars($dado);
        return $dado;
    }

    public function limpaPostCadastraAdm($admin)
    {
        $admin['nome'] = $this->limparPost($admin['nome']);
        $admin['email'] = $this->limparPost($admin['email']);
        $admin['senha'] = $this->limparPost($admin['senha']);
        $admin['confirma_senha'] = $this->limparPost($admin['confirma_senha']);
        return $admin;
    }

    public function limpaPostAtualizaAdm($admin)
    {
        $admin['nome'] = $this->limparPost($admin['nome']);
        $admin['senha'] = $this->limparPost($admin['senha']);
        $admin['nova_senha'] = $this->limparPost($admin['nova_senha']);
        $admin['confirma_nova_senha'] = $this->limparPost($admin['confirmacao_nova_senha']);
        return $admin;
    }

    public function limpaPostCliente($cliente)
    {
        $cliente['nome'] = $this->limparPost($cliente['nome']);
        $cliente['email'] = $this->limparPost($cliente['email']);
        $cliente['dataNascimento'] = $this->limparPost($cliente['data_nascimento']);
        $cliente['telefone'] = $this->limparPost($cliente['telefone']);
        $cliente['cpf'] = $this->limparPost($cliente['cpf']);
        $cliente['cep'] = $this->limparPost($cliente['cep']);
        $cliente['rua'] = $this->limparPost($cliente['rua']);
        $cliente['numero'] = $this->limparPost($cliente['numero']);
        $cliente['complemento'] = $this->limparPost($cliente['complemento']);
        $cliente['bairro'] = $this->limparPost($cliente['bairro']);
        $cliente['cidade'] = $this->limparPost($cliente['cidade']);
        $cliente['estado'] = $this->limparPost($cliente['estado']);

        return $cliente;
    }

}

