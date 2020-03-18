<?php
require_once("../conexao/config.php");
$autenticacao = new Autenticacao($conexao);
// Verifica se houve POST e se o usuário ou a senha é(são) vazio(s)
if (!$autenticacao->validaPreenchimentoCamposLogin()) {
	header("Location: ../index.php?loginInvalido=1"); 
}elseif($autenticacao-> validaLogin()){
	header("Location: ../intra/principal.php"); 
}else{
	header("Location: ../index.php?loginInvalido=12");
}