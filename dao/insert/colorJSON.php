<?php

include_once("../../utiles/connectDBUtiles.php");
include_once("../select/query.php");
include_once("../update/updates.php");
include_once("inserciones.php");

global $mysqlCon, $consultaDetalleJSON;

$solicitud = $_GET["solicitudId"];
$tipo = $_GET["tipo"];
$detalle = $_GET["detalle"];
$unidades = $_GET["unidades"];
$total = $_GET["total"];

if ($stmt = $mysqlCon->prepare($consultaDetalleJSON)) {
	$trabajo = 1;
	$stmt->bind_param('iiii',$trabajo,$tipo,$detalle,$solicitud);
	
	$stmt->execute();
	$stmt->store_result();
	$row_cnt = $stmt->num_rows;

	if($row_cnt > 0){
		actualizaTrabajoDetalleColor($solicitud,$tipo,$detalle,$unidades,$total);
	}else{
		insertarTrabajoDetalleColor($solicitud,$tipo,$detalle,$unidades,$total);
	}
}

function insertarTrabajoDetalleColor($solicitud,$tipo,$detalle,$unidades,$total){
	global $sentenciaInsertDetalleJSON, $mysqlCon;
	/*definimos el json*/
	$jsondata = array();
	$trabajo = 1;
	if ($stmt = $mysqlCon->prepare($sentenciaInsertDetalleJSON)) {
		$stmt->bind_param('iiiiid',$trabajo,$tipo,$detalle,$unidades,$solicitud,$total);
		if ($stmt->execute()){
			$jsondata["success"] = true;
			$jsondata["errorMessage"] = "Se insertado la linea de forma correcta.";
		}else{
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Ha habido un problema, por favor, recargue la pagina.";
		}
	} else {
		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;
	}
	$stmt->close();
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}

function actualizaTrabajoDetalleColor($solicitud,$tipo,$detalle,$unidades,$total){
	global $sentenciaUpdateDetalleJSON, $mysqlCon;
	$jsondata = array();
	$trabajo = 1;
	if ($stmt = $mysqlCon->prepare($sentenciaUpdateDetalleJSON)) {
		$stmt->bind_param('idiiii',$unidades,$total,$trabajo,$tipo,$detalle,$solicitud);
		if ($stmt->execute()){
			$jsondata["success"] = true;
			$jsondata["errorMessage"] = "Se insertado la linea de forma correcta.";
		}else{
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Ha habido un problema, por favor, recargue la pagina.";
		}
	} else {
		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;
	}
	$stmt->close();
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	
}
?>