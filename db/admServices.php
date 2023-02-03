<?php

class AdmServices
{
    private $conexao;

    public function __construct($conexao)
    {   
        $this->conexao = $conexao;        
    }
    

    public function selectAllAdms()
    {
        $sql = $this->conexao->getPDO()->prepare("SELECT id,nome,email,ativo FROM adms");
        $sql->execute();
        $dados = $sql->fetchAll();
        return $dados;
    }

    public function carregaAdministrador(string $id) {
        
        $sql = $this->conexao->getPDO()->prepare("SELECT * FROM adms WHERE id = '$id' LIMIT 1");
        $sql->execute(array());
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
        return $usuario;
    }

    public function selectAdmLogin(string $email)
    {
        $this->conexao = new Conexao();
        $sql = $this->conexao->getPDO()->prepare("SELECT * FROM adms WHERE email = '$email' LIMIT 1");
        $sql->execute();
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
        return $usuario;
    }

    public function updateAdm(array $adm)
    {
        $this->conexao = new Conexao();
        $sql = $this->conexao->getPDO()->prepare("UPDATE adms SET nome=?, ativo=? WHERE id=?");
        $sql->execute(array($adm['nome'], $adm['ativo'], $adm['id']));
        header("location: tab-adm.php");
    }

    public function updateNewPassAdm(array $adm)
    {
        $adm['nova_senha'] = password_hash($adm['nova_senha'], PASSWORD_DEFAULT);
        $adm['ativo'] = isset($adm['ativo']) ? 1 : 0;          
        $this->conexao = new Conexao();        
        $sql = $this->conexao->getPDO()->prepare("UPDATE adms SET nome=?, ativo=?, senha=? WHERE id=?");
        $sql->execute(array($adm['nome'], $adm['ativo'], $adm['nova_senha'], $adm['id']));
        header("location: tab-adm.php");
    }

    public function selectEmailsAtivosAdm()
    {
        $this->conexao = new Conexao();
        $sql = $this->conexao->getPDO()->prepare("SELECT email FROM adms where ativo=1");
        $sql->execute();
        $dadosemail = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $dadosemail;
    }

    public function selectNumeroEmailsAtivos()
    {
        $this->conexao = new Conexao();
        $sql = $this->conexao->getPDO()->prepare("SELECT COUNT(email) as total FROM adms where ativo=1");
        $sql->execute();
        $numEmails = $sql->fetch(PDO::FETCH_ASSOC);
        return $numEmails;
    }

    public function insertAdm(array $adm)
    {
        $adm['senha'] = password_hash($adm['senha'], PASSWORD_DEFAULT);
        $adm['ativo'] = isset($adm['ativo']) ? 1 : 0;         
        $this->conexao = new Conexao();
        $sql = $this->conexao->getPDO()->prepare("INSERT INTO adms VALUES (null,?,?,?,?)");
        $sql->execute(array($adm['nome'], $adm['email'], $adm['senha'], $adm['ativo']));
        header("location: tab-adm.php");
    }

    public function contaQuantosAdmsAtivosExistem()
    {
        $this->conexao = new Conexao();
        $sql = $this->conexao->getPDO()->prepare("SELECT COUNT(ativo) as total FROM adms WHERE ativo='1'");
        $sql->execute();
        $ativos = $sql->fetch(PDO::FETCH_ASSOC);
        return $ativos;
    }

    public function apagaQualquerAdm(int $id)
    {
        $this->conexao = new Conexao();
        $sql = $this->conexao->getPDO()->prepare("DELETE FROM adms WHERE id=" . $id . ";");
        $sql->execute();
        header("location: tab-adm.php");
    }

    public function apagaSoAdmNaoAtivo(int $id)
    {
        $this->conexao = new Conexao();
        $sql = $this->conexao->getPDO()->prepare("DELETE FROM adms WHERE id=" . $id . " && ativo='0';");
        $sql->execute(array());
        header("location: tab-adm.php");
    }
}
