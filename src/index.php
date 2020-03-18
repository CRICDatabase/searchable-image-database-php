<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>CRIC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Paulo Calaes">

    <!-- Le styles -->
    <link href="includes/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Dosis&subset=latin,latin-ext);
      body {
        padding-top: 90px;
        padding-bottom: 40px;
      }
      body{
        font-family: "Dosis", 'Helvetica Neue', sans-serif;
      }
      footer{
        background-color: #2f9fae;
        width: 100%;
        align-content:center;
        text-align: center;
        padding: 15px;
      }
    </style>
    <link href="includes/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="includes/bootstrap/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="includes/bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="includes/bootstrap/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="includes/bootstrap/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="includes/bootstrap/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="includes/bootstrap/ico/favicon.png">
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
          <a class="brand" href="#"><img src="img/logo.png" style="height:100px;"></a>
<form action="login/validacao.php" method="post" class="navbar-form pull-right" style="margin-top:20px;">
      
            <input type="text" id="usuario" name="usuario" placeholder="Email">
        
            <input type="password" id="senha" name="senha" placeholder="Senha">
        
            <button type="submit" class="btn">Entrar</button>

            <?php phpinfo(); ?>
        
  </form>
        </div>
      </div>
      
    </div>
    <div class="container">
	<?php 
	if(isset($_GET['pagina'])){
		switch ($_GET['pagina']){
			case 'sobre': include('portal/sobre.php');
						break;	
			default: include('portal/inicio.php');
					break;
		}
	}else{
		include('portal/inicio.php');
	}
	?>
    
    </div>
    
<footer>
  <div>
    <img class="img-responsive" src="img/logo_branco_rodape.png" >
  </div>
</footer>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="includes/jquery/jquery.js"></script>
    <script src="includes/bootstrap/js/bootstrap-transition.js"></script>
    <script src="includes/bootstrap/js/bootstrap-alert.js"></script>
    <script src="includes/bootstrap/js/bootstrap-modal.js"></script>
    <script src="includes/bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="includes/bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="includes/bootstrap/js/bootstrap-tab.js"></script>
    <script src="includes/bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="includes/bootstrap/js/bootstrap-popover.js"></script>
    <script src="includes/bootstrap/js/bootstrap-button.js"></script>
    <script src="includes/bootstrap/js/bootstrap-collapse.js"></script>
    <script src="includes/bootstrap/js/bootstrap-carousel.js"></script>
    <script src="includes/bootstrap/js/bootstrap-typeahead.js"></script>

  </body>
</html>
