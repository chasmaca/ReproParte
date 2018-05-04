<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();
$pathDB = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";
$pathPeriodo = "../dao/select/periodo.php";

include_once($pathDB);
include_once($pathPeriodo);

?>
<html>
	<head>
		<style>
			.error {color: #FF0000;}
		</style>
		<link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
    	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/homeValidador.js"></script>
	</head>
	<body> 
<?php 
	include_once($pathAnalitica);
	include_once($pathCabecera);
?>
		<form name="validaSoliditudForm" method="post" action="" id="validaSoliditudForm">
			<h2>Validacion de Solicitudes</h2>
			<div class="inset">
			<table  id="informeValidador" style="width: 95%" id="informeValidador">
				<thead>
					<tr>
						<th>Id</th>
						<th>Departamento</th>
						<th>SubDepartamento</th>
						<th>Solicitante</th>
						<th>Fecha</th>
						<th>Observaciones</th>
						<th>Operaciones</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			
			<div style="position: relative; top:0px; width:100%; height:100%; display:none;" id="capa1">
				<input type="hidden" id="solicitudId" name="solicitudId"/>
				<input type="hidden" id="operacion" name="operacion" value="D"/>
 				<p>Introduzca el motivo del rechazo.</p>
				<textarea rows="5" cols="15" id="razonRechazo" name="razonRechazo"></textarea>
				<a onclick="javascript:envioRechazo();" style="cursor: pointer;cursor: hand;" id="botonRechazo" class="enlaceboton"> <span>Rechazar</span></a>
			</div>
		
			<br/><br/>
			<input type="button" name="volver" id="volver" value="Volver"/> 
			<input type="button" name="informeDetallado" id="informeDetallado" value="Informes"/> 
			<br/> 
			<br/>
			</div>
		</form>
	
	</body>
</html>