<?php

include_once 'updates.php';
include '../../utiles/connectDBUtiles.php';

$solicitud = $_GET["solicitud_id"];
$departamento = $_GET["departamento_id"];
$subdepartamento = $_GET["subdepartamento_id"];

actualizamosSolicitud($solicitud,$departamento,$subdepartamento);

/*Funcion que recupera todos los departamentos asociados al validador*/
function actualizamosSolicitud($solicitud,$departamento,$subdepartamento){
	
	/*Declaramos como global la conexion y la query y el id de validador*/
	global $mysqlCon, $sentenciaUpdateDepartamentoSolicitud;
	
	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();
	
	if ($stmt = $mysqlCon->prepare($sentenciaUpdateDepartamentoSolicitud)) {
		$stmt->bind_param('iii',$departamento,$subdepartamento,$solicitud);
		$stmt->execute();
		$jsondata["success"] = false;
	} else {
		/*Llegamos aqui con error, asociamos false para identificarlo en el js*/
		$jsondata["success"] = false;
		die("Errormessage: ". $mysqlCon->error);
	}
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}

?>