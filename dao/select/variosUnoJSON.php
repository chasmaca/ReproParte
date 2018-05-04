<?php

	include_once 'query.php';
	include '../../utiles/connectDBUtiles.php';
	
	$solicitudId = $_GET['solicitudId'];
	/*Realizamos la llamada a la funcion que devolvera los departamentos*/
	recuperamosVarios1($solicitudId);

	/*Funcion que recupera todos los departamentos*/
	function recuperamosVarios1($solicitudId){
		global $mysqlCon,$variosUnoQuery;
		$tipo="";
		$detalle="";
		$descripcion="";
		$precio="";
		$unidades="";
		$precioTotal="";
		$jsondata = array();
		$jsondata["data"] = array();
		if($stmt = $mysqlCon->prepare($variosUnoQuery)){
			$stmt->bind_param("i", $solicitudId);
			if($stmt->execute()){
				$stmt->bind_result($tipo,$detalle,$descripcion,$precio,$unidades,$precioTotal);
				while($stmt->fetch()){
					$tmp = array();
					$tmp["tipo"] = $tipo;
					$tmp["detalle"] = $detalle;
					$tmp["descripcion"] = utf8_encode($descripcion);
					$tmp["precio"] = $precio;
					$tmp["unidades"] = $unidades;
					$tmp["precioTotal"] = $precioTotal;
					array_push($jsondata["data"], $tmp);
				}
				$jsondata["success"] = true;
			}else{
				$jsondata["success"] = false;
				$log  =
				"Fichero: variosUnoJSON.php".PHP_EOL.
				"Query: ".$variosUnoQuery.PHP_EOL.
				"Errormessage: ". $mysqlCon->error.PHP_EOL.
				"-------------------------".PHP_EOL;
				error_log($log, 3, "../../log/errores.log");
			}
			$stmt->close();
		}else{
			$jsondata["success"] = false;
			$log  =
			"Fichero: variosUnoJSON.php".PHP_EOL.
			"Query: ".$variosUnoQuery.PHP_EOL.
			"Errormessage: ". $mysqlCon->error.PHP_EOL.
			"-------------------------".PHP_EOL;
			error_log($log, 3, "../../log/errores.log");
		}
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
	}
?>