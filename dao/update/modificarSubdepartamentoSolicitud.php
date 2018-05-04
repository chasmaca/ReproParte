<?php

include_once 'updates.php';
include '../../utiles/connectDBUtiles.php';

$solicitud = $_GET["solicitud_id"];
$subdepartamento = $_GET["subdepartamento_id"];

actualizamosSolicitud($solicitud,$subdepartamento);

/*Funcion que recupera todos los departamentos asociados al validador*/
function actualizamosSolicitud($solicitud,$subdepartamento){

	/*Declaramos como global la conexion y la query y el id de validador*/
	global $mysqlCon, $sentenciaUpdateSubdepartamentoSolicitud;

	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();

	if ($stmt = $mysqlCon->prepare($sentenciaUpdateSubdepartamentoSolicitud)) {
		$stmt->bind_param('ii',$subdepartamento,$solicitud);
		$stmt->execute();
		$jsondata["success"] = false;
	} else {
		/*Llegamos aqui con error, asociamos false para identificarlo en el js*/
		$jsondata["success"] = $mysqlCon->error;
		die("Errormessage: ". $mysqlCon->error);
	}
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}

?>