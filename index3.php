<?php
$pathCabecera = "utiles/cabecera_formulario.php";

?>
<html>
	<head>
		<title>Reprografia</title>
		<script type="text/javascript" src="./js/inicio.js"></script>
		<link rel="stylesheet" href="css/estilos.css">
		<script type="text/javascript" src="http://www.elpartedigital.com/js/login.js"></script>
		
	</head>
	<body>
	<?php
	include_once($pathCabecera);
	?>
		<form name="login" action="formularios/homeRedireccion.php" method="post">
		  <h1>Reprografia Log in</h1>
		  <div class="inset">
		  <p>
		    <label for="email">EMAIL ADDRESS</label>
		    <input type="text" name="usuario" id="usuario">
		  </p>
		  <p>
		    <label for="password">PASSWORD</label>
		    <input type="password" name="pwd" id="pwd">
		  </p>
		  <p>
		    <label for="remember"><a href="javascript:envioSolicitud();">Crear Peticion como invitado</a></label>
		  </p>
		  </div>
		  <p class="p-container">
		    <!-- span>Forgot password ?</span-->
		    <input type="submit" name="go" id="go" value="Log in">
		  </p>
		</form>
	</body>
</html>