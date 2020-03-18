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
$tipo = $_POST['tipo'];
$coordenadasX = $_POST['coordenadasX'];
$coordenadasY = $_POST['coordenadasY'];

//print_r($coordenadasX);

//echo 'X:'.sizeof($coordenadasX);
//echo 'Y:'.sizeof($coordenadasY);

$id_usuario = $_SESSION['UsuarioID'];

$sql = "INSERT INTO  imagem_nucleos SET
        id_imagem = $id_imagem,
        id_imagem_tipo = $tipo,
        x = $coordenadasX,
        y = $coordenadasY,
        id_usuario = $id_usuario
    ";
    mysqli_query($conexao,$sql);
echo mysqli_insert_id();