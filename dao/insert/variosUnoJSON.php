<?php

include_once("../../utiles/connectDBUtiles.php");
include_once("../select/query.php");
include_once("../update/updates.php");
include_once("inserciones.php");

$solicitud = $_GET["solicitudId"];
$tipo = $_GET["tipo"];
$detalle = $_GET["detalle"];
$unidades = $_GET["unidades"];
$total = $_GET["total"];

insertarTrabajoDetalleVarios1($solicitud,$tipo,$detalle,$unidades,$total);

function insertarTrabajoDetalleVarios1($solicitud,$tipo,$detalle,$unidades,$total){
	global $sentenciaInsertDetalleJSON, $mysqlCon;
	/*definimos el json*/
	$jsondata = array();
	$trabajo = 1;
	if ($stmt = $mysqlCon->prepare($sentenciaInsertDetalleJSON)) {
		$stmt->bind_param('iiiiid',$trabajo,$tipo,$detalle,$unidades,$solicitud,$total);
		if ($stmt->execute()){
			$jsondata["success"] = true;
		}else {
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Error Al Recuperar Varios1, por favor, recargue la página";
			$log  =
			"Fichero: variosUNOJSON ".PHP_EOL.
			"Query: ".$sentenciaInsertDetalleJSON.PHP_EOL.
			"Errormessage: ". $mysqlCon->error.PHP_EOL.
			"-------------------------".PHP_EOL;
			error_log($log, 3, "../../log/errores.log");
		}
		
	} else {
		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;
		$log  =
		"Fichero: variosUNOJSON ".PHP_EOL.
		"Query: ".$sentenciaInsertDetalleJSON.PHP_EOL.
		"Errormessage: ". $mysqlCon->error.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
	}
	$stmt->close();
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}
?>