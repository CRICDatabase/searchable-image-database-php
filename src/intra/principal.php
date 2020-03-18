<?php 
$nivelAcesso = 200;



require_once("../conexao/config.php");
require_once('../login/restrito.php');

if($_SESSION['UsuarioNome']=='Guest'){
	$guest = 1;
}else{
	$guest = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>CRIC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../includes/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../includes/trent/Treant.css" rel="stylesheet">
    <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Dosis&subset=latin,latin-ext);
      body {
        padding-top: 90px;
        padding-bottom: 40px;
        font-family: "Dosis", 'Helvetica Neue', sans-serif;
      }
      footer{
        background-color: #2f9fae;
        width: 100%;
        align-content:center;
        text-align: center;
        padding: 15px;
      }
      h2{
        color: #2f9fae;
      }
    </style>
    <link href="../includes/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    
    
    <link href="../css/estilo.css" rel="stylesheet">
    <link href="../includes/bootstrap/css/bootstrap-wysihtml5.css" rel="stylesheet">
    <link href="../includes/bootstrap/css/font-awesome.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="includes/bootstrap/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../includes/bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../includes/bootstrap/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../includes/bootstrap/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../includes/bootstrap/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../includes/bootstrap/ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="principal.php"><img src="../img/cric.png" style="height:75px;"></a>
          <div class="nav-collapse collapse">
          	<p class="navbar-text pull-right">
              Welcome <?php echo $_SESSION['UsuarioNome']; ?> - <a href="../login/logout.php">Logout</a>
            </p>
            <ul class="nav">
                  <li class="<?php if(!isset($_GET['pagina'])){echo 'active';}?>"><a href="principal.php">Home</a></li>

					<?php if(!$guest){ ?>
<!--                  <li class="dropdown">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuários <b class="caret"></b></a>-->
<!--                    <ul class="dropdown-menu">-->
<!--                      <li><a href="principal.php?pagina=listarUsuarios">Listar</a></li>-->
<!--                      <li><a href="principal.php?pagina=cadastrarUsuario">Cadastrar</a></li>-->
<!--                    </ul>-->
<!--                  </li>-->
				  <?php } ?>
                <li class="<?php if($_GET['pagina']=='about'){echo 'active';}?>">
                    <a  href="principal.php?pagina=about" >About</a>
                </li>
                <li >
                    <a href="principal.php?pagina=listarImagens" >Segmentation Database</a>
                </li>
                <li >
                    <a href="principal.php?pagina=listarImagensClassificacao" >Classification Database</a>
                </li>
				<?php if(!$guest){ ?>
                <li >
                    <a href="principal.php?pagina=exportar" >Download </a>

                </li>
				<?php } ?>
				        <li >
                    <a href="tipos.pdf" target="_blank" >Segments Labels </a>
                </li>
                <li >
                    <a href="tipos.pdf" target="_blank" >Publications </a>
                </li>
                <li >
                    <a href="tipos.pdf" target="_blank" >Contact </a>
                </li>
            </ul>
             
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
     <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../includes/jquery/jquery.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-transition.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-alert.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-modal.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-tab.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-popover.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-button.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-collapse.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-carousel.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-typeahead.js"></script>
    <script src="../includes/bootstrap/js/bootstrap-inputmask.min.js"></script>
    <script src="../includes/bootstrap/js/wysihtml5.js"></script>
	<script src="../includes/bootstrap/js/bootstrap-wysihtml5.js"></script>
    <script src="../includes/jquery/hotkeys.js"></script>
    <script src="../includes/trent/vendor/raphael.js"></script>
    <script src="../includes/trent/Treant.js"></script>
    <div class="container">
	<?php 
	if(isset($_GET['pagina'])){
	switch ($_GET['pagina']){
		case 'cadastrarUsuario': include('../intra/cadastrar_usuario.php');
					break;	
		case 'listarUsuarios': include('../intra/listar_usuarios.php');
					break;	
		case 'listarImagens': include('../intra/listar_imagens.php');
					break;	
    case 'listarImagensClassificacao': include('../intra/listar_imagens_classificacao.php');
          break;  
		case 'voiImagem': include('../intra/voi_imagem.php');
					break;
    case 'nucleosImagem': include('../intra/nucleos_imagem.php');
          break;	
		case 'exportar': include('../intra/exportar.php');
					break;
    case 'about': include('../intra/about.php');
          break;
        case 'excluirDadosUsuario': include('../intra/excluiDadosUsuario.php');
            break;
		default: include('../intra/inicio.php');
				break;
	}
	}else{
		include('../intra/inicio.php');
	}
	?>
    <div id="editor"></div>

    </div>
    
<footer>
  <div>
    <img class="img-responsive" src="../img/logo_branco_rodape.png" >
  </div>
</footer>
   
    
  </body>
</html>
