<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$pathCabecera = "../../utiles/cabecera_login.php";
$path  = "../../utiles/connectDBUtiles.php";
$pathAnalitica = "../../utiles/analyticstracking.php";

include_once($path);

$email = $emailErr="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["email"])) {
		$emailErr = "Debe introducir un email valido";
	} else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Formato Incorrecto de email";
		}
	}
}

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
		<script>
			$(function() {
				$( document ).tooltip();
			});
		</script>
		<title>Cambio de Contrase&ntilde;a</title>
	</head>
	<body> 
<?php
		include_once($pathAnalitica);
		include_once($pathCabecera);
		// define variables and set to empty values
		
?>
		<form name="cambioPasswordForm" method="post" action="" id="cambioPasswordForm">
		 <h1>Recuperaci&oacute;n de Contrase&ntilde;a</h1>
			<div class="inset">
				<h3>Introduzca su usuario de acceso a la aplicaci&oacute;n</h3>
				<label for="email">E-mail*:</label> 
			   	<img src="../../images/help.png" style="width:23px;" title="Campo obligatorio. Introduzca el correo de acceso a la aplicaci&oacute;n." onclick="" onmouseover=""></img>
			   	<input type="text" name="email" id="email"/>
			   	<span class="error" id="errorEmail"  style="visibility:hidden; color:red;"><?php echo $emailErr;?></span>
			   	<br/><br/>
			   	<input type="button" name="alta" value="Enviar" onclick="javascript:envioPassword();"/>
			</div> 
		</form>
	</body>
</html>