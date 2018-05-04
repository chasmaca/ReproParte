<?php
$path  = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathClase = "../dao/select/trabajoModal.php";

include_once($path);
include_once($pathClase);

?>
<html>
	<head>
		<style>
			.error {color: #FF0000;}
		</style>
		<link rel="stylesheet" type="text/css" href="http://www.elpartedigital.com/css/style.css" >
		
		<script type="text/javascript" src="../js/detalleTrabajoModal.js" ></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" ></script>
		
		<script type="text/javascript">
			function cerrarTrabajo(){
				document.getElementById('cerrar').value=1;
				document.forms[0].submit();
			}
		</script>
	</head>
	<body> 
	
<?php
	include_once($pathCabecera);
?>
		<h2>Trabajo de Varios 2</h2>
		<form name="detalleVarios2" method="post" action="">
			Seleccione el trabajo de Varios2 a Realizar:
			<select name="varios2" id="varios2" onchange="javascript:rellenaPadre(this);">
				<option value="0">Seleccione el Trabajo</option>
<?php 
				$recuperaVarios2Modal = recuperaVarios2Modal($mysqlCon);
				while ($fila5 = mysqli_fetch_assoc($recuperaVarios2Modal)) {
?>
					<option value="<?php  echo $fila5['TIPO_ID']; ?>-<?php  echo $fila5['DETALLE_ID']; ?>">
						<?php  echo $fila5['DESCRIPCION']; ?>
					</option>

<?php 
				}
				mysqli_free_result($recuperaVarios2Modal);
?>
			</select>
			
		</form>
	</body>
</html>