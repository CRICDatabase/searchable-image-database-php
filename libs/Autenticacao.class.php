<?php 
class Autenticacao{
	public $conexao;

	public function __construct($l){
		$this->conexao = $l;
	}
	public function validaPreenchimentoCamposLogin(){
		if (!empty($_POST) AND (empty($_POST['usuario']) OR empty($_POST['senha']))) {
			return false;
		}
		return true;
	}
	
	private function inicializaSesssao($idUsuario,$nomeUsuario,$nivelUsuario){
		if (!isset($_SESSION)) session_start();
			
		$_SESSION['UsuarioID'] = $idUsuario;
		$_SESSION['UsuarioNome'] = $nomeUsuario;
		$_SESSION['UsuarioNivel'] = $nivelUsuario;
	}
	
	public function validaLogin(){
		
		$usuario = addslashes($_POST['usuario']);
		$senha = addslashes($_POST['senha']);
		if($usuario=="guest" && $senha == "guest"){
			$this->inicializaSesssao(1000, "Guest", 99);
			return true;
		}else{
		
		
			$sql = "SELECT `id`, `nome`, `nivel` FROM `usuarios` WHERE (`email` = '". $usuario ."') AND (`senha` = '". sha1($senha) ."') AND (`ativo` = 1) LIMIT 1";
			$query = mysqli_query($this->conexao, $sql);
			if (mysqli_num_rows($query) != 1) {
				return false;
			} else {
				$resultado = mysqli_fetch_assoc($query);
				$this->inicializaSesssao($resultado['id'], utf8_encode($resultado['nome']), $resultado['nivel']);
				return true;
			}	
		}
	}
	
	public function acessoRestrito($nivel_necessario){
		if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] > $nivel_necessario)) {
			
			//echo 'UsuarioID: '.$_SESSION['UsuarioID'].'<br>';
			//echo 'UsuarioNivel: '.$_SESSION['UsuarioNivel'].'<br>';
			//echo 'nivel_necessario: '.$nivel_necessario.'<br>';
			//echo 'sessao expirada<br>';
			// Destrói a sessão por segurança
			session_destroy();
			// Redireciona o visitante de volta pro login
			header("Location: http:///triviasistemas.com.br/Mestrado/index.php?sessaoExpirada=1"); exit;
		}
	}
	
}