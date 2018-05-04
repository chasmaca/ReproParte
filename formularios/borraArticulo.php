<?php 
$pathDB  = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathTipo = "../dao/select/tipo.php";
$pathMenu = "../utiles/menuhor.php";
$pathDetalle = "../dao/select/detalle.php";
$pathConsulta = "cargaArticulos.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include ($pathDB);
include_once($pathTipo);
include_once($pathDetalle);
include_once($pathConsulta);

$tipoIdCombo = 0;

if( isset($_POST['tipoId']) ){
	$tipoIdCombo = $_POST["tipoId"];
}

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
		<script src="../js/modificaArticulo.js" type="text/javascript" ></script>
		<title>Borrar Articulo</title>
	</head>
	<body>
<?php
	include_once($pathAnalitica);
	include_once($pathCabecera);
	include_once($pathMenu);
?>

		<div id='cssformulario' class='cssformulario'>
		
			<form name="borraArticuloForm" id="borraArticuloForm" method="post" action="../dao/insert/borrarArticulo.php">
				<h2>Borrar Articulo</h2>
				<div class="inset">
				<label for="tipoId">Tipo</label>
				<select name="tipoId" id="tipoId" onchange="javascript:actualizaDetalleBorrar();">
					<option value="0">Seleccione el tipo</option>
<?php
					while ($fila = mysqli_fetch_assoc($tipoResult)) {
?>
						<option value='<?php echo $fila["TIPO_ID"]; ?>'
<?php 
						
							if ($fila["TIPO_ID"] == $tipoIdCombo){
?>
							selected
<?php 
							}
?>
						><?php echo $fila["TIPO_DESC"]; ?></option>
		
<?php 				
					}
					mysqli_free_result($tipoResult);
?>
		
				</select>
				<input type="hidden" name="combo" id="combo" value="<?php echo $tipoIdCombo ?>"/>
				<br/><br/>
				<?php 
				
				$recuperaDetalle = cargarDetalle($mysqlCon);
				
				if ($recuperaDetalle !=null){
				?>
					<div id="detalleM">
				<?php 
				}else{
				?>
					<div id="detalleM" style="visibility:hidden;">
				<?php 
				}
				?>
				
				<label for="detalle">Detalle</label>
				
				<select name="detalle" id="detalle"  onchange="javascript:muestraDetalle(this);">
					<option value="0">Seleccione el detalle</option>
<?php
					if ($recuperaDetalle != null){
						while ($fila2 = mysqli_fetch_assoc($recuperaDetalle)) {
?>
							<option value='<?php echo $fila2["detalleId"] . "-" . $fila2["detallePrecio"]; ?>'> <?php echo $fila2["detalleDescripcion"]; ?> </option>
<?php 				
						}
						mysqli_free_result($detallesResult);
					}
?>
				</select>
				
				</div>
				<div id="detalleCampos" style="visibility:hidden;">
					<label for="nombreDetalle">Detalle</label>
					<input type="text" name="nombreDetalle" id="nombreDetalle" value=""/>
					<br>
					<label for="precioDetalle">Detalle</label>
					<input type="text" name="precioDetalle" id="precioDetalle"/>
					
				</div>
				
				<div id="submitM" style="visibility:hidden;">
					<input type="submit" name="borraArticuloSubmit" id="borraArticuloSubmit" value="Borrar Articulo">
				</div>
				</div>
				</div>
				
			</form>

		</div>
	</body>
</html>