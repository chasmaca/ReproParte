<?php
session_start();

include_once 'query.php';
include '../../utiles/connectDBUtiles.php';

/*Realizamos la llamada a la funcion que devolvera los departamentos*/
recuperamosSolicitudesPorUsuario();

/*Funcion que recupera todos los departamentos asociados al validador*/
function recuperamosSolicitudesPorUsuario(){

	$autorizadorId = $_SESSION["userId_session"];

	/*Declaramos como global la conexion y la query y el id de validador*/
	global $mysqlCon, $recuperaDptoXAutorizadorJSON,$solicitudPorValidadorJSONQuery;

	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();



	if($stmt = $mysqlCon->prepare($solicitudPorValidadorJSONQuery)){
		/*Asociacion de usuario*/
		$stmt->bind_param('i',$autorizadorId);
		/*Ejecucion de la consulta*/
			
		$stmt->execute();
		// distinct(d1.departamento_id) as DEPARTAMENTO_ID, d1.departamentos_desc as DEPARTAMENTOS_DESC, d1.ceco as CECO
		/*Almacenamos el resultSet*/
		$stmt->bind_result($solicitud_id,$departamento_id,$subdepartamento_id, $nombre_solicitante, $apellidos_solicitante, $autorizador_id,$descripcion_solicitante, $email_solicitante,$status_id,$fecha_alta,$fecha_validacion,$fecha_cierre,$departamentos_desc,$subdepartamentos_desc);
			
		while($stmt->fetch()){
			$tmp = array();
			$tmp["solicitud_id"] = $solicitud_id;
			$tmp["departamento_id"] = $departamento_id;
			$tmp["subdepartamento_id"] = $subdepartamento_id;
			$tmp["nombre_solicitante"] = utf8_encode($nombre_solicitante);
			$tmp["apellidos_solicitante"] = utf8_encode($apellidos_solicitante);
			$tmp["autorizador_id"] = $autorizador_id;
			$tmp["descripcion_solicitante"] = utf8_encode($descripcion_solicitante);
			$tmp["email_solicitante"] = utf8_encode($email_solicitante);
			$tmp["status_id"] = utf8_encode($status_id);
			$tmp["fecha_alta"] = $fecha_alta;
			$tmp["fecha_validacion"] = $fecha_validacion;
			$tmp["fecha_cierre"] = $fecha_cierre;
			$tmp["departamentos_desc"] = utf8_encode($departamentos_desc);
			$tmp["subdepartamentos_desc"] = utf8_encode($subdepartamentos_desc);

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