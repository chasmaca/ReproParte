<?php
$pathCabecera = "utiles/cabecera_login.php";
$pathAnalitica = "utiles/analyticstracking.php";
?>
<html>
	<head>
		<title>Reprografia</title>
		<script type="text/javascript" src="./js/inicio.js"></script>
		<link rel="stylesheet" href="css/estilos.css">
		<script type="text/javascript" src="/js/login.js"></script>
		
	</head>
	<body>
<?php
	include_once($pathAnalitica);

	include_once($pathCabecera);
?>
		<form name="indexForm" id="indexForm" action="formularios/homeRedireccion.php" method="post">
		  <h1>Aplicaci&oacute;n de gesti&oacute;n de partes de Reprograf&iacute;a</h1>
		 
		  <div class="inset">
			  
			  <div style="height:90px;margin: 0 auto;">
				 <p>
				    <input type="button" name="peticion" id="peticion" value="Solicitar Parte" onclick="javascript:envioSolicitud();">
				 </p>
			  </div>

		  
		  <div style=" align:left;height:50px;">
		  <p>
		    <input type="button" name="acceso" id="acceso" value="Acceso Autorizador" onclick="javascript:accesoLogin();">
		  </p>
		 </div>
		  </div>
		  
		</form>
	</body>
</html>