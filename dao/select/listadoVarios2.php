<?php

include_once 'query.php';
include '../../utiles/connectDBUtiles.php';

$descripcion = strtolower($_GET['descripcion']);

devuelveListado ($descripcion);

function devuelveListado ($descripcion){
	global $mysqlCon,$listadoVarios2Query;
	$jsondata = array();
	$jsondata["data"] = array();
	$detalle_id = "";
	$tipo_id = "";
	$precio = "";
	try {
		$stmt = $mysqlCon->prepare($listadoVarios2Query);
		$descripcion = '%'.$descripcion.'%';
		$stmt->bind_param('s',$descripcion);
		if ($stmt->execute()){
			$stmt->bind_result($detalle_id, $tipo_id, $descripcion, $precio);
			while($stmt->fetch()){
				$tmp = array();
				$tmp["tipo"] = $tipo_id;
				$tmp["detalle"] = $detalle_id;
				$tmp["descripcion"] = utf8_encode($descripcion);
				$tmp["precio"] = $precio;
				/*Asociamos el resultado en forma de array en el json*/
				array_push($jsondata["data"], $tmp);
			}
			$jsondata["success"] = true;
			$jsondata["errorMessage"] = "Devolvemos el listado de Varios2";
		}else{
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Problemas al recuperar el listado";
		}
		$stmt->close();
	}catch (PDOException $e) {
		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Error!: " . $e->getMessage() . "<br/>";
		$stmt->close();
	}

	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);

}

?>