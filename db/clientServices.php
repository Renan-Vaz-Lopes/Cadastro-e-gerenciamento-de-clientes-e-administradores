<?php
require_once('conexao.php');

class ClientServices
{
    private $conexao;

    public function __construct($conexao)
    {   
        $this->conexao = $conexao;        
    }


    public function selectAllClients()
    {
        $sql = $this->conexao->getPDO()->prepare("SELECT * FROM clientes WHERE token IS NULL");
        $sql->execute();
        $dados = $sql->fetchAll();
        return $dados;
    }

    public function selectClientById(int $id)
    {
        $sql = $this->conexao->getPDO()->prepare("SELECT * from clientes WHERE id='$id'");
        $sql->execute();
        $dados = $sql->fetch(PDO::FETCH_ASSOC);
        return $dados;
    }

    public function selectClientByCpf(string $cpf)
    {
        $sql = $this->conexao->getPDO()->prepare("SELECT cpf FROM clientes WHERE cpf = '$cpf'");
        $sql->execute(array());
        $cpf_existente = $sql->fetch(PDO::FETCH_ASSOC);
        return $cpf_existente;
    }

    public function updateClient(array $client)
    {
        $sql = $this->conexao->getPDO()->prepare("UPDATE clientes SET nome=?, email=?, data_nascimento=?, telefone=?, cpf=?, cep=?, rua=?, numero=?, complemento=?, bairro=?, cidade=?, estado=? WHERE id=?");
        $sql->execute(array($client['nome'], $client['email'], $client['data_nascimento'], $client['telefone'], $client['cpf'], $client['cep'], $client['rua'], $client['numero'], $client['complemento'], $client['bairro'], $client['cidade'], $client['estado'], $client['id']));
        header("location: tab-cli.php");
    }

    public function deleteClient(int $id)
    {
        $sql = $this->conexao->getPDO()->prepare("DELETE FROM clientes WHERE id=$id;");
        $sql->execute(array());
        header("location: tab-cli.php");
    }

    public function insertClient(array $client)
    {
        $sql = $this->conexao->getPDO()->prepare("INSERT INTO clientes VALUES (null,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $sql->execute(array($client['nome'], $client['email'], $client['data_nascimento'], $client['telefone'], $client['cpf'], $client['cep'], $client['rua'], $client['numero'], $client['complemento'], $client['bairro'], $client['cidade'], $client['estado'], $client['token']));
    }

    public function confirmaEmailClient(string $token)
    {
        $sql = $this->conexao->getPDO()->prepare("SELECT * FROM clientes WHERE token=\"$token\"");
        $sql->execute();
        $dados = $sql->fetch(PDO::FETCH_ASSOC);
        return $dados;
    }

    public function updateTokenClient()
    {
        $sql = $this->conexao->getPDO()->prepare("UPDATE clientes SET token=NULL");
        $sql->execute();
    }
}
