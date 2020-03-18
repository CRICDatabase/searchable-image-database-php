<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 9/18/15
 * Time: 8:58 AM
 */
$nivelAcesso = 100;
ini_set('post_max_size','500M');
ini_set('max_input_vars','250000');
require_once("../conexao/config.php");
require_once('../login/restrito.php');
//print_r($_POST);
$id_imagem	= $_POST['id_imagem'];
$id_imagem_tipo	= $_POST['id_imagem_tipo'];
$tipo = $_POST['tipo'];
$coordenadasX =explode(',',$_POST['coordenadasX']) ;
$coordenadasY = explode(',',$_POST['coordenadasY']);

//print_r($coordenadasX);

//echo 'X:'.sizeof($coordenadasX);
//echo 'Y:'.sizeof($coordenadasY);

$id_usuario = $_SESSION['UsuarioID'];

if($tipo==1){

    $sql = "INSERT INTO  imagem_segmentos SET
        id_imagem = $id_imagem,
        id_imagem_tipo = $id_imagem_tipo,
        id_usuario = $id_usuario
    ";
    mysqli_query($conexao, $sql);
    $id_contorno = mysql_insert_id();
	mysqli_query($conexao, "SET AUTOCOMMIT = 0");
    mysqli_query($conexao, "START TRANSACTION");
    for($i=0;$i<sizeof($coordenadasX);$i++){
        $x = $coordenadasX[$i];
        $y = $coordenadasY[$i];
        $sql = "INSERT INTO  coordenadas_segmento SET
        id_segmento = $id_contorno,
        x = $x,
        y = $y
    ";
        //echo $sql;
        mysqli_query($conexao, $sql);
    }
	mysqli_query($conexao, "COMMIT");
    mysqli_query($conexao, "SET AUTOCOMMIT = 1");
    echo $id_contorno;
}else{
    $id_contorno = $_POST['id_segmento'];
	mysqli_query($conexao, "SET AUTOCOMMIT = 0");
    mysqli_query($conexao, "START TRANSACTION");
    for($i=0;$i<sizeof($coordenadasX);$i++){
        $x = $coordenadasX[$i];
        $y = $coordenadasY[$i];
        $sql = "INSERT INTO  coordenadas_nucleo SET
        id_segmento = $id_contorno,
        x = $x,
        y = $y
    ";
        mysqli_query($conexao, $sql);
    }
	mysqli_query($conexao, "COMMIT");
    mysqli_query($conexao, "SET AUTOCOMMIT = 1");
}