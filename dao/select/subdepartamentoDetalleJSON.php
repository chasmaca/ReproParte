<?php

include ('query.php');
include '../../utiles/connectDBUtiles.php';

/*Definimos las variables*/
$departamento = "";
$subdepartamento = "";

/*Recuperamos la request*/
if( isset($_GET['departamento'])) {
	$departamento = $_GET['departamento'];
}

/*Recuperamos la request*/
if( isset($_GET['subdepartamento'])) {
	$subdepartamento = $_GET['subdepartamento'];
}


/*Realizamos la llamada a la funcion*/

	recuperaDetalleSubdepartamentos($departamento, $subdepartamento);
	
	function recuperaDetalleSubdepartamentos($departamento, $subdepartamento){
		global $recuperaDetalleSubdepartamento,$mysqlCon;
		
		/*definimos el json*/
		$jsondata = array();
		$jsondata["data"] = array();
		
		/*Prepare Statement*/
		if ($stmt = $mysqlCon->prepare($recuperaDetalleSubdepartamento)) {
			
			/*Asociacion de parametros*/
			$stmt->bind_param('ii',$departamento,$subdepartamento);
			
			/*Ejecucion*/
			$stmt->execute();
				
			/*Almacenamos el resultSet*/
			$stmt->bind_result($departamento_id, $subdepartamento_id, $subdepartamento_desc, $treintabarra);
			/*Incluimos las lineas de la consulta en el json a devolver*/
			while($stmt->fetch()) {
				$tmp = array();
				$tmp["departamento_id"] = $departamento_id;
				$tmp["subdepartamento_id"] = $subdepartamento_id;
				$tmp["subdepartamento_desc"] = utf8_encode($subdepartamento_desc);
				$tmp["treintabarra"] = $treintabarra;
			
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