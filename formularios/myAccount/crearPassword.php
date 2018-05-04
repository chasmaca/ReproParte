<?php
$pathCabecera = "../../utiles/cabecera_login.php";
$path  = "../../utiles/connectDBUtiles.php";
$pathAnalitica = "../../utiles/analyticstracking.php";

include_once($path);

$emailErr = $pwdErr = $pwdRepErr = "";
?>
<html>
	<head>
		<meta charset='utf-8'/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" href="../../css/estilos.css" />
		<script type="text/javascript" src="../../js/gestion.js"> </script>
		<script type="text/javascript" src="../../js/jquery.1.4.2.min.js"> </script>
		<script type="text/javascript" src="../../js/select_replacement.1.0.0.js"> </script>
		
		<title>Cambio de Contrase&ntilde;a</title>
	</head>
	<body>
<?php
		include_once($pathAnalitica);
		include_once($pathCabecera);
?>
		<form name="nuevaPasswordForm" method="post" action="" id="nuevaPasswordForm">
			<h1>Recuperaci&oacute;n de Contrase&ntilde;a</h1>
			<div class="inset">
			<label for="email">Introduzca su E-mail*:</label> 
		   	<img src="../../images/help.png" style="width:23px;" title="Campo obligatorio. Introduzca el correo de acceso a la aplicacion." onclick="" onmouseover=""></img>
		   	<input type="text" name="email" id="email" value=""/>
		   	<span class="error" id="errorEmail"  style="visibility:hidden; color:red;"></span>
		   	<br/><br/>
		   	<label for="email">Introduzca su Contrase&ntilde;a*:</label> 
		   	<img src="../../images/help.png" style="width:23px;" title="Campo obligatorio. Introduzca la nueva contrase&ntilde;a." onclick="" onmouseover=""></img>
		   	<input type="password" name="pwd" id="pwd" value=""/>
		   	<span class="error" id="errorPassword"  style="visibility:hidden; color:red;"></span>
		   	<br/><br/>
		   	<label for="email">Vuelva a completar su Contrase&ntilde;a*:</label> 
		   	<img src="../../images/help.png" style="width:23px;" title="Campo obligatorio. Introduzca de nuevo su contrase&ntilde;a." onclick="" onmouseover=""></img>
		   	<input type="password" name="pwdRep" id="pwdRep" value=""/>
		   	<span class="error" id="errorPasswordRep"  style="visibility:hidden; color:red;"></span>
		   	<br/><br/>
		   	<input type="button" name="alta" value="Actualizar" onclick="javascript:actualizarPassword();"/>
			</div>
		</form>
	</body>
</html>