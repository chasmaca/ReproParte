<?php
$pathBBDD = "../utiles/connectDBUtiles.php";
$pathMenu = "../utiles/menuhor.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";
$pathDepartamento ="../dao/select/departamento.php";
$pathPeriodo = "../dao/select/periodo.php";
$pathImpresora = "../dao/select/gastoImpresora.php";
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
	<script src="../js/altaGastos.js" type="text/javascript" ></script>
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
	<title>Gastos Impresoras</title>
</head>
    <body>
<?php
		include_once($pathBBDD);
        include_once($pathAnalitica);
        include_once($pathCabecera);
        include_once($pathMenu);
        include_once($pathDepartamento);
        include_once($pathPeriodo);
        include_once($pathImpresora);
        $precioByN = recuperaGastoByN();
        $precioColor = recuperaGastoColor();
        
        $departamentoResult = recuperaTodosDepartamentos();
        
?>
        <div id='cssformulario' class='cssformulario'>
        	<form id="gastosImpresora" name="gastosImpresora" action="">
        	 <h1>Gastos de impresoras</h1>
        	 
		 	<div class="inset">
        		
        		<label for="email">Seleccione el Periodo*:</label>
				<select name="periodo" id="periodo">
					<option value="0">Seleccione el periodo</option>
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
				
        		<table style="width:90%;">
        			<thead>
        				<tr>
        					<td rowspan="2">Departamento</td>
        					<td colspan="3">M&aacute;quinas B/N</td>
        					<td colspan="3">M&aacute;quinas Color</td>
        				</tr>
        				<tr >
        					<td>N&uacute;mero</td>
        					<td>Precio</td>
        					<td>Importe</td>
        					<td>N&uacute;mero</td>
        					<td>Precio</td>
        					<td>Importe</td>
        				</tr>
        			</thead>
        			<tbody>
<?php
					while ($fila = mysqli_fetch_assoc($departamentoResult)) {
?>
						<tr>
							<td><?php echo $fila["ceco"] . " - " . utf8_encode($fila["DEPARTAMENTOS_DESC"]); ?></td>
							<td>
								<input class="input" type="text" style="width:90px;" 
									name="numeroBN_<?php echo $fila["DEPARTAMENTO_ID"]; ?>" 
									id="numeroBN_<?php echo $fila["DEPARTAMENTO_ID"]; ?>"/>
							</td>
							<td>
								<input type="text" style="width:90px;" 
									name="precioBN_<?php echo $fila["DEPARTAMENTO_ID"]; ?>" 
									id="precioBN_<?php echo $fila["DEPARTAMENTO_ID"]; ?>"
									value="<?php echo $precioByN; ?>"/>
							</td>
							<td>
								<input class="valor" type="text" readonly style="width:90px;" 
									name="valorBN_<?php echo $fila["DEPARTAMENTO_ID"]; ?>" 
									id="valorBN_<?php echo $fila["DEPARTAMENTO_ID"]; ?>"/>
							</td>
							<td>
								<input class="input" type="text" style="width:90px;" 
									name="numeroColor_<?php echo $fila["DEPARTAMENTO_ID"]; ?>" 
									id="numeroColor_<?php echo $fila["DEPARTAMENTO_ID"]; ?>"/>
							</td>
							<td>
								<input type="text" style="width:90px;" 
									name="precioColor_<?php echo $fila["DEPARTAMENTO_ID"]; ?>" 
									id="precioColor_<?php echo $fila["DEPARTAMENTO_ID"]; ?>"
									value="<?php echo $precioColor; ?>"/>
							</td>
							<td>
								<input type="text"  class="valor" readonly style="width:90px;" 
									name="valorColor_<?php echo $fila["DEPARTAMENTO_ID"]; ?>" 
									id="valorColor_<?php echo $fila["DEPARTAMENTO_ID"]; ?>"/>
							</td>
						</tr>
<?php
					}
					mysqli_free_result($departamentoResult);
?>
        			</tbody>
        		</table>
        		</div>
        	</form>
    	</div>
	</body>
</html>
        