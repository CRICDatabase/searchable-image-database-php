<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 9/18/15
 * Time: 10:00 AM
 */

$nivelAcesso = 200;

require_once("../conexao/config.php");
require_once('../login/restrito.php');

$id_segmento	= $_POST['id_contorno'];
if($id_segmento){


    $sql3 = "SELECT * FROM  imagem_nucleos WHERE id = $id_segmento";
    $result3 = mysqli_query($conexao,$sql3);
    while($dados3 = mysqli_fetch_assoc($result3)){
        $retorno['coordenadas_nucleo']['x'][] = $dados3['x'];
        $retorno['coordenadas_nucleo']['y'][] = $dados3['y'];
        $retorno['coordenadas_nucleo']['tipo'][] = $dados3['id_imagem_tipo'];
    }
    echo json_encode($retorno);
}