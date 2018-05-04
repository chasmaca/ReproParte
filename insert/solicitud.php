<?php

$pathSolicitud = "../select/solicitudMax.php";
$pathCabecera = "../../utiles/cabecera_operaciones.php";
$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathAutorizador = "../select/autorizador.php";

include_once($pathDB);
include ('inserciones.php');
include_once($pathSolicitud);
include_once($pathAutorizador);
include_once($pathQuery);

//Declaramos las variables
$departamento = htmlspecialchars($_POST["departamento"]);
$nombre = utf8_decode(htmlspecialchars($_POST["nombre"]));
$apellidos = utf8_decode(htmlspecialchars($_POST["apellidos"]));
$email = htmlspecialchars($_POST["email"]);
$autorizador = htmlspecialchars($_POST["autorizador"]);
$observaciones = utf8_decode(htmlspecialchars($_POST["comment"]));
$idSolicitudSQL = mysqli_fetch_assoc($maxSolicitudId);
$idSolicitud = $idSolicitudSQL["SOLICITUD_MAX"];
$subdepartamento = htmlspecialchars($_POST["subdepartamento"]);
$error = "";

date_default_timezone_set("Europe/Madrid");

if ($idSolicitud == null) {
	$idSolicitud = 1;
}

if ($stmt = $mysqlCon->prepare($sentenciaInsertSolicitud)) {
    $statusInicial = 1;
    $fechaActual = date("d/m/Y");
    
    $stmt->bind_param('iississisi',$idSolicitud,$departamento,$nombre,$apellidos,$autorizador,$observaciones,$email,$statusInicial,$fechaActual,$subdepartamento);
    $stmt->execute();
} else {
    die("Errormessage: ". $mysqlCon->error);
}
// Ahora comprobaremos que todo ha ido correctamente
$my_error = mysqli_error($mysqlCon);

if(!empty($my_error)) {
	$error = "Ha habido un error al insertar los valores. $my_error ";
} else {
	$error = "Los datos han sido introducidos satisfactoriamente. ";
	
	$emailAuth = recuperaEmail($autorizador);
	envioMail($emailAuth,$idSolicitud);
}

function envioMail($email,$idSolicitud){
	// destinatario
	$para  = $email;
	global $nombre;
	
	// título
	$titulo = 'Se ha registrado una nueva solicitud de reprografia.';
	
	$mensaje = '<html>';
	$mensaje .= '<head>';
	$mensaje .= '<meta http-equiv="Content-type" content="text/html; charset=utf-8" />';
	$mensaje .= '</head>';
	$mensaje .= '<body>';
	$mensaje .= '<div style="width:95%;height:85%;background-color:lightgray;">';
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
	$mensaje .= '<p>Se ha recibido una nueva solicitud de reprograf&iacute;a.</p>';
	$mensaje .= '<p>Por favor, acceda a la aplicaci&oacute;n para su gesti&oacute;n lo antes posible, pulsando <a href="http://www.elpartedigital.com/">AQUI</a>.</p>';
	$mensaje .= '<p>Gracias.</p>';
	$mensaje .= '<p>Por favor, no responda a este mensaje, esta direcci&oacute;n de e-mail s&oacute;lo se utiliza para realizar env&iacute;os.</p>';
	$mensaje .= '</div>';
	$mensaje .= '<br/><br/>';
	$mensaje .= '</body>';
	$mensaje .= '</html>';
	
	try {
		require '../../utiles/datosCorreo.php';
		
		$mail->addAddress($para);     		// Add a recipient
		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $titulo;
		$mail->Body    = $mensaje;
		
		$mail->send();
		} catch (Exception $e) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		
	}

?>

<!DOCTYPE HTML> 
<html>
	<head>
		<style>
			.error {color: #FF0000;}
		</style>
		<!-- link rel="stylesheet" type="text/css" href="/Repro/css/style.css"-->
		<link rel="stylesheet" href="../../css/estilos.css" />
	</head>
	<body> 
<?php 
	include_once($pathCabecera);
	echo $mensajeValida;
?>

		<form name="altaSolicitud" action="../../index.php" method="post"  id="altaSolicitud">
		 <h1>Peticion de Reprograf&iacute;a</h1>
		  <div class="inset" style="text-align:center;">
		  
<?php
				echo $error;
?>
			
			<br>
			<input type="submit" name="submit" value="Volver"> 
			<br><br>
			</div>
		</form>
	</body>
</html>