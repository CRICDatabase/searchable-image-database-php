<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 9/18/15
 * Time: 10:00 AM
 */

$nivelAcesso = 100;

require_once("../conexao/config.php");
require_once('../login/restrito.php');

$id	= $_GET['id'];
if($id){

    $sql = "UPDATE imagem SET excluido = 1 WHERE id = $id ";
	//echo $sql;
    $result = mysqli_query($conexao,$sql);
}
$redirect = "http://triviasistemas.com.br/Mestrado/intra/principal.php?pagina=listarImagens";
 
 #abaixo, chamamos a função header() com o atributo location: apontando para a variavel $redirect, que por 
 #sua vez aponta para o endereço de onde ocorrerá o redirecionamento
 header("location:$redirect");
