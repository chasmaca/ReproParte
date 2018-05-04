<?php
session_start();

$pathDB  = "../../utiles/connectDBUtiles.php";

$pathQuery = "../select/query.php";
$pathCorreo = "../select/autorizador.php";


include_once($pathDB);
include_once($pathQuery);
include_once($pathCorreo);

require '../PHPMailer/PHPMailerAutoload.php';

$accion = 0;

$comentario = "";


if ($_GET['operacion'] == "A"){
	$queryActualizaQuery = $updateSolicitudQuery . " status_id = 2, fecha_validacion = now() where solicitud_id = " . $_GET['solicitudId'];
	$accion = 1;
}
	
if ($_GET['operacion'] == "D"){
	$comentario = $_GET['razonRechazo'];
	$queryActualizaQuery = $updateSolicitudQuery . " status_id = 3, fecha_validacion = now(), comentario = '" . $comentario ."' where solicitud_id = " . $_GET['solicitudId'];
	$accion = 2;	
}


mysqli_query($mysqlCon,$queryActualizaQuery);

$my_error = mysqli_error($mysqlCon);

if(!empty($my_error)) {
	$error = "Ha habido un error al insertar los valores. $my_error ";
} else {
	$error = "Los datos han sido introducidos satisfactoriamente. ";
	
	/***
	 * Envio de correo
	 */
	
	$idSolicitud = $_GET['solicitudId'];
	$emailAuth = recuperaCorreo($idSolicitud);
	envioMail($emailAuth,$idSolicitud,$comentario);
	
}


function envioMail($email,$idSolicitud,$comentario){
	// destinatario
	$para  = $email;
	global $nombre, $accion;

	ini_set("sendmail_from", "info@eneasp.com");

	// t�tulo
	$titulo = 'Su petici�n de Reprograf�a ha sido Validada.';

	
	$mensaje = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
	
	$mensaje .= "<html>";
	$mensaje .= '<body>';
	$mensaje .= '<div style="width:100%;height:85%;background-color:lightgray;">';
	$mensaje .= '<header style="display:block;">';
	$mensaje .= '<div id="logo" style="display:inline-block;">';
	$mensaje .= '<div id="logo_text">';
	$mensaje .= '<div id="logo-enea" style="display:inline;">';
	$mensaje .= '<a href="http://www.elpartedigital.com/"><img src="http://www.elpartedigital.com/images/logo_enea.gif" alt="Eneasp Reprograf�a" width="87" height="87"></a>';
	$mensaje .= '</div>';
	$mensaje .= '<div id="logo-slogan" style="display: inline;font-size: 18px;font-weight: bold;">Soluciones a Empresarios</div>';
	$mensaje .= '</div>';
	$mensaje .= '</div>';
	$mensaje .= '</header>';
	$mensaje .= '<br><br>';
	$mensaje .= '<p>buenos d&iacute;as:</p>';
	if ($accion == 1){
		$mensaje .= "<p>Su solicitud ha sido autorizada, con el siguiente n&uacute;mero de parte le podr&aacute;n realizar sus encargos en Reprograf&iacute;a.<p>";
		$mensaje .= "<p><h3><b>". $idSolicitud ."</b></h3></p>";
		$mensaje .= "<p>Muchas Gracias.</p>";
	}
	if ($accion == 2){
		$mensaje .= "<p>Su solicitud ha sido rechazada por su autorizador con la siguiente raz&oacute;n.</p>";
		$mensaje .= "<p>" . $comentario . "</p>";
		$mensaje .= "<p>P&oacute;ngase en contacto con su autorizador para conocer m&aacute;s detalles.</p>";
		$mensaje .= "<p>Muchas Gracias.</p>";
	}
	$mensaje .= '<br/>';
	$mensaje .= '<p>Si desea acceder a la aplicaci&oacute;n pulse <a href="http://www.elpartedigital.com/">aqu&iiacute;</a>.';
	$mensaje .= '<p>Por favor, no responda a este mensaje, esta direcci&oacute;n de e-mail s&oacute;lo se utiliza para realizar env&iacute;os.</p>';
	$mensaje .= '</div>';
	$mensaje .= '</body>';
	$mensaje .= '</html>';
	
	$mail = new PHPMailer;
	
	try {
		//Server settings
	

		$mail->IsSMTP();
		$mail->Host = "smtp.dominioabsoluto.net";
		$mail->SMTPAuth = true;
		
		$mail->SMTPSecure = "tls";
		$mail->Username = "info@elpartedigital.com";
		$mail->Password = "Elparte2017!";
		$mail->Port = "587";                       	// SMTP password
	
		//Recipients
		$mail->setFrom('info@elpartedigital.com', 'Reprografia');
		$mail->addAddress($para);     		// Add a recipient
		//$mail->addAddress('ellen@example.com');               		// Name is optional
		$mail->addReplyTo('info@elpartedigital.com', 'Informacion');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $titulo;
		$mail->Body    = $mensaje;
		//	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
		$mail->send();
	} catch (Exception $e) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
	

}


header("Location: ../../formularios/homeValidador.php");
exit;

?>