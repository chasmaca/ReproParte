<?php

include_once 'updates.php';
include '../../utiles/connectDBUtiles.php';

cerrarSolicitud();

/*Funcion que recupera todos los departamentos asociados al validador*/
function cerrarSolicitud(){
	/*Declaramos como global la conexion y la query y el id de validador*/
	global $mysqlCon, $sentenciaCierreSolicitud;
	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();
	
	$periodo = $_GET["periodo"];

	$periodo = explode("/", $periodo);
	
	$fecha_cierre = $periodo[1]."-".$periodo[0]."-15";
	
	if ($stmt = $mysqlCon->prepare($sentenciaCierreSolicitud)) {
		
		$stmt->bind_param('sss',$fecha_cierre,
				$periodo[1],$periodo[0]);
		
		if ($stmt->execute()){
			$jsondata["success"] = true;
			$jsondata["errorMessage"] = "Se han cerrado los partes.";
		}else{
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Problemas al cerrar los partes.";
		}
	}else{
		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Problemas al cerrar los partes.";
	}
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}

?>