<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$pathDB = "../utiles/connectDBUtiles.php";
$pathClase = "../dao/select/solicitudTrabajo.php";
$pathCabecera ="../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include_once($pathDB);
include_once($pathClase);

?>
<html>
	<head>
		<style>
			.error {color: #FF0000;}
		</style>
		<link rel="stylesheet" type="text/css" href="../css/estilos.css"></link>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	</head>
	<body> 
<?php
	include_once($pathAnalitica);
	include_once($pathCabecera);
?>
		<h2>Home Plantilla</h2>


		<form name="realizaTrabajoForm" method="post" action="../index.php" id="realizaTrabajoForm">
		<h2>Trabajos Pendientes</h2>
			<table style="width:95%;" id="trabajosPendientes">
				<thead>
					<tr>
						<th>Id Solicitud</th>
						<th>Departamento</th>
						<th>Nombre Solicitante</th>
						<th>Fecha de Solicitud</th>
						<th>Observaciones</th>
						<th>Operaciones</th>
					</tr>
				</thead>
				<tbody>
<?php
			$plantillaResult = recuperaPendientes();

			if ($plantillaResult != null){
				while ($fila = mysqli_fetch_assoc($plantillaResult)) {
?>
					<tr>
						<td>
						<?php echo $fila["solicitud_id"]; ?>
						</td>
						<td nowrap>
						<?php echo utf8_encode($fila["departamentos_desc"]); ?>
						</td>
						<td>
						<?php echo utf8_encode($fila["nombre_solicitante"]); ?>&nbsp;<?php echo utf8_encode($fila["apellidos_solicitante"]); ?>
						</td>
						<td nowrap>
						<?php echo $fila["fecha_alta"]; ?>
						</td>
						<td>
						<?php echo utf8_encode($fila["descripcion_solicitante"]); ?>
						</td>
						<td>
							<a href='realizarTrabajo.php?solicitudId=<?php echo $fila["solicitud_id"]; ?>' style="color:black;">Realizar Trabajo</a>
						</td>
					</tr>
<?php
				}
				mysqli_free_result($plantillaResult);
			}
?>
		</tbody>
			</table>
			
			
		<h2>Trabajos Activos</h2>
			<table style="width:95%;">
				<thead>
					<tr>
						<th>Id Solicitud</th>
						<th>Departamento</th>
						<th>Nombre Solicitante</th>
						<th>Fecha de Solicitud</th>
						<th>Observaciones</th>
						<th>Plantilla</th>
						<th>Operaciones</th>
					</tr>
				</thead>
				<tbody>
<?php
				$solicitudEnCurso = recuperaEnCursoPlantilla();
				if ($solicitudEnCurso!= null){
					while ($fila1 = mysqli_fetch_assoc($solicitudEnCurso)) {
?>
					<tr>
						<td>
						<?php echo $fila1["solicitud_id"]; ?>
						</td>
						<td>
						<?php echo utf8_encode($fila1["departamentos_desc"]); ?>
						</td>
						<td>
						<?php echo utf8_encode($fila1["nombre_solicitante"]); ?>&nbsp;<?php echo utf8_encode($fila1["apellidos_solicitante"]); ?>
						</td>
						<td nowrap>
						<?php echo $fila1["fecha_alta"]; ?>
						</td>
						<td>
						<?php echo utf8_encode($fila1["descripcion_solicitante"]); ?>
						</td>
						<td>
						<?php echo $fila1["usuario_plantilla"]; ?>
						</td>
						<td>
							<a href='realizarTrabajo.php?solicitudId=<?php echo $fila1["solicitud_id"]; ?>' style="color:black;">Realizar Trabajo</a>
						</td>
					</tr>
<?php 				
				}
				mysqli_free_result($solicitudEnCurso);
				}
?>
</tbody>
			</table>
			

			
		<h2>Trabajos Guardados</h2>
			<table  style="width:95%;">
				<thead>
					<tr>
						<th>Id Solicitud</th>
						<th>Departamento</th>
						<th>Nombre Solicitante</th>
						<th>Fecha de Solicitud</th>
						<th>Observaciones</th>
						<th>Operaciones</th>
					</tr>
				</thead>
				<tbody>
<?php
			$solicitudGuardada = recuperaGuardadas();
			if ($solicitudGuardada !=null){
				while ($fila2 = mysqli_fetch_assoc($solicitudGuardada)) {
?>
					<tr>
						<td>
						<?php echo $fila2["solicitud_id"]; ?>
						</td>
						<td>
						<?php echo utf8_encode($fila2["departamentos_desc"]); ?>
						</td>
						<td>
						<?php echo utf8_encode($fila2["nombre_solicitante"]); ?>&nbsp;<?php echo utf8_encode($fila2["apellidos_solicitante"]); ?>
						</td>
						<td nowrap>
						<?php echo $fila2["fecha_alta"]; ?>
						</td>
						<td>
						<?php echo utf8_encode($fila2["descripcion_solicitante"]); ?>
						</td>
						<td>
							<a href='realizarTrabajo.php?solicitudId=<?php echo $fila2["solicitud_id"]; ?>' style="color:black;">Realizar Trabajo</a>
						</td>
					</tr>
<?php 				
				}
				mysqli_free_result($solicitudGuardada);
			}
?>
</tbody>
			</table>
			
			<input type="submit" name="submit" value="Volver"/> 	
		</form>
	</body>
</html>