<?php
$pathBBDD = "../utiles/connectDBUtiles.php";
$pathMenu = "../utiles/menuhor.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";
$pathPeriodo = "../dao/select/periodo.php";
?>

<!doctype html>
<html lang=''>
	<head>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css/estilos.css">
		<link rel="stylesheet" href="../css/styles.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="../js/blockUI.js" type="text/javascript" ></script>
		<script src="../js/enviarInformesValidador.js" type="text/javascript" ></script>
		<script type="text/javascript">
		    $(function() {
		      if ($.browser.msie && $.browser.version.substr(0,1)<7)
		      {
				$('li').has('ul').mouseover(function(){
					$(this).children('ul').show();
					}).mouseout(function(){
					$(this).children('ul').hide();
					})
		      }
		    });       
		</script>
		<title>Informes Validador</title>
	</head>
    <body>
<?php
		include_once($pathBBDD);
        include_once($pathAnalitica);
        include_once($pathCabecera);
        include_once($pathMenu);
        include_once($pathPeriodo);
?>
		<div id='cssformulario' class='cssformulario'>
        	<form id="envioInformesForm" name="envioInformesForm">
        		<h1>Envio de Informes</h1>

				<input type="button" name="envio" id="envio" value="Envio Informes"/>
				<div id="question" style="display:none; cursor: default"> 
				        <h2>Se trata de un proceso muy lento. Desea Continuar?</h2> 
				        <input type="button" id="yes" value="Yes" /> 
				        <input type="button" id="no" value="No" /> 
				</div> 
        	</form>
    	</div>
	</body>
</html>