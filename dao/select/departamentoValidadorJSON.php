<?php
session_start();

include_once 'query.php';
include '../../utiles/connectDBUtiles.php';

	/*Realizamos la llamada a la funcion que devolvera los departamentos*/
	recuperamosDepartamentos();
	
	/*Funcion que recupera todos los departamentos asociados al validador*/
	function recuperamosDepartamentos(){
	
		$autorizadorId = $_SESSION["userId_session"];
		
		/*Declaramos como global la conexion y la query y el id de validador*/
		global $mysqlCon, $recuperaDptoXAutorizadorJSON;
		
		/*definimos el json*/
		$jsondata = array();
		$jsondata["data"] = array();
		
		
		
		if($stmt = $mysqlCon->prepare($recuperaDptoXAutorizadorJSON)){
			/*Asociacion de usuario*/
			$stmt->bind_param('i',$autorizadorId);
			/*Ejecucion de la consulta*/
			
			$stmt->execute();
			// distinct(d1.departamento_id) as DEPARTAMENTO_ID, d1.departamentos_desc as DEPARTAMENTOS_DESC, d1.ceco as CECO
			/*Almacenamos el resultSet*/
			$stmt->bind_result($DEPARTAMENTO_ID,$DEPARTAMENTOS_DESC,$CECO);
			
			while($stmt->fetch()){
				$tmp = array();
				$tmp["departamento_id"] = $DEPARTAMENTO_ID;
				$tmp["departamentos_desc"] = utf8_encode($DEPARTAMENTOS_DESC);
				$tmp["ceco"] = $CECO;
				
				/*Asociamos el resultado en forma de array en el json*/
					
				array_push($jsondata["data"], $tmp);
					
			}
			$stmt->close();
			/*Asociamos el correcto funcionamiento al json para comprobar en el js*/
			$jsondata["success"] = true;
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