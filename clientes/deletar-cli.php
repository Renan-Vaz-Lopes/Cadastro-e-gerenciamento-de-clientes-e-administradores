<?php
require_once('../db/clientServices.php');
require_once('../db/conexao.php');
require_once('../protect-adm-cli.php');

$pdo = new Conexao();
$clientServices = new ClientServices($pdo);

$clientServices->deleteClient($_GET['id']);

?>