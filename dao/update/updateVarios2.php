<?php

include_once("../../utiles/connectDBUtiles.php");
include_once("../update/updates.php");
include_once("../select/query.php");

$solicitud = "";
$unidades = "";
$precio = "";
$precioTotal = "";
$descripcion = "";

$solicitud = $_GET["solicitud"];
$unidades = $_GET["unidades"];
$precio = $_GET["precio"];
$precioTotal = $_GET["precioTotal"];
$descripcion = $_GET["descripcion"];

updateVarios2($solicitud,$unidades,$precio,$precioTotal,$descripcion);

function updateVarios2($solicitud,$unidades,$precio,$precioTotal,$descripcion){
	global $mysqlCon;
	global $comprobarVarios2ExtraJSON;
	global $updateVarios2ExtraTrabajoJSON;
	$detalle = 0;
	$jsondata = array();
	$jsondata["success"] = true;

	$log  = "Query: comprobarVarios2ExtraJSON".PHP_EOL.
	$comprobarVarios2ExtraJSON.PHP_EOL.
	$descripcion .",". $precio.PHP_EOL.
	"-------------------------".PHP_EOL;
	error_log($log, 3, "../../log/errores.log");
	
	
	if ($stmt = $mysqlCon->prepare($comprobarVarios2ExtraJSON)) {
		$stmt->bind_param('sd',$descripcion,$precio);
		if ($stmt->execute()){
				$stmt->bind_result($detalle_id, $tipo_id, $descripcion, $precio);
			
			while ($stmt->fetch()) {
				$detalle = $detalle_id;
			}
			$jsondata["success"] = true;
			$jsondata["errorMessage"] = "Se ha recuperado el id de Varios2";
		}else{
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Problemas en la actualizacion de Varios2";
		}
	}else{
		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Problemas en la actualizacion de Varios2";
	}

	if($jsondata["success"] == true){
		try {
			
			$log  = "Query: updateVarios2ExtraTrabajoJSON".PHP_EOL.
			$updateVarios2ExtraTrabajoJSON.PHP_EOL.
			$unidades .",". $precioTotal .",". $solicitud .",". $detalle.PHP_EOL.
			"-------------------------".PHP_EOL;
			error_log($log, 3, "../../log/errores.log");
			
			
				$stmt = $mysqlCon->prepare($updateVarios2ExtraTrabajoJSON);
				$stmt->bind_param('idii',$unidades,$precioTotal,$solicitud,$detalle);
				if ($stmt->execute()){
					$jsondata["success"] = true;
					$jsondata["errorMessage"] = "Se ha realizado de forma correcta la insercion de Varios2";
				}else{
					$jsondata["success"] = false;
					$jsondata["errorMessage"] = "Problemas en la actualizacion de Varios2";
				}

		}catch (PDOException $e) {
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Problemas en la actualizacion de Varios2:";
	        print "Error!: " . $e->getMessage() . "<br/>";
	        die();
	    }	
		
		
	}
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}

?>