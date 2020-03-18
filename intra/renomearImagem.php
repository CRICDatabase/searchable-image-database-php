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

$id	= $_POST['id'];
$identificacao	= $_POST['identificacao'];
$lamina	= $_POST['lamina'];
$ano	= $_POST['ano'];
if($id){

    $sql = "UPDATE imagem SET identificacao = '$identificacao', lamina='$lamina',ano='$ano'  WHERE id = $id ";
	//echo $sql;
    $result = mysqli_query($conexao, $sql);
}
 

