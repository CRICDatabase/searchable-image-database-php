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

$id_usuario = 9;
if($id_usuario){

    $sql = "SELECT id FROM  imagem_segmentos WHERE id_usuario = $id_usuario";
    $result = mysqli_query($conexao,$sql);
    while($dados = mysql_fetch_assoc($result)){
        $id = $dados['id'];

        $sql2 = "DELETE FROM  coordenadas_segmento WHERE id_segmento = $id";
        $result2 = mysqli_query($conexao,$sql2);

        $sql3 = "DELETE FROM  coordenadas_nucleo WHERE id_segmento = $id";
        $result3 = mysqli_query($conexao,$sql3);

    }
    $sql4 = "DELETE FROM  imagem_segmentos WHERE id_usuario = $id_usuario";
    $result4 = mysqli_query($conexao,$sql4);
}