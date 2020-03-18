<?php
class ImagemTipoAR
{
    public $conexao;
    public function __construct($l){
        $this->conexao = $l;
    }
    public function cadastrarImagemTipo($tipo)
    {
        $sql = "INSERT INTO imagem_tipo SET
        tipo='$tipo'";
//        echo $sql;
        $result = mysqli_query($this->conexao, $sql);
        $id = mysqli_insert_id();
        return $id;
    }

    public function editarImagemTipo($id, $tipo)
    {
        $sql = "UPDATE imagem_tipo SET
		tipo='$tipo'
		WHERE id = $id;
		";
        echo $sql;
        $result = mysqli_query($this->conexao, $sql);
        return $id . mysqli_error();
    }

    public function getImagemTipos()
    {
        $sql = "SELECT * FROM imagem_tipo where excluido=0";
        $result = mysqli_query($this->conexao, $sql);

        $dados['total'] = mysqli_num_rows($result);
        while ($dados2 = mysqli_fetch_assoc($result)) {
            $dados['dados'][] = $dados2;
        }
        return $dados;
    }



    public function getImagemTiposById($id)
    {
        $sql = "SELECT * FROM imagem_tipo WHERE id = $id";
        $result = mysqli_query($this->conexao, $sql);

        $dados['total'] = mysqli_num_rows($result);
        while ($dados2 = mysqli_fetch_assoc($result)) {
            $dados['dados'][] = $dados2;
        }

        return $dados;
    }



}