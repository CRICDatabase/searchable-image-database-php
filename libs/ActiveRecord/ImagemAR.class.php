<?php

class ImagemAR
{
    public $conexao;
    public function __construct($l){
        $this->conexao = $l;
    }
    public function cadastrarImagem($nome, $imagem_tipo)
    {
        $sql = "INSERT INTO imagem SET
        nome='$nome',
        imagem_tipo=$imagem_tipo";
//        echo $sql;
        $result = mysqli_query($this->conexao, $sql);
        $id = mysqli_insert_id();
        return $id;
    }

    public function editarImagem($id, $imagem_tipo)
    {
        $sql = "UPDATE imagem SET
		imagem_tipo=$imagem_tipo
		WHERE id = $id;
		";
        echo $sql;
        $result = mysqli_query($this->conexao, $sql);
        return $id . mysql_error();
    }

    public function getImagems($pesquisa)
    {
		if($pesquisa>0){
			$sql = "SELECT imagem.*, imagem_segmetnos.ativo,count(imagem_segmentos.id) AS total FROM imagem
			LEFT JOIN imagem_segmentos ON imagem.id = imagem_segmentos.id_imagem
         where imagem.excluido=0 AND imagem_segmentos.id_imagem_tipo LIKE '$pesquisa%' GROUP BY imagem.id";
		}else{
			$sql = "SELECT imagem.*, imagem_segmetnos.ativo, count(imagem_segmentos.id)   AS total
			FROM imagem 
			LEFT JOIN imagem_segmentos ON imagem.id = imagem_segmentos.id_imagem 
			where imagem.excluido=0 GROUP BY imagem.id ";
		}
        $result = mysqli_query($this->conexao, $sql);

        $dados['total'] = mysqli_num_rows($result);
        while ($dados2 = mysqli_fetch_assoc($result)) {
            $dados['dados'][] = $dados2;
        }
		
        return $dados;
    }

    public function getImagemsClassificacao($pesquisa)
    {
        if($pesquisa>0){
            $sql = "SELECT imagem.*, count(imagem_nucleos.id) AS total FROM imagem
            LEFT JOIN imagem_nucleos ON imagem.id = imagem_nucleos.id_imagem
         where imagem.excluido=0 AND imagem_nucleos.id_imagem_tipo LIKE '$pesquisa%' GROUP BY imagem.id";
        }else{
            $sql = "SELECT imagem.*, count(imagem_nucleos.id)   AS total
            FROM imagem 
            LEFT JOIN imagem_nucleos ON imagem.id = imagem_nucleos.id_imagem 
            where imagem.excluido=0 GROUP BY imagem.id ";
        }
        $result = mysqli_query($this->conexao, $sql);

        $dados['total'] = mysqli_num_rows($result);
        while ($dados2 = mysqli_fetch_assoc($result)) {
            $dados['dados'][] = $dados2;
        }
        
        return $dados;
    }

    public function getImagemsById($id)
    {
        $sql = "SELECT * FROM imagem WHERE id = $id";
        $result = mysqli_query($this->conexao, $sql);

        $dados['total'] = mysqli_num_rows($result);
        while ($dados2 = mysqli_fetch_assoc($result)) {
            $dados['dados'][] = $dados2;
        }

        return $dados;
    }



}