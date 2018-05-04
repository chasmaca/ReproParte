<?php
include_once("../../utiles/connectDBUtiles.php");
include_once("../select/query.php");
include_once("../update/updates.php");
include_once("inserciones.php");

$solicitud = $_GET["solicitudId"];
$tipo = $_GET["tipo"];
$descripcion = $_GET["descripcion"];
$unidades = $_GET["unidades"];
$precio = $_GET["precio"];
$total = $_GET["total"];

if ($solicitud!="" && $tipo!="" && $descripcion!= "" && $unidades!="" && $precio!= "" && $total!=""){
	insertamosVarios2Extra($solicitud,$tipo,$descripcion,$unidades,$precio,$total);
}

function insertamosVarios2Extra($solicitud,$tipo,$descripcion,$unidades,$precio,$total){
	
	$log  = "Empezamos Varios2JSON".PHP_EOL.
	$saveVarios2ExtraJSON.PHP_EOL.
	"-------------------------".PHP_EOL;
	error_log($log, 3, "../../log/errores.log");
	
	$jsondata = array();

	$trabajo_id = 1;
	$operacionVarios2 = true;
	$operacionVarios2Trabajo = false;
	$lineas = 0;
	$lineasTrabajo = 0;
	
	$idMaxVarios2 = recuperamosMaxVarios2Extra();	

	$lineas =comprobamosOperacionVarios2 ($descripcion,$precio);
	
	if ($lineas == 0){
		$log  = "Empezamos Varios2JSON".PHP_EOL.
		"insertamos varios2".PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
		
		$operacionVarios2 = insertamosVarios2($idMaxVarios2,$tipo,$descripcion,$precio);
	}else{
		$log  = "Empezamos Varios2JSON".PHP_EOL.
		"NO insertamos varios2".PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
		$operacionVarios2 = false;
	}
	
	$lineasTrabajo = comprobamosOperacionTrabajoVarios2 ($solicitud,$descripcion,$precio);
	
	
	
 	if ($lineasTrabajo == 0){
 		$log  = "Empezamos Varios2JSON".PHP_EOL.
 		"insertamosVarios2DetalleTrabajo".PHP_EOL.
 		"-------------------------".PHP_EOL;
 		error_log($log, 3, "../../log/errores.log");
		
 		$operacionVarios2Trabajo = insertamosVarios2DetalleTrabajo($trabajo_id,$tipo,$idMaxVarios2,$unidades,$solicitud,$total);
 	}else {
 		$log  = "Empezamos Varios2JSON".PHP_EOL.
 		"actualizamosVarios2DetalleTrabajo".PHP_EOL.
 		"-------------------------".PHP_EOL;
 		error_log($log, 3, "../../log/errores.log");
		
 		$operacionVarios2Trabajo = actualizamosVarios2DetalleTrabajo($trabajo_id,$tipo,$lineasTrabajo,$unidades,$solicitud,$total);
 	}
	
	if ($operacionVarios2 && $operacionVarios2Trabajo){
		$jsondata["success"] = true;
		$jsondata["errorMessage"] = "Se ha realizado de forma correcta la insercion de Varios2" . $lineasTrabajo;
	}else{
		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Ha habido un problema en la insercion de valores de Varios2, por favor, actualiza la pagina." . $lineasTrabajo;
	}
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}

function recuperamosMaxVarios2Extra(){
	global $mysqlCon;
	global $recuperaMaxDetalle;
	$DETALLEID = 1;
	$valor = 1;
	$tipo = 7;

	$stmt = $mysqlCon->prepare($recuperaMaxDetalle);
	$stmt->bind_param('i',$tipo);
	/*Ejecucion de la consulta*/
	$stmt->execute();
	
	/*Almacenamos el resultSet*/
	$stmt->bind_result($DETALLEID);
	
	while($stmt->fetch()) {
		$valor = $DETALLEID;
	}
	
	if ($valor == null){
		$valor = 1;
	}
	
	$stmt->close();
	
	return $valor;
	
}

function insertamosVarios2($idMaxVarios2,$tipo,$descripcion,$precio){
	global $mysqlCon;
	global $saveVarios2ExtraJSON;
	$operacion = true;
	
	
	$log  = "Llegamos a insertamosVarios2".PHP_EOL.
	$saveVarios2ExtraJSON.PHP_EOL.
	"-------------------------".PHP_EOL;
	error_log($log, 3, "../../log/errores.log");
	
	$stmt = $mysqlCon->prepare($saveVarios2ExtraJSON);
	$stmt->bind_param('iisd',$idMaxVarios2,$tipo,$descripcion,$precio);
	if ($stmt->execute()){
		$operacion = true;
		$log  = "Right Query: ".$saveVarios2ExtraJSON.PHP_EOL.
		"detalle: ".$idMaxVarios2.PHP_EOL.
		"tipo: ".$tipo.PHP_EOL.
		"descricion: ".$descripcion.PHP_EOL.
		"precio: ".$precio.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
		
	}else{
		$operacion = false;
		$log  = "Right Query: ".$saveVarios2ExtraJSON.PHP_EOL.
		"detalle: ".$idMaxVarios2.PHP_EOL.
		"tipo: ".$tipo.PHP_EOL.
		"descricion: ".$descripcion.PHP_EOL.
		"precio: ".$precio.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
	}

	$stmt->close();
	
	return $operacion;
	
}

function insertamosVarios2DetalleTrabajo($trabajo_id,$tipo,$idMaxVarios2,$unidades,$solicitud,$total){
	global $mysqlCon;
	global $saveVarios2ExtraTrabajoJSON;
	$operacion = true;

	$log  = "Llegamos a insertamosVarios2DetalleTrabajo".PHP_EOL.
	$saveVarios2ExtraTrabajoJSON.PHP_EOL.
	"-------------------------".PHP_EOL;
	error_log($log, 3, "../../log/errores.log");
	
	
	$stmt = $mysqlCon->prepare($saveVarios2ExtraTrabajoJSON);
	$stmt->bind_param('iiiiid',$trabajo_id,$tipo,$idMaxVarios2,$unidades,$solicitud,$total);
	if ($stmt->execute()){
		$operacion = true;
		$log  = "Right Query: ".$saveVarios2ExtraTrabajoJSON.PHP_EOL.
		"trabajo: ".$trabajo_id.PHP_EOL.
		"tipo: ".$tipo.PHP_EOL.
		"detalle_id: ".$idMaxVarios2.PHP_EOL.
		"unidades: ".$unidades.PHP_EOL.
		"solicitud: ".$solicitud.PHP_EOL.
		"total: ".$total.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
		
	}else{
		$operacion = false;
		$log  = "Error Query: ".$saveVarios2ExtraTrabajoJSON.PHP_EOL.
		"trabajo_id: ".$trabajo_id.PHP_EOL.
		"tipo_id: ".$tipo.PHP_EOL.
		"detalle_id: ".$idMaxVarios2.PHP_EOL.
		"unidades: ".$unidades.PHP_EOL.
		"solicitud: ".$solicitud.PHP_EOL.
		"preciototal: ".$total.PHP_EOL.
		"error: ".$stmt->error.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
	}
	$stmt->close();
	return $operacion;
	
}


function actualizamosVarios2DetalleTrabajo($trabajo_id,$tipo,$detalle,$unidades,$solicitud,$total){
	global $mysqlCon;
	global $updateVarios2ExtraTrabajoJSON;
	$operacion = true;

	$stmt = $mysqlCon->prepare($updateVarios2ExtraTrabajoJSON);
	$stmt->bind_param('idii',$unidades,$total,$solicitud, $detalle);
	if ($stmt->execute()){
		$operacion = true;
		$log  = "Right Query: ".$updateVarios2ExtraTrabajoJSON.PHP_EOL.
		"unidades: ".$unidades.PHP_EOL.
		"total: ".$total.PHP_EOL.
		"solicitud: ".$solicitud.PHP_EOL.
		"detalle: ".$detalle.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
		}else{
		$operacion = false;
		$log  = "Error Query: ".$updateVarios2ExtraTrabajoJSON.PHP_EOL.
		"trabajo_id: ".$trabajo_id.PHP_EOL.
		"tipo_id: ".$tipo.PHP_EOL.
		"detalle_id: ".$idMaxVarios2.PHP_EOL.
		"unidades: ".$unidades.PHP_EOL.
		"solicitud: ".$solicitud.PHP_EOL.
		"preciototal: ".$total.PHP_EOL.
		"error: ".$stmt->error.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
	}
	$stmt->close();
	return $operacion;

}

function comprobamosOperacionVarios2 ($descripcion,$precio){
	global $mysqlCon;
	global $comprobarVarios2ExtraJSON;
	$row_cnt = 0;

	$log  = "Estamos en comprobamosOperacionVarios2".PHP_EOL.
	$comprobarVarios2ExtraJSON.PHP_EOL.
	"-------------------------".PHP_EOL;
	error_log($log, 3, "../../log/errores.log");
	
	if ($stmt = $mysqlCon->prepare($comprobarVarios2ExtraJSON)) {
		$stmt->bind_param('sd',$descripcion,$precio);
		$stmt->execute();

		$log  = "Error Query: ".$comprobarVarios2ExtraJSON.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");

		$stmt->store_result();
		$row_cnt = $stmt->num_rows;
	}else{
		$log  = "Error Query: ".$comprobarVarios2ExtraJSON.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");

		$row_cnt = 0;
	}
	
	$log  = "Devolvemos ".$row_cnt.PHP_EOL.
	"en comprobamosOperacionVarios2 ".PHP_EOL.
	"-------------------------".PHP_EOL;
	error_log($log, 3, "../../log/errores.log");
	
	return $row_cnt;
}

function comprobamosOperacionTrabajoVarios2 ($solicitud,$descripcion,$precio){
	global $mysqlCon;
	global $comprobarVarios2TrabajoExtraJSON;
	$detalle = 0;
	$trabajo_id = "";
	$tipo_id = ""; 
	$detalle_id = ""; 
	$unidades = "";
	$fecha_cierre = "";
	$solicitud_id = ""; 
	$preciototal = "";
	
	if ($stmt = $mysqlCon->prepare($comprobarVarios2TrabajoExtraJSON)) {
		$stmt->bind_param('isd',$solicitud,$descripcion,$precio);
		$stmt->execute();
		$log  = "Error Query: ".$comprobarVarios2TrabajoExtraJSON.PHP_EOL.
		"solicitud: ".$solicitud.PHP_EOL.
		"descripcion: ".$descripcion.PHP_EOL.
		"precio: ".$precio.PHP_EOL.
		"precio: ".$precio.PHP_EOL.
		"-------------------------".PHP_EOL;
		error_log($log, 3, "../../log/errores.log");
		
		$stmt->bind_result($trabajo_id, $tipo_id, $detalle_id, $unidades,$fecha_cierre,$solicitud_id, $preciototal);
		
		while ($stmt->fetch()) {
			$detalle = $detalle_id;
		}
	}
	$log  = "Error Query: comprobamosOperacionTrabajoVarios2".PHP_EOL.
	"devolvemos: ".$detalle.PHP_EOL.
	"-------------------------".PHP_EOL;
	error_log($log, 3, "../../log/errores.log");
	return $detalle;
}

?>