<?php

class Conexao{

//CONFIGURAÇÕES GERAIS
const SERVIDOR = "localhost";
const USUARIO = "root";
const SENHA = "";
const BANCO = "bdcrud";

private $pdo;

public function __construct()
{
    $this->setPDO();
}

public function getPDO()
{
    return $this->pdo;
}

public function setPDO()
{
    // $pdo = new PDO("mysql:host=$servidor;dbname=$banco",$usuario,$senha);
    $this->pdo = new PDO("mysql:host=" . self::SERVIDOR . ";dbname=" . self::BANCO, self::USUARIO, self::SENHA);
}

}


