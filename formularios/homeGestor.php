<?php
$pathCabecera ="../utiles/cabecera_formulario.php";
//$pathinforme = "../dao/select/consultaInforme.php";
$path  = "../utiles/connectDBUtiles.php";
//$pathDepartamento = "../dao/select/departamentoAutorizador.php";
$pathPeriodo = "../dao/select/periodo.php";
$pathAnalitica = "../utiles/analyticstracking.php";
//$pathSubdepartamento = "../dao/select/subdepartamento.php";

include_once($path);
include_once($pathPeriodo);

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
    	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/homeGestor.js"></script>
	
	</head>
	<body>
<?php 
	include_once($pathAnalitica);
	include_once($pathCabecera);
	
?>
		<h2>Consulta de informes</h2>
		<form name="consultaInformeForm" method="post" action="" id="consultaInformeForm">
			<div id="errorMessage" style="height:10%;position:relative; color:white;background-color:red;width:98%;opacity:0.5;display:none;">
			</div>
			<div id="filtro">
				<label for="periodo" style="color:white;"> Seleccione el A&ntilde;o:</label>
				<img src="../images/help.png" style="width:23px;" 
					title="Campo obligatorio. Seleccione el periodo de la consulta."></img>
				
				<select name="periodo" id="periodo">
					<option value="0">Seleccione el periodo contable</option>
				</select>
				
				<br/> <br/>
				
				<label for="anioParametro" style="color:white;">Seleccione el Departamento*:</label>
				<img src="../images/help.png" style="width:23px;" 
					title="Campo obligatorio. Seleccione el Departamento de la consulta."></img>

				<select name="departamento" id="departamento">
					<option value="0">--Seleccione el Departamento--</option>
					<option value='aa'>Todos los Departamentos</option>
				</select>
			
				<br><br>
			
				<label for="email">Seleccione el SubDepartamento*:</label>
				<img src="../images/help.png" style="width:23px;" 
					title="Campo obligatorio.&#10;Seleccione el SubDepartamento de la consulta.
							Si desea consultar todos sus Subdepartamentos asociados, marque Todos los SubDepartamentos."/>
				
				<select name="subdepartamento" id="subdepartamento">
					<option value="0">--Seleccione el SubDepartamento--</option>
					<option value="aa">--Todos los SubDepartamentos--</option>
				</select>

				<br><br>

				<label for="tipoInforme" style="color:white;">Seleccione el Tipo de Informe*:</label>
				<img src="../images/help.png" style="width:23px;" 
					title="Campo obligatorio. Seleccione el tipo de informe que desee."></img>
				
				<input type="radio" name="tipoInforme" id="tipoInforme" value="global"> Global 
				<input type="radio" name="tipoInforme" id="tipoInforme" value="detalle"> Detallado <br>
				
				<br>
				
				<input type="button" name="filtrar" id="filtrar" value="Filtrar" style="float: left;"/>
				
				<br><br>

			</div>
			<div id="resultado" style="width:100%;" >
				<br/>
				<table id="informeGestor" style="width:90%;">
					<thead>
						<tr>
							<th>PARTE</th>
							<th>ESB</th>
							<th>DEPARTAMENTO</th>
							<th>SUBDEPARTAMENTO</th>
							<th>BLANCO Y NEGRO</th>
							<th>COLOR</th>
							<th>ENCUADERNACIONES</th>
							<th>VARIOS</th>
							<th>GASTOS IMPRESORA</th>
							<th>GASTOS MAQUINAS</th>
							<th>TOTAL</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				<input type="button" name="excel" id="excel" title="Exportar a Excel" value="Exportar a Excel" onclick=""/>
			</div>
		</form>
	</body>
</html>