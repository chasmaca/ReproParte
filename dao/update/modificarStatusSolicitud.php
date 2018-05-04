<?php

include_once 'updates.php';
include '../../utiles/connectDBUtiles.php';
include "../select/autorizador.php";

$solicitud = $_GET["solicitudId"];
$operacion = $_GET["operacion"];

actualizamosSolicitud($solicitud,$operacion);

/*Funcion que recupera todos los departamentos asociados al validador*/
function actualizamosSolicitud($solicitud,$operacion){

	/*Declaramos como global la conexion y la query y el id de validador*/
	global $mysqlCon, $sentenciaUpdateStatusDosSolicitud;

	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();

	if ($stmt = $mysqlCon->prepare($sentenciaUpdateStatusDosSolicitud)) {
		$stmt->bind_param('ii',$operacion,$solicitud);
		$stmt->execute();
		$jsondata["success"] = true;
		$emailAuth = recuperaCorreo($solicitud);
		envioMail($emailAuth,$solicitud);
	} else {
		/*Llegamos aqui con error, asociamos false para identificarlo en el js*/
		$jsondata["success"] = $mysqlCon->error;
		die("Errormessage: ". $mysqlCon->error);
	}
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}

function envioMail($email,$idSolicitud){
	// destinatario
	$para  = $email;


	// título
		$titulo = 'Su petición de Reprografía ha sido Validada.';

		$mensaje = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';

		$mensaje .= "<html>";
		$mensaje .= '<body>';
		$mensaje .= '<div style="width:100%;height:85%;background-color:lightgray;">';
		$mensaje .= '<header style="display:block;">';
		$mensaje .= '<div id="logo" style="display:inline-block;">';
		$mensaje .= '<div id="logo_text">';
		$mensaje .= '<div id="logo-enea" style="display:inline;">';
		$mensaje .= '<a href="http://www.elpartedigital.com/"><img src="http://www.elpartedigital.com/images/logo_enea.gif" alt="Eneasp Reprografía" width="87" height="87"></a>';
		$mensaje .= '</div>';
		$mensaje .= '<div id="logo-slogan" style="display: inline;font-size: 18px;font-weight: bold;">Soluciones a Empresarios</div>';
		$mensaje .= '</div>';
		$mensaje .= '</div>';
		$mensaje .= '</header>';
		$mensaje .= '<br><br>';
		$mensaje .= '<p>Buenos días:</p>';
		$mensaje .= "<p>Su solicitud ha sido autorizada, con el siguiente número de parte le podrán realizar sus encargos en Reprografía.<p>";
		$mensaje .= "<p><h3><b>". $idSolicitud ."</b></h3></p>";
		$mensaje .= "<p>Muchas Gracias.</p>";
		$mensaje .= '<br/>';
		$mensaje .= '<p>Si desea acceder a la aplicación pulse <a href="http://www.elpartedigital.com/">aqui</a>.';
		$mensaje .= '<p>Por favor, no responda a este mensaje, esta dirección de e-mail sólo se utiliza para realizar envíos.</p>';
		$mensaje .= '</div>';
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
			
			//Recipients
			$mail->addAddress($para);     		// Add a recipient
			//Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = $titulo;
			$mail->Body    = $mensaje;
		
		} catch (Exception $e) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		
}


?>