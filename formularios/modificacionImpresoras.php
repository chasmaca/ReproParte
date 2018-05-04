<?php
$path  = "../utiles/connectDBUtiles.php";
$pathMenu = "../utiles/menuhor.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathImpresoras = "../dao/select/impresoras.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include($path);
include_once ($pathImpresoras);

date_default_timezone_set("Europe/Madrid");

$recuperaImpresoras = recuperaImpresoras();

if( isset($_POST['imprParam'])){

	$id = htmlspecialchars($_POST["imprParam"]);
	$cadenaValor = recuperaImpresorasPorId($id);
	$modelo = $cadenaValor[1];
	$edificio = $cadenaValor[2];
	$ubicacion = $cadenaValor[3];
	$fechaOriginal = $cadenaValor[4];

	$fecha = date("d/m/Y", strtotime($fechaOriginal));
	
	
	$serie = $cadenaValor[5];
	$maquina = $cadenaValor[6];

}else{
	
	$id="0";
	$modelo = "";
	$edificio = "";
	$ubicacion = "";
	$fecha = "";
	$serie = "";
	$maquina = "";
	
}



?>

<!doctype html>
<html lang=''>
	<head>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css/estilos.css">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
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
		
		<title>Modificar Impresoras</title>
	</head>
	<body>
<?php
		include_once($pathAnalitica);
		include_once($pathCabecera);
		include_once($pathMenu);
?>
		<div id='cssformulario' class='cssformulario'>
			<form name="modificacionImpresoras" id="modificacionImpresoras" method="post" action="">
				<h2>Modificar Impresoras</h2>
				<div class="inset">	
				<input type="hidden" name="imprParam" id="imprParam" value="<?php echo $id; ?>">
				<input type="hidden" name="depParametro" id="depParametro" value="<?php echo $id;?>">
				
					Seleccione la impresora a modificar:
					<select name="impresora" id="impresora" onchange="javascript:actualizaCamposModi(this);">
						<option value="0">Seleccione la Impresora</option>
<?php 
						if ($recuperaImpresoras != null){
							while ($fila = mysqli_fetch_assoc($recuperaImpresoras)) {
?>
								<option value='<?php echo $fila["IMPRESORA_ID"]; ?>'><?php echo $fila["UBICACION"]; ?></option>
<?php 
							}
							mysqli_free_result($recuperaImpresoras);
						}
?>
					</select>
					
					<br/><br/>
					<span>Modelo*:</span>
					<span id="errorModelo" class="error" style="visibility: hidden; color: red;">Debe Rellenar el Modelo.</span>
					<input type="text" id="modelo" name="modelo" value="<?php echo $modelo; ?>"/> 
					<br/><br/>
					<span>Edificio*:</span><span id="errorEdificio" class="error" style="visibility: hidden; color: red;">Debe Rellenar el Edificio.</span>
					<input type="text" id="edificio" name="edificio" value="<?php echo $edificio; ?>"/> 
					<br/><br/>
					<span>Ubicaci&oacute;n*:</span><span id="errorUbicacion" class="error" style="visibility: hidden; color: red;">Debe Rellenar la Ubicaci&oacute;n.</span>
					<input type="text" id="ubicacion" name="ubicacion" value="<?php echo $ubicacion; ?>"/> 
					<br/><br/>
					<span>Fecha (DD/MM/YYYY)*:</span><span id="errorFecha" class="error" style="visibility: hidden; color: red;">Debe Rellenar la Fecha.</span>
					<input type="text" id="fecha" name="fecha" value="<?php echo $fecha; ?>"/> 
					<br/><br/>
					<span>Nº Serie*:</span><span id="errorSerie" class="error" style="visibility: hidden; color: red;">Debe Rellenar el N&uacute;mero de Serie.</span>
					<input type="text" id="serie" name="serie" value="<?php echo $serie; ?>"/> 
					<br/><br/>
					<span>Nº M&aacute;quina*:</span><span id="errorMaquina" class="error" style="visibility: hidden; color: red;">Debe Rellenar el N&uacute;mero de M&aacute;quina.</span>
					<input type="text" id="maquina" name="maquina" value="<?php echo $maquina; ?>"/> 
					<br/>
					<br/>
					<input type="hidden" id="idImpresora" name="idImpresora" value=""/>
					
					<input type="button" name="modificaImp" id="modificaImp" value="Modificar Impresora" onclick="javascript:validaFormulario();"/>
				</div>
			</form>
		</div>
	</body>
</html>