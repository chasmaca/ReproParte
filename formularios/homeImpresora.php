<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$pathDB = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathImpresoras = "../dao/select/impresoras.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include_once($pathDB);
include_once ($pathImpresoras);

$recuperaImpresoras = recuperaImpresoras();

?>
<html>
	<head>
		<style>
			.error {color: #FF0000;}
		</style>
		<script type="text/javascript" src="../js/impresoras.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/estilos.css"> </link>
	</head>
	<body> 
	<?php 
	include_once($pathAnalitica);
	include_once($pathCabecera);
	?>
		<form name="impresorasForm" method="post" action="../index.php" id="impresorasForm">
			<h2>Consulta de Impresoras</h2>
			<div class="inset">
			<table style="width: 95%">
				<thead>
					<tr>
						<th>Id Impresora</th>
						<th>Modelo</th>
						<th>Edificio</th>
						<th>Ubicacion</th>
						<th>Fecha</th>
						<th>Serie</th>
						<th>N&uacute;mero</th>
					</tr>
				</thead>
				<tbody>
<?php 
						if ($recuperaImpresoras!=null){
							while ($fila = mysqli_fetch_assoc($recuperaImpresoras)) {
?>
								<tr>
									<td ><?php echo $fila['IMPRESORA_ID'];?></td>
									<td ><?php echo $fila['MODELO'];?></td>
									<td ><?php echo $fila['EDIFICIO'];?></td>
									<td ><?php echo $fila['UBICACION'];?></td>
									<td ><?php echo $fila['FECHA'];?></td>
									<td ><?php echo $fila['SERIE'];?></td>
									<td ><?php echo $fila['NUMERO'];?></td>
								</tr>
<?php 
							}
							mysqli_free_result($recuperaImpresoras);
						}
?>

				</tbody>
			</table>
			<br/><br/>
			<input type="button" name="excel" id="excel" value="Generar Excel" onclick="javascript:listaExcel();"/>
			<input type="button" name="volver" id="volver" value="Volver" onclick="javascript:volverHome();"/> 
			<br/><br/>
			</div>
		</form>
	</body>
</html>