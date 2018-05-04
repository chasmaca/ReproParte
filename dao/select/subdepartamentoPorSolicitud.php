<?php

include_once 'query.php';
include '../../utiles/connectDBUtiles.php';

$id = $_GET['solicitudId'];
/*Realizamos la llamada a la funcion que devolvera los departamentos*/
recuperamosSubdepartamentoIdSolicitud($id);

function recuperamosSubdepartamentoIdSolicitud($id){
	global $sentenciaSubDepartamentoJSON, $mysqlCon;
	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();
	$subdepartamento_desc = "";
	$treintaBarra = "";
	
	if ($stmt = $mysqlCon->prepare($sentenciaSubDepartamentoJSON)) {
	
		$stmt->bind_param('i',$id);
		$stmt->execute();
		$jsondata["success"] = true;
	
		$stmt->bind_result($subdepartamento_desc, $treintaBarra);
	
		while($stmt->fetch()){
			$tmp = array();
			$tmp["subdepartamentos_desc"] =  utf8_encode($subdepartamento_desc);
			$tmp["treintaBarra"] = $treintaBarra;
			/*Asociamos el resultado en forma de array en el json*/
			array_push($jsondata["data"], $tmp);
		}
		$stmt->close();
		$jsondata["success"] = true;
	}else{
		$jsondata["success"] = false;
		$log  =
		"Fichero: subdepartamentoPorSolicitud.php".PHP_EOL.
		"Query: ".$sentenciaSubDepartamentoJSON.PHP_EOL.
		"Errormessage: ". $mysqlCon->error.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
	}
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	
	}