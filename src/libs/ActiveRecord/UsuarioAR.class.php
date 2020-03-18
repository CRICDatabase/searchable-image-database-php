<?php

class UsuarioAR
{
    public function cadastrarUsuario($nome, $email, $sobrenome, $senha)
    {
        $sql = "INSERT INTO usuarios SET
        nome='$nome',
        sobrenome='$sobrenome',
		email='$email',
		senha='$senha'
		";
//        echo $sql;
        $result = mysqli_query($conexao,$sql);
        $id = mysqli_insert_id();
        return $id;
    }

    public function editarUsuario($id, $nome, $email, $sobrenome)
    {
        $sql = "UPDATE usuarios SET
		nome='$nome',
		email='$email',
		sobrenome='$sobrenome'
		WHERE id = $id;
		";
        echo $sql;
        $result = mysqli_query($conexao,$sql);
        return $id . mysqli_error();
    }

    public function getUsuarios()
    {
        $sql = "SELECT * FROM usuarios";
        $result = mysqli_query($conexao,$sql);

        $dados['total'] = mysqli_num_rows($result);
        while ($dados2 = mysqli_fetch_assoc($result)) {
            $dados['dados'][] = $dados2;
        }
        return $dados;
    }

    public function getUsuariosById($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $result = mysqli_query($conexao,$sql);

        $dados['total'] = mysqli_num_rows($result);
        while ($dados2 = mysqli_fetch_assoc($result)) {
            $dados['dados'][] = $dados2;
        }

        return $dados;
    }



}