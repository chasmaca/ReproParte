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
			<link rel="stylesheet" href="../css/estilosListados.css">
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

			<title>Consulta de Impresoras</title>
		</head>
		<body>
<?php
			include_once($pathAnalitica);
			include_once($pathCabecera);
			include_once($pathMenu);
?>
			<div id="cuerpo">
				<form name="consultaImpre" id="consultaImpre" method="post" action="">
					<table border="1" id="tablaInforme" style="width:100%;">
						<thead>
							<tr>
								<th>ID</th>
								<th>MODELO</th>
								<th>EDIFICIO</th>
								<th>UBICACION</th>
								<th>FECHA</th>
								<th>SERIE</th>
								<th>NUMERO</th>
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
						}
						?>
						</tbody>
					</table>
				</form>
			</div>
		</body>
	</html>