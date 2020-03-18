<?php
require_once("../conexao/config.php");
$autenticacao = new Autenticacao($conexao);

// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

$autenticacao->acessoRestrito($nivelAcesso);