<?php
$pathMenu = "../utiles/menuhor.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";
?>

<!doctype html>
<html lang=''>
<head>
<meta charset='utf-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/estilos.css">
<script src="../js/altaImpresora.js" type="text/javascript" ></script>
			<link rel="stylesheet" href="../css/styles.css">
			<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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

<title>Alta Impresoras</title>
</head>
<body>
<?php
	include_once($pathAnalitica);
	include_once($pathCabecera);
	include_once($pathMenu);
?>
<div id='cssformulario' class='cssformulario'>

	<form name="altaImpresoras" id="altaImpresoras" method="post" action="../dao/insert/guardarImpresora.php">
		<h2>Alta Impresora</h2>		
		<div class="inset">	
			<span>Modelo*:</span>
			<span id="errorModelo" class="error" style="visibility: hidden; color: red;">Debe Rellenar el Modelo.</span>
			<input type="text" id="modelo" name="modelo" value=""/> 
			<br/><br/>
			<span>Edificio*:</span><span id="errorEdificio" class="error" style="visibility: hidden; color: red;">Debe Rellenar el Edificio.</span>
			<input type="text" id="edificio" name="edificio" value=""/> 
			<br/><br/>
			<span>Ubicaci&oacute;n*:</span><span id="errorUbicacion" class="error" style="visibility: hidden; color: red;">Debe Rellenar la Ubicaci&oacute;n.</span>
			<input type="text" id="ubicacion" name="ubicacion" value=""/> 
			<br/><br/>
			<span>Fecha (DD/MM/YYYY)*:</span><span id="errorFecha" class="error" style="visibility: hidden; color: red;">Debe Rellenar la Fecha.</span>
			<input type="text" id="fecha" name="fecha" value=""/> 
			<br/><br/>
			<span>Nº Serie*:</span><span id="errorSerie" class="error" style="visibility: hidden; color: red;">Debe Rellenar el N&uacute;mero de Serie.</span>
			<input type="text" id="serie" name="serie" value=""/> 
			<br/><br/>
			<span>Nº M&aacute;quina*:</span><span id="errorMaquina" class="error" style="visibility: hidden; color: red;">Debe Rellenar el N&uacute;mero de M&aacute;quina.</span>
			<input type="text" id="maquina" name="maquina" value=""/> 
			<br/>
			<br/>
			<input type="button" name="guardaImpresora" id="guardaImpresora" value="Alta Impresora" onclick="javascript:enviar();"/>
		</div>
	</form>
</div>
</body>
</html>
			