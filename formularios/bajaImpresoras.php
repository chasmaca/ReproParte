<?php
$path  = "../utiles/connectDBUtiles.php";
$pathMenu = "../utiles/menuhor.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathImpresoras = "../dao/select/impresoras.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include($path);
include_once ($pathImpresoras);

$recuperaImpresoras = recuperaImpresoras();

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

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<title>Borrar Usuario</title>
</head>
<body>
<?php
	include_once($pathAnalitica);
	include_once($pathCabecera);
	include_once($pathMenu);
?>
		<div id='cssformulario' class='cssformulario'>
			<form name="bajaImpresoras" id="bajaImpresoras" method="post" action="../dao/insert/borrarImpresora.php">
				<h2>Borrar Impresora</h2>	
				<div class="inset">
					Seleccione la Impresora:
					<select name="impresora" id="impresora">
						<option value="0">Seleccione la impresora</option>
<?php 
						if ($recuperaImpresoras != null){
							while ($fila = mysqli_fetch_assoc($recuperaImpresoras)) {
?>
								<option value='<?php echo $fila["IMPRESORA_ID"]; ?>'><?php echo $fila["UBICACION"]; ?></option>
<?php 
							}
							mysqli_free_result($departamentoResult);
						}
?>
					</select>
					<br><br>
					<input type="submit" name="borraImpreSubmit" id="borraImpreSubmit" value="Borrar Impresora"/>
				</div>
			</form>
		</div>
	</body>
</html>