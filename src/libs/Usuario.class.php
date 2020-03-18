<?php

class Usuario {

    private $id;
    private $email;
    private $sobrenome;
    private $nome;
    private $senha;

    public function validaCamposCadastroContato() {
        if (empty($_POST)) {
            return false;
        }
        return true;
    }

    private function setCampos() {
            $this->id = $_POST['id'];
            $this->email = ($_POST['email']);
            $this->sobrenome = utf8_decode($_POST['sobrenome']);
            $this->nome = utf8_decode($_POST['nome']);
            $this->senha = sha1($_POST['senha']);
    }

    public function cadastrarUsuario() {
        $this->setCampos();
        $usuarioAR = new UsuarioAR();
        return $usuarioAR->cadastrarUsuario($this->nome, $this->email, $this->sobrenome, $this->senha);

    }

    public function atualizarUsuario() {
        $this->setCampos();
        $usuarioAR = new UsuarioAR();
        return $usuarioAR->editarUsuario($this->id, $this->nome, $this->email, $this->sobrenome);

    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsuarios() {
        $usuarioAR = new UsuarioAR();
        $dados = $usuarioAR->getUsuarios();
        return $dados;
    }
    /**
     * @return mixed
     */
    public function getNome() {
        return $this->nome;
    }
    public function getUsuariosTable(){
        $dados = $this->getUsuarios();
        $cont = 0;
        while($dados['total']>$cont){
            $editar = '<a href="#editarUsuario'.$dados['dados'][$cont]['id'].'" role="button" class="btn btn-primary" data-toggle="modal">Editar</a>';

            if($dados['dados'][$cont]['ativo']==1){
                $ativa = '<img src="../img/ok.png" id="img'.$dados['dados'][$cont]['id'].'">';
                $desativar = '';
                $ativar = 'hide';
            }else{
                $ativa = '<img src="../img/ok.png" id="img'.$dados['dados'][$cont]['id'].'" class="hide">';
                $ativar = '';
                $desativar = 'hide';
            }
            echo '<tr>
                <td>'.($cont+1).'</td>
                <td>'.$dados['dados'][$cont]['nome'].' '.$dados['dados'][$cont]['sobrenome'].'</td>
                <td>'.$dados['dados'][$cont]['email'].'</td>
                <td>'.$ativa.'</td>
                <td>
					<div class="'.$desativar.'" id="desativar'.$dados['dados'][$cont]['id'].'">'.$editar.' <a href="#" onclick="desativarUsuario('.$dados['dados'][$cont]['id'].');"  role="button" class="btn btn-danger" >desativar</a></div>
					<div class="'.$ativar.'" id="ativar'.$dados['dados'][$cont]['id'].'">'.$editar.' <a href="#" onclick="ativarUsuario('.$dados['dados'][$cont]['id'].');"  role="button" class="btn btn-success" >ativar</a></div>

					<div id ="carregando"'.$dados['dados'][$cont]['id'].' class="hide"><img src="../img/ajax-loader.gif" /></div></td>
            </tr>

			';
            $cont++;
        }
    }
    public function gerarModaisEditar(){
        $dados = $this->listarUsuarios();
        $cont = 0;
        while($dados['total']>$cont){
            if($dados['dados'][$cont]['destaque']){$simDestaque = 'checked';$naoDestaque = '';}else{$naoDestaque = 'checked';$simDestaque = '';}
            if($dados['dados'][$cont]['ativa']){$simAtiva = 'checked';$naoAtiva = '';}else{$naoAtiva = 'checked';$simAtiva = '';}
            echo utf8_encode('<div id="editarUsuario'.$dados['dados'][$cont]['id'].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3 id="adicionarUsuarioLabel">Editar usuario</h3>
		</div>
		<div class="modal-body">
			<form>
            	<div class="pull-left">
                    <div class="control-group">
                        <label for="titulo'.$dados['dados'][$cont]['id'].'" class="control-label">Título</label>
                        <div class="controls">
                        <input type="text" placeholder="titulo" id="titulo'.$dados['dados'][$cont]['id'].'" name="titulo'.$dados['dados'][$cont]['id'].'" required="" class="input-xlarge" value="'.utf8_decode($dados['dados'][$cont]['titulo']).'">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="descricao'.$dados['dados'][$cont]['id'].'" class="control-label">Descrição</label>
                        <div class="controls">
                        <textarea class="input-xlarge" id="descricao'.$dados['dados'][$cont]['id'].'">'.utf8_decode($dados['dados'][$cont]['descricao']).'</textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="destaque'.$dados['dados'][$cont]['id'].'" class="control-label">Destaque</label>
                        <div class="controls">
                        <input type="radio" name="destaque'.$dados['dados'][$cont]['id'].'" id="destaque'.$dados['dados'][$cont]['id'].'" value="1" '.$simDestaque.'> Sim
                        <input type="radio" name="destaque'.$dados['dados'][$cont]['id'].'" id="destaque'.$dados['dados'][$cont]['id'].'" value="0" '.$naoDestaque.'> N�o
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="ativa'.$dados['dados'][$cont]['id'].'" class="control-label">Ativa</label>
                        <div class="controls">
                        <input type="radio" name="ativa'.$dados['dados'][$cont]['id'].'" id="ativa'.$dados['dados'][$cont]['id'].'" value="1" '.$simAtiva.'> Sim
                        <input type="radio" name="ativa'.$dados['dados'][$cont]['id'].'" id="ativa'.$dados['dados'][$cont]['id'].'" value="0" '.$naoAtiva.'> N�o
                        </div>
                    </div>
                </div>
            </form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
			<button class="btn btn-primary" data-dismiss="modal" onclick="editarUsuario('.$dados['dados'][$cont]['id'].');">Editar</button>
		</div>
	</div>');
            $cont++;
        }
    }
}