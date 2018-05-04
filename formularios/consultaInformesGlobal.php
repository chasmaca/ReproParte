<?php
$path  = "../utiles/connectDBUtiles.php";
$pathMenu = "../utiles/menu.php";
$pathinforme = "../dao/select/consultaInforme.php";
$pathPeriodo = "../dao/select/periodo.php";
$pathDepartamento = "../dao/select/departamentoAutorizador.php";
$pathCabecera = "../utiles/cabecera_formulario.php";

include_once($path);
include_once($pathinforme);
include_once($pathPeriodo);
include_once($pathDepartamento);

$resultDepartamento = cargarTodosDepartamentos();


if( isset($_POST['anioParam']) && isset($_POST['depParametro'])){
	$anio = htmlspecialchars($_POST["anioParam"]);
	$dpto = htmlspecialchars($_POST["depParametro"]);
	$recuperaInforme = recuperaInformesGlobalMes($mysqlCon,$anio,$dpto);
}else{
	$anio = 0;
	$dpto = 0;
	$recuperaInforme = null;
}

?>

<!doctype html>
<html lang=''>
<head>
	<meta charset='utf-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/estilosListados.css">
	<link rel="stylesheet" type="text/css" href="../js/filtergrid.css" media="screen" />
	<script type="text/javascript" src="../js/tablefilter.js"></script>
	<script src="../js/consultaPorFecha.js" type="text/javascript" ></script>
	
	<style>
			#cuerpo {
				position: absolute;
				left: 15%;
				top:20%;
				color: black;
				}
	</style>
	<title>Consulta Global</title>
</head>
<body>
<?php
include_once($pathCabecera);
?>
<br>
<?php 
	include_once($pathMenu);
	
?>
<div id="cuerpo">
	<form name="informe" id="informe" method="post" action="">
		<div id="filtro">
			<input type="hidden" name="depParametro" id="depParametro" value="<?php echo $dpto;?>">
			<input type="hidden" name="anioParam" id="anioParam"  value="<?php echo $anio;?>">
			
			<label for="periodo" style="color:white;"> Seleccione el A&ntilde;o:</label>
			<select name="periodo" id="periodo">
				<option value="0">Seleccione el periodo contable</option>
<?php
				if ($periodoResult != null){
					while ($fila = mysqli_fetch_assoc($periodoResult)) {
?>
						<option value='<?php echo $fila["mes_alta"] . "/" . $fila["anio_alta"]; ?>'
<?php 
						if ($fila["mes_alta"] . "/" . $fila["anio_alta"] == $anio){
?>							
							selected
<?php 
						}
?>
						><?php echo $fila["mes_alta"] . "/" . $fila["anio_alta"]; ?></option>
<?php 				
					}
					mysqli_free_result($periodoResult);
				}
?>
			</select>
			<br/> <br/>
			<label for="anioParametro" style="color:white;">Seleccione el Departamento*:</label>
			<select name="departamento" id="departamento">
			<option value="0">--Seleccione el Departamento--</option>
<?php
		
				if ($resultDepartamento != null){
					while ($fila = mysqli_fetch_assoc($resultDepartamento)) {
?>
						<option value='<?php echo $fila["DEPARTAMENTO_ID"]; ?>'
<?php 
							if ($fila["DEPARTAMENTO_ID"] == $dpto){
?>						

								selected
<?php 
							}
?>						
						><?php echo $fila["DEPARTAMENTOS_DESC"]; ?></option>
<?php 				
					}
					mysqli_free_result($departamentoResult);
				}
?>
				 </select>
				 <br><br>
				 <input type="button" name="filtrar" id="filtrar" value="Filtrar" onclick="javascript:filtrarInformeAdminGlobal();" style="float: left;"/>
				 <br><br>
				 
			</div>

		<div id="resultado">
			<table border="1" id="tablaInforme">
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
	<?php 
				if ($recuperaInforme != null){
				while ($fila = mysqli_fetch_assoc($recuperaInforme)) {
					$total = $fila['byn'] + $fila['color'] + $fila['encuadernacion'] + $fila['varios'];
	?>
				<tbody>
					<tr>
						<td id="solESB"><?php echo $fila['codigo'];?></td>
						<td id="solCEC"><?php echo $fila['CeCo'];?></td>
						<td id="solDPT"><?php echo $fila['departamentos_desc'];?></td>
						<td id="solBYN"><?php echo $fila['byn'];?></td>
						<td id="solCOL"><?php echo $fila['color'];?></td>
						<td id="solENC"><?php echo $fila['encuadernacion'];?></td>
						<td id="solVAR"><?php echo $fila['varios'];?></td>
						<td id="solTOT"><?php echo $total ?></td>
					</tr>
					
	<?php 
				}
				mysqli_free_result($recuperaInforme);
				}
	?>
					<tr>
						<td colspan="7"><div style="float:right;">Total Informe</div></td>
						<td id="table8Tot1"></td>
					</tr>
				</tbody>
			</table>
	<script type="text/javascript">
				//<![CDATA[  
				var totRowIndex = tf_Tag(tf_Id('tablaInforme'),"tr").length;  
	
				    var table7_Props =  {  
						    
				                    rows_counter: true,  
				                    col_operation: {  
				                                id: ["table8Tot1"],  
				                                col: [7],  
				                                operation: ["sum"],  
				                                write_method: ["innerHTML","setValue"],  
				                                exclude_row: [totRowIndex],  
				                                decimal_precision: [2,0]  
				                            },  
				                    rows_always_visible: [totRowIndex]  
				                };  
				var tf7 = setFilterGrid( "tablaInforme",table7_Props );  
				//*** Note ***  
				//You can also write operation results in elements outside the table.  
				//]]>  

				</script> 
		</div>
		 <br>
		<input type="button" name="excel" id="excel" title="Exportar a Excel" value="Exportar a Excel" onclick="enviarConsulta();"/>
	</form>

</div>
</body>
</html>