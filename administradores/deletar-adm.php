<?php
require_once('../db/admServices.php');
require_once('../db/conexao.php');
require_once('../protect-adm-cli.php');

//Não pode deletar adm ativo caso só exista 1 adm ativo

$pdo = new Conexao();
$admServices = new AdmServices($pdo);

$ativos = $admServices->contaQuantosAdmsAtivosExistem();

if ($ativos['total'] > 1) {
    $admServices->apagaQualquerAdm($_GET['id']);
} else {
    $admServices->apagaSoAdmNaoAtivo($_GET['id']);
}
?>
