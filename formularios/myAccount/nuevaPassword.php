<?php 

$pathCabecera = "../../utiles/cabecera_login.php";
$path  = "../../utiles/connectDBUtiles.php";
$pathAnalitica = "../../utiles/analyticstracking.php";

include_once($path);

$email = htmlspecialchars($_POST["email"]);
$mensajeFinal="";
envioMail($email);

function envioMail($email){
	// destinatario
	$para  = $email;
	global $nombre,$mensajeFinal;

	ini_set("sendmail_from", "apps@eneasp.com");

	// título
	$titulo = 'Se ha registrado una solicitud de cambio de contraseña.';

	$mensaje = "<html>";
	$mensaje .= '<body>';
	$mensaje .= '<div style="width:80%;height:85%;background-color:lightgray;">';
	$mensaje .= '<header style="display:block;">';
	$mensaje .= '<div id="logo" style="display:inline-block;">';
	$mensaje .= '<div id="logo_text">';
	$mensaje .= '<div id="logo-enea" style="display:inline;">';
	$mensaje .= '<img src="http://www.elpartedigital.com/images/logo_enea.gif" alt="Eneasp Reprografía" width="87" height="87">';
	$mensaje .= '</div>';
	$mensaje .= '<div id="logo-slogan" style="display: inline;font-size: 18px;font-weight: bold;">Soluciones a Empresarios</div>';
	$mensaje .= '</div>';
	$mensaje .= '</div>';
	$mensaje .= '</header>';
	$mensaje .= '<br><br>';
	$mensaje .= '<p>Buenos d&iacute;as:</p>';
	$mensaje .= '<p>Se ha recibido una nueva solicitud de cambio de contrase&ntilde;a.</p>';
	$mensaje .= '<p>Si usted ha realizado la petici&oacute;n, pulse <a href="http://www.elpartedigital.com/formularios/myAccount/crearPassword.php">AQU&Iacute;</a>.</p>';
	$mensaje .= '<p>Por favor, de no haber realizado la petición, ignore este correo.</p>';
	$mensaje .= '<p>Gracias.</p>';
	$mensaje .= '<p>Por favor, no responda a este mensaje, esta direcci&oacute;n de e-mail s&oacute;lo se utiliza para realizar env&iacute;os.</p>';
	$mensaje .= '</div>';
	$mensaje .= '</body>';
	$mensaje .= '</html>';

	$headers = "From: apps@eneasp.com" . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

	// Enviarlo
	if (mail($para, $titulo, $mensaje, $headers))
		$mensajeFinal = "Mail ok";
	else
		$mensajeFinal = "Fallo el envio de correo";
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
		
		<title>Cambio de Contrase&ntilde;a</title>
	</head>
	<body>
<?php
		include_once($pathAnalitica);
		include_once($pathCabecera);
?>
		<form name="envioPasswordForm" method="post" action="" id="envioPasswordForm">
			<h1>Recuperaci&oacute;n de Contrase&ntilde;a</h1>
			<div class="inset">
				<span>
			  		Si su correo se encuentra en nuestra base de datos,
			  		habra recibido un mensaje para guiarle en el cambio de contrase&ntilde;a.
			  	</span>
			  	<span>
			  		Por favor, revise su correo.
			  	</span>
			  		<br/><br/>
		   			<input type="button" name="alta" value="Volver" onclick="javascript:volverPassword();"/>
			</div>
		</form>
	</body>
</html>