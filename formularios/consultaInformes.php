<?php
$path  = "../utiles/connectDBUtiles.php";
$pathMenu = "../utiles/menuhor.php";
$pathinforme = "../dao/select/consultaInforme.php";
$pathExcel = "generaExcel.php";
$pathPeriodo = "../dao/select/periodo.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathDepartamento = "../dao/select/departamentoAutorizador.php";
$pathAnalitica = "../utiles/analyticstracking.php";
$pathSubdepartamento = "../dao/select/subdepartamento.php";

include_once($path);
include_once($pathinforme);
include_once($pathPeriodo);
include_once($pathDepartamento);
include_once($pathSubdepartamento);

$resultDepartamento = cargarTodosDepartamentos();

$recuperaInforme = null;


$anio = 0;
$dpto = 0;
$subdpto = 0;
$tipoInforme = 0;
$resultValida = null;
$periodoCombo = "";
$departamentoCombo = "";
$recuperaInformeArray = array();
$recuperaInforme = "";

if( isset($_POST['anioParam']) && isset($_POST['depParametro']) && isset($_POST['informeParam']) && isset($_POST['subdptoParametro']) ){
	$anio = htmlspecialchars($_POST["anioParam"]);
	$dpto = htmlspecialchars($_POST["depParametro"]);
	$tipoInforme = htmlspecialchars($_POST["informeParam"]);
	$subdpto = htmlspecialchars($_POST["subdepartamento"]);
	
	
	if ($tipoInforme == 'global')
		$recuperaInformeArray = recuperaInformesGlobalMesAdminListado($mysqlCon,$anio,$dpto, $subdpto);
	
	if ($tipoInforme == 'detalle')
		$recuperaInforme = recuperaInformesMesAdminConsulta($mysqlCon,$anio,$dpto, $subdpto);
	
}else{
	$anio = 0;
	$dpto = 0;
	$subdpto = 0;
	$tipoInforme = "";
	$recuperaInforme = null;
}

if( isset($_POST['periodo']) ){
    $periodoCombo = $_POST["periodo"];
}

if( isset($_POST['departamento']) ){
    $departamentoCombo = $_POST["departamento"];
    if ($departamentoCombo != 0){
        $subdepartamentoList = recuperaSubXDpto($departamentoCombo);
    }
}

if (!empty($_POST["subdepartamento"])){
    $idSub = htmlspecialchars($_POST["subdepartamento"]);
}else{
    $idSub = "";
}

?>

<!doctype html>
	<html lang=''>
		<head>
			<meta charset='utf-8'>
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" href="../css/estilosListados.css">
			<script src="../js/consultaPorFecha.js" type="text/javascript" ></script>
			<link rel="stylesheet" type="text/css" href="../js/filtergrid.css" media="screen" />
			<script type="text/javascript" src="../js/tablefilter.js"></script>
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
			<style>
				#cuerpo {
					position: absolute;
					position: absolute;
				    left: 10px;
			    	top: 25%;
				    color: white;
			        width: 90%;
				}
			</style>

			<title>Consulta de Informes</title>
		</head>
		<body>
<?php
			include_once($pathAnalitica);
			include_once($pathCabecera);
			include_once($pathMenu);
?>
			<div id="cuerpo" style="width: 100%;">
			
				<form name="informeAdmin" id="informeAdmin" method="post" action="" style="width: 100%;">

					<input type="hidden" name="depParametro" id="depParametro" value="<?php echo $dpto;?>">
					<input type="hidden" name="subdptoParametro" id="subdptoParametro"  value="<?php echo $subdpto;?>">
					<input type="hidden" name="anioParam" id="anioParam"  value="<?php echo $anio;?>">
					<input type="hidden" name="informeParam" id="informeParam"  value="<?php echo $tipoInforme;?>">
					
					<div id="filtro" style="padding-bottom: 60px;">
						<label for="anioParametro" style="color:white;"> Seleccione el A&ntilde;o:</label>
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
						<br/><br/>
				 		<label for="email">Seleccione el Departamento*:</label>
				 		<select name="departamento" id="departamento"  onchange="javascript:pasaValoresAdmin();">
				 		<option value="0">--Seleccione el Departamento--</option>
				 		<option value="aa"
				 			<?php 				
					if ($departamentoCombo == "aa"){
?>						

								selected
<?php 
							}
?>		
			
				 		
				 		
				 		
				 		>Todos los Departamentos</option>
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
						
						
				 <label for="email">Seleccione el SubDepartamento*:</label>
				 <img src="../images/help.png" style="width:23px;" 
				 		title="Campo obligatorio.&#10;Seleccione el SubDepartamento de la consulta.
						Si desea consultar todos sus Subdepartamentos asociados, marque Todos los SubDepartamentos." onmouseover=""/>
																		  				 
				<select name="subdepartamento" id="subdepartamento">
				 <option value="0">--Seleccione el SubDepartamento--</option>
				 <option value="aa">--Todos los SubDepartamentos--</option>
<?php 
                    if ($subdepartamentoList != null){
                    for ($row = 0; $row < sizeof($subdepartamentoList); $row++){
                        if ($subdepartamentoList[$row][1] != ""){
?>
							<option value="<?php echo $subdepartamentoList[$row][1]; ?>"
<?php 
					           if ($idSub == $subdepartamentoList[$row][1]){
?>
								   selected 
<?php 
                                }
?>
							> <?php echo $subdepartamentoList[$row][2];?></option>
<?php
                        }
                    }
                    }
?>
				 </select>
				 <br><br>
				 		<label for="tipoInforme" style="color:white;">Seleccione el Tipo de Informe*:</label>

				  <input type="radio" name="tipoInforme" id="tipoInforme" value="global"
				  <?php 
				  	if ($tipoInforme=='global'){
				  ?> 
				  	checked
				  <?php 
					}
				  ?>
				  > Global 
				  <input type="radio" name="tipoInforme" id="tipoInforme" value="detalle" 
				  <?php 
				  	if ($tipoInforme=='detalle'){
				  ?> 
				  	checked
				  <?php 
					}
				  ?>
				  > Detallado
				  		<br><br>
				 		<input type="button" name="filtrar" id="filtrar" value="Filtrar" onclick="javascript:filtrarInformeAdmin();" style="float: left;"/>
					</div>
					<table border="1" id="tablaInforme" style="width:100%;">
						<thead>
							<tr>
								<th>PARTE</th>
								<th>ESB</th>
								<?php if ($tipoInforme == 'detalle') { ?>
								<th>DTP</th>
								<th>SUBDTO</th>
								<th>FECHA</th>
								<th>NOMBRE</th>
								<th>APELLIDOS</th>
								<th>DESCRIPCION</th>
								<?php } ?>
								<?php if ($tipoInforme != 'detalle') { ?>
								<th>GASTOS IMPRESORA </th>
								<th>GASTOS MAQUINAS </th>
								<?php } ?>
								<th>BLANCO Y NEGRO</th>
								<th>COLOR</th>
								<th>ENCUADERNACIONES</th>
								<th>VARIOS</th>
								<th>TOTAL</th>
							</tr>
						</thead>
<?php 
						$totalFinal = 0;
				
						if ($recuperaInforme!=null || $recuperaInformeArray!=null){
							if ($tipoInforme == 'global'){
								foreach ($recuperaInformeArray as $fila ){
									
									$total = $fila['byn'] + $fila['color'] + $fila['encuadernacion'] + $fila['varios'] + $fila['totalImpresoras'] + $fila['totalMaquinas'];
									$totalFinal = $totalFinal + $total;
									?>
										<tbody>
										<tr>
											<td id="solESB"><?php echo $fila['departamento_id'];?></td>
											<td id="solDPT"><?php echo $fila['departamentos_desc'];?></td>
											<?php if ($tipoInforme != 'detalle') { ?>
											<td id="solI"><?php echo $fila['totalImpresoras'];?></td>
											<td id="solM"><?php echo $fila['totalMaquinas'];?></td>
											<?php } ?>
											<td id="solBYN"><?php echo $fila['byn'];?></td>
											<td id="solCOL"><?php echo $fila['color'];?></td>
											<td id="solENC"><?php echo $fila['encuadernacion'];?></td>
											<td id="solVAR"><?php echo $fila['varios'];?></td>
											<td id="solTOT"><?php echo $total ?></td>					
										</tr>
<?php
									}
								}else{
									
									while ($fila = mysqli_fetch_assoc($recuperaInforme)) {
									$total = $fila['byn'] + $fila['color'] + $fila['encuadernacion'] + $fila['varios'];
									$totalFinal = $totalFinal + $total;
									?>
									<tbody>
									<tr>
										<td><?php echo $fila['codigo'];?></td>
										<td><?php echo $fila['ceco'];?></td>
										<td><?php echo $fila['departamentoDesc'];?></td>
										<td><?php echo $fila['subdepartamentos_desc'];?></td>
											<td><?php echo $fila['fechaCierre'];?></td>
										<td><?php echo $fila['nombre'];?></td>
										<td><?php echo $fila['apellido'];?></td>
										<td><?php echo $fila['descripcion'];?></td>

										<td><?php echo $fila['byn'];?></td>
										<td><?php echo $fila['color'];?></td>
										<td><?php echo $fila['encuadernacion'];?></td>
										<td><?php echo $fila['varios'];?></td>
										<td><?php echo $total ?></td>
									</tr>
									
<?php 
									
								}

								mysqli_free_result($recuperaInforme);
?>

<?php 
							}
							
						}
?>
						<tr>
						<?php if ($tipoInforme == 'detalle') { ?>
							<td colspan="12"><div style="float:right;">Total Informe</div></td>
							<td id="table8Tot1"><?php echo $totalFinal; ?></td>
							
						<?php } else {?>
							<td colspan="8"><div style="float:right;">Total Informe</div></td>
							<td id="table8Tot1"><?php echo $totalFinal; ?></td>
							<?php } ?>
						</tr>
					</tbody>
					
				</table>
				<script type="text/javascript">
						//<![CDATA[  
						
						if (document.getElementById('informeParam').value!="global"){
							var totRowIndex = tf_Tag(tf_Id('tablaInforme'),"tr").length;  
						     var table7_Props =  {  
								     
				                    rows_counter: true,  
				                    col_operation: {  
				                                id: ["table8Tot1"],  
				                                col: [12],  
				                                operation: ["sum"],  
				                                write_method: ["innerHTML","setValue"],  
				                                exclude_row: [totRowIndex],  
				                                decimal_precision: [2,0]  
				                            },  
				                    rows_always_visible: [totRowIndex]  
						     };
						     var tf7 = setFilterGrid( "tablaInforme",table7_Props );    
						}
						
						//*** Note ***  
						//You can also write operation results in elements outside the table.  
						//]]>  
		
				</script> 
				<br>
				<input type="button" name="excel" id="excel" title="Exportar a Excel" value="Exportar a Excel" onclick="generaExcel();"/>
				
			</form>
		</div>
	</body>
</html>
