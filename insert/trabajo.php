<?php
include_once("../../utiles/connectDBUtiles.php");
include_once("../select/query.php");
include_once("../update/updates.php");
include_once("inserciones.php");

global $mysqlCon, $consultaTrabajoJSON;

$solicitud = $_GET["solicitudId"];

if ($stmt = $mysqlCon->prepare($consultaTrabajoJSON)) {
	$trabajo = 1;
	$stmt->bind_param('i',$solicitud);
	
	$stmt->execute();
	$stmt->store_result();
	$row_cnt = $stmt->num_rows;
	
	if($row_cnt < 1){
		insertarTrabajo($solicitud,$trabajo,$departamentoId,$treinta);
	}else{
		actualizaTrabajo($solicitud);
	}
}

function actualizaTrabajo($solicitud){
	global $updateTrabajoJSON, $mysqlCon;
	$jsondata = array();
	
	if ($stmt = $mysqlCon->prepare($updateTrabajoJSON)) {
		//trabajo_id, solicitud_id, fecha_inicio, CeCo, codigo, orden
		$fechaActual = date("d/m/Y");
	
		$stmt->bind_param('si',$fechaActual,$solicitud);
		
		if ($stmt->execute()){
			$jsondata["success"] = true;
			$jsondata["errorMessage"] = "Se ha actualizado el trabajo correctamente.";
		}else{ 
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Problema al actualizar el trabajo, por favor, refresca la pagina.";
			$log  =
			"Fichero: insert/trabajo.php".PHP_EOL.
			"Metodo: actualizaTrabajo".PHP_EOL.
			"Query: ".$updateTrabajoJSON.PHP_EOL.
			"Errormessage: ". $mysqlCon->error.PHP_EOL.
			"-------------------------".PHP_EOL;
			error_log($log, 3, "../../log/errores.log");
		}

	} else {
	
		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;
		$log  =
		"Fichero: insert/trabajo.php".PHP_EOL.
		"Metodo: actualizaTrabajo".PHP_EOL.
		"Query: ".$updateTrabajoJSON.PHP_EOL.
		"Errormessage: ". $mysqlCon->error.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
		
	}
	
	$stmt->close();
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}
	
function insertarTrabajo($solicitud,$trabajo,$departamentoId,$treinta){
	/*definimos el json*/
	global $insertTrabajoJSON, $mysqlCon;
	$jsondata = array();
	
	if ($stmt = $mysqlCon->prepare($insertTrabajoJSON)) {
		//trabajo_id, solicitud_id, fecha_inicio, CeCo, codigo, orden
		$fechaActual = date("d/m/Y");
		$ceco = recuperaCeco($solicitud);
		$codigo =  recuperaCodigo($solicitud);
		$subdepartamentoId = recuperaSubdepartamentoId($solicitud);
		$departamentoId =  recuperaDepartamento($solicitud);
		
		$stmt->bind_param('iisdsiii',$trabajo,$solicitud,$fechaActual,$ceco,$codigo,$solicitud,  $departamentoId,  $subdepartamentoId);
		if ($stmt->execute()){
			$jsondata["success"] = true;
			$jsondata["errorMessage"] = "Se ha creado el trabajo correctamente.";
		}else{ 
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Problema al crear el trabajo, por favor, refresque la pagina.";
			$log  =
			"Fichero: insert/trabajo.php".PHP_EOL.
			"Metodo: insertarTrabajo".PHP_EOL.
			"Query: ".$insertTrabajoJSON.PHP_EOL.
			"Errormessage: ". $mysqlCon->error.PHP_EOL.
			"-------------------------".PHP_EOL;
			error_log($log, 3, "../../log/errores.log");
				
		}
	} else {
	
		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;
		$log  =
		"Fichero: insert/trabajo.php".PHP_EOL.
		"Metodo: insertarTrabajo".PHP_EOL.
		"Query: ".$insertTrabajoJSON.PHP_EOL.
		"Errormessage: ". $mysqlCon->error.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
		
	}
	
	$stmt->close();
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}

function recuperaCeco($solicitud){
	global $consultaCeco, $mysqlCon;
	$cecoParam = "";
	
	if ($stmt = $mysqlCon->prepare($consultaCeco)) {
		$stmt->bind_param('i',$solicitud);
		
		$stmt->execute();
		
		$stmt->bind_result($ceco);
		
		while($stmt->fetch()){
			$cecoParam = $ceco;
		
		}
	}
	$stmt->close();
	return $cecoParam;
}

function recuperaDepartamento($solicitud){
	global $consultaDepartamentoId, $mysqlCon;
	$depParam = "";

	if ($stmt = $mysqlCon->prepare($consultaDepartamentoId)) {
		$stmt->bind_param('i',$solicitud);
		$stmt->execute();

		$stmt->bind_result($departamentoId);

		while($stmt->fetch()){
			$depParam = $departamentoId;

		}
	}
	$stmt->close();
	return $depParam;
}

function recuperaCodigo($solicitud){
	$codigoParam = "";
	global $consultaCodigo, $mysqlCon;
	
	if ($stmt = $mysqlCon->prepare($consultaCodigo)) {
		$stmt->bind_param('i',$solicitud);
		$stmt->execute();
	
		$stmt->bind_result($treintabarra);
	
		while($stmt->fetch()){
			$codigoParam = $treintabarra;
	
		}
	}
	$stmt->close();
	
	return $codigoParam;
	
}

function recuperaSubdepartamentoId($solicitud){
	$subdepParam = "";
	global $consultaSubDepartamentoId, $mysqlCon;

	if ($stmt1 = $mysqlCon->prepare($consultaSubDepartamentoId)) {
		$stmt1->bind_param('i',$solicitud);
		$stmt1->execute();

		$stmt1->bind_result($subdepartamento_id);

		while($stmt1->fetch()){
			$subdepParam = $subdepartamento_id;

		}
	}
	

	$stmt1->close();

	return $subdepParam;

}