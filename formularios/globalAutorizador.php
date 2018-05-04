<?php

session_start();

$path  = "../utiles/connectDBUtiles.php";
$pathinforme = "../dao/select/consultaInforme.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathDepartamento = "../dao/select/departamentoAutorizador.php";
$pathPeriodo = "../dao/select/periodo.php";

include_once($path);
include_once($pathinforme);
include_once($pathDepartamento);
include_once($pathPeriodo);

$resultDepartamento = cargarDptoSession($usuario);

if( isset($_POST['anioParam']) && isset($_POST['depParametro'])){
	$anio = htmlspecialchars($_POST["anioParam"]);
	$dpto = htmlspecialchars($_POST["depParametro"]);
	//$resultValida = recuperaDetalleMesValidador($mysqlCon,$usuario,$anio,$dpto);
	$resultValida = recuperaGlobalMesValidador($usuario,$anio,$dpto);
	
}else{
	$anio = 0;
	$dpto = 0;
	$resultValida = null;
}

?>
<!doctype html>
<html lang=''>
<head>
	<meta charset='utf-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/estilos.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="../js/consultaPorFecha.js" type="text/javascript" ></script>
	<script type="text/javascript" src="../js/homeValidador.js"></script>
	
	<style>
			#cuerpo {
				position: absolute;
				left:240px;
				top:50px;
				color: #FF0000;
				}
	</style>
	<title>Consulta Global Validadores</title>
</head>

	<body> 
<?php 
		include_once($pathCabecera);
?>
		<form name="globalAutorizadorForm" method="post" action="" id="globalAutorizadorForm">
			<h2>Informe Global del Autorizador</h2>
			<div class="inset">
				
				<input type="hidden" name="depParametro" id="depParametro" value="<?php echo $dpto;?>">
				<input type="hidden" name="anioParam" id="anioParam"  value="<?php echo $anio;?>">
				<br/><br/>
				<label for="email">Seleccione el Periodo*:</label>
				<select name="periodo" id="periodo">
<?php
				if ($periodoResult != null){
					while ($fila = mysqli_fetch_assoc($periodoResult)) {
?>
						<option value='<?php echo $fila["mes_alta"] . "/" . $fila["anio_alta"]; ?>'><?php echo $fila["mes_alta"] . "/" . $fila["anio_alta"]; ?></option>
<?php 
					}
					mysqli_free_result($periodoResult);
				}
?>
				</select>
				<br/> <br/>
				<label for="email">Seleccione el Departamento*:</label>
				<select name="departamento" id="departamento">
<?php
		
				if ($resultDepartamento != null){
					while ($fila = mysqli_fetch_assoc($resultDepartamento)) {
?>
						<option value='<?php echo $fila["DEPARTAMENTO_ID"]; ?>'><?php echo $fila["DEPARTAMENTOS_DESC"]; ?></option>
<?php 				
					}
					mysqli_free_result($departamentoResult);
				}
?>
				 </select>
				 <br><br>
				 <input type="button" name="filtrar" id="filtrar" value="Filtrar" onclick="javascript:filtrarInformeGlobal();" style="float: left;"/>
				 <br><br>
				 
				<div id="resultado">
				<table style="width:95%;">
					<thead>
						<tr>
							<th>ESB</th>
							<th>CODIGO</th>
							<th>DEPARTAMENTO</th>
							<th>BLANCO Y NEGRO</th>
							<th>COLOR</th>
							<th>ENCUADERNACIONES</th>
							<th>VARIOS</th>
							<th>TOTAL</th>
						</tr>
					</thead>
					<tbody>
<?php 
					if ($resultValida!= null){
						$totalFinal = 0;
						while ($fila = mysqli_fetch_assoc($resultValida)) {
							$total = $fila['byn'] + $fila['color'] + $fila['encuadernacion'] + $fila['varios'];
							$totalFinal = $totalFinal + $total; 
?>
							<tr>
								<td><?php echo $fila["esb"];?> </td>
								<td><?php echo $fila["codigo"];?> </td>
								<td><?php echo $fila["departamento"];?> </td>
								<td><?php echo $fila["byn"];?> </td>
								<td><?php echo $fila["color"];?> </td>
								<td><?php echo $fila["encuadernacion"];?> </td>
								<td><?php echo $fila["varios"];?> </td>
								<td><?php echo $total; ?> </td>
							</tr>
<?php 
						}
						mysqli_free_result($resultValida);
?>
						<tr>
							<td colspan="7" style="text-align:right;"><b>Total:</b></td>
							<td><?php echo $totalFinal; ?> </td>
						</tr>
<?php 

					}
?>					
					</tbody>
				</table>
			</div>
			<input type="button" name="volver" id="volver" value="Volver Atras" onClick="javascript:volverAtras();"/>
			<input type="button" name="excel" id="excel" value="Generar Excel" onClick="javascript:mostramosExcelGlobal();"/>
			</div>
		</form>
	</body>
</html>