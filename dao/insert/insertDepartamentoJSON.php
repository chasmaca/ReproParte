<?php
$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathInsert = "inserciones.php";

include_once($pathDB);
include_once($pathQuery);
include_once($pathInsert);
	
	$departamento = utf8_decode($_GET["departamento"]);
	$ceco = $_GET["ceco"];
	
	global $sentenciaInsertDepartamento, $mysqlCon;
	/*definimos el json*/
	$jsondata = array();

	if ($stmt = $mysqlCon->prepare($sentenciaInsertDepartamento)) {

		$stmt->bind_param('ss',$departamento,$ceco);
		$stmt->execute();
		$jsondata["success"] = true;

	} else {

		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;

	}

	$stmt->close();

	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);

?>