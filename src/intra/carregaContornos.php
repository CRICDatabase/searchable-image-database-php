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

$id_imagem	= $_POST['id_imagem'];
$id_usuario = $_POST['usuario'];
if($id_usuario){

$sql = "SELECT * FROM  imagem_segmentos WHERE id_imagem = $id_imagem AND id_usuario = $id_usuario AND excluido =0";
$result = mysqli_query($conexao,$sql);
$cont = 0;
while($dados = mysqli_fetch_assoc($result)){
    $id = $dados['id'];
    $retorno[$cont]['id'] = $cont;
    $retorno[$cont]['id_contorno'] = $dados['id'];
    $retorno[$cont]['id_imagem_tipo'] = $dados['id_imagem_tipo'];
    $sql2 = "SELECT * FROM  coordenadas_segmento WHERE id_segmento = $id";
    $result2 = mysqli_query($conexao,$sql2);
    while($dados2 = mysqli_fetch_assoc($result2)){
        $retorno[$cont]['coordenadas_segmento']['x'][] = $dados2['x'];
        $retorno[$cont]['coordenadas_segmento']['y'][] = $dados2['y'];
    }
    $sql3 = "SELECT * FROM  coordenadas_nucleo WHERE id_segmento = $id";
    $result3 = mysqli_query($conexao,$sql3);
    while($dados3 = mysqli_fetch_assoc($result3)){
        $retorno[$cont]['coordenadas_nucleo']['x'][] = $dados3['x'];
        $retorno[$cont]['coordenadas_nucleo']['y'][] = $dados3['y'];
    }
    $cont++;
}
echo json_encode($retorno);
}