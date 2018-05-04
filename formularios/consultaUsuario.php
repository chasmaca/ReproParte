<?php

$pathDB  = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";
$pathMenu = "../utiles/menuhor.php";
?>


<!doctype html>
<html lang=''>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="../js/filtergrid.css" media="screen" />
	<link rel="stylesheet" href="../css/estilosListados.css">
	<link rel="stylesheet" href="../css/estilos.css">
	<link rel="stylesheet" href="../css/styles.css">
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="../js/consultaUsuario.js" type="text/javascript" ></script>
	<script type="text/javascript" src="../js/tablefilter.js"></script>
		
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
			    left: 10px;
			    top: 25%;
			    color: white;
			        width: 90%;
				}

		</style>
		<title>Consulta de Trabajos</title>
	</head>
	<body>
<?php
		include_once($pathAnalitica);
		include_once($pathCabecera);
		include_once($pathMenu);
?>
		<br>
	
		<!-- div id='cssformulario' class='cssformulario'-->
		<div id="cuerpo" style="width: 98%;">
			<form id="consultaUsuario" name="consultaUsuario" method="POST" action="" style="width: 100%;">
				<h2>Consulta Usuarios</h2>
				<div class="inset">
					<br/>
					<span>Nombre:</span><input type="text" id="nombre" name="nombre"/>
					<br/>
					<span>Apellido:</span><input type="text" id="apellido" name="apellido"/>
					<br/>
					<span>Email login:</span><input type="text" id="logon" name="logon"/>
					<br/>
					
					<span>Rol:</span>

					<select name="role" id="role">
						<option value="1">Administrador</option>
						<option value="2">Gestor</option>
						<option value="3">Autorizador</option>
						<option value="4">Plantilla</option>
						<option value="6">Impresoras</option>
					 </select>
					<br/>
				</div>
				<input type="button" name="consultaUsuarioButton" id="consultaUsuarioButton" value="Consulta">
			</form>
			<div id="tablaResultados" name="tablaResultados" style="visibility:hidden">
				<table id="tableResultados" name="tableResultados">
					<thead>
						<tr>
							<td>Id de Usuario</td>
							<td>Nombre</td>
							<td>Apellidos</td>
							<td>Logon</td>
							<td>Role</td>
						</tr>
					</thead>
					<tbody>
						<tr>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="noResultados" style="visibility:hidden">
				<span>No se han devuelto resultados con los par&aacute;metros de b&uacute;squeda.</span>
			</div>
		</div>
	</body>
</html>