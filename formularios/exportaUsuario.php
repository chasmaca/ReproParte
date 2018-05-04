<?php
$pathMenu = "../utiles/menuhor.php";
$path  = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include_once($path);
include ('../dao/select/usuarios.php');
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
<script type="text/javascript" src="../js/exportaUsuarios.js"></script>
	<title>Exportar Usuarios</title>
	</head>
	<body>
	<?php
	include_once($pathAnalitica);
	include_once($pathCabecera);
	include_once($pathMenu);
	?>
		<div id='cssformulario' class='cssformulario'>
	
			<form name="exportaUsuario" id="exportaUsuario" style="width:100%;">
				<h2>Exportar Usuarios</h2>	
					<div class="inset">
					<table id="exportUsuarios" style="width:90%;">
					<thead>
						<tr>
							<th>NOMBRE</th>
							<th>ROLE</th>
							<th>DEPARTAMENTO</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					</table>
					<br><br>
					<input type="button" name="exportaUsuarios" id="exportaUsuarios" value="Consultar Usuarios"/>
					<input type="button" name="excelUsuarios" id="excelUsuarios" value="Exportar a Excel"/>
				</div>
			</form>
		</div>
	</body>
</html>