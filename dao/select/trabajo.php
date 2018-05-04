<?php
$path  = "../utiles/connectDBUtiles.php";
include_once($path);

$pathQuery = "query.php";
include_once($pathQuery);

if (empty($_GET["solicitudId"])) {
	global $solicitud;
}else{
	$solicitud = $_GET["solicitudId"];
}

global $existeTrabajoQuery,$mysqlCon;
$existeTrabajoPorSol = $existeTrabajoQuery . $solicitud;
$filaTrabajo = operacionARealizar($mysqlCon,$existeTrabajoPorSol);
$existeTrabajo = 0;

if ($filaTrabajo > 0) {
	$existeTrabajo = 1;
}

function operacionARealizar($mysqlCon,$existeTrabajoPorSol){
	$operacion = mysqli_query($mysqlCon,$existeTrabajoPorSol);

	if (!$operacion) {
		echo "No se pudo ejecutar con exito la consulta ($existeTrabajoPorSol) en la BD: " . mysql_error();
		exit;
	}

	return mysqli_num_rows($operacion);
}


/**
 * Recupera Departamento de solicitud
 */
function recuperaDepartamento($solicitud, $mysqlCon){
	$recuperaDepartamentoQuery = "SELECT D1.DEPARTAMENTOS_DESC, s2.TREINTABARRA, s2.SUBDEPARTAMENTO_DESC, D1.CECO, D1.DEPARTAMENTO_ID FROM 
departamento D1, subdepartamento s2, solicitud S1 
WHERE 
S1.DEPARTAMENTO_ID = D1.DEPARTAMENTO_ID AND 
s2.DEPARTAMENTO_ID = D1.DEPARTAMENTO_ID AND 
S1.SOLICITUD_ID = $solicitud";
	$departamentoSolResult = mysqli_query($mysqlCon,$recuperaDepartamentoQuery);

	if (!$departamentoSolResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaDepartamentoQuery) en la BD: " . mysql_error();
		exit;
	}
		
	return $departamentoSolResult;
}


function recuperaSolicitante($solicitud, $mysqlCon){
	$recuperaSolicitanteQuery = "SELECT NOMBRE_SOLICITANTE, APELLIDOS_SOLICITANTE FROM solicitud S1 WHERE S1.SOLICITUD_ID = $solicitud";
	$solicitanteSolResult = mysqli_query($mysqlCon,$recuperaSolicitanteQuery);

	if (!$solicitanteSolResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaSolicitanteQuery) en la BD: " . mysql_error();
		exit;
	}
	
	while ($fila = $solicitanteSolResult->fetch_row()) {
		$solicitanteSol = $fila[0]." ".$fila[1];
	}
	
	return $solicitanteSol;
}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleEspiralConsulta($mysqlCon){
	
	global $recuperaEspiralQuery,$recuperaEspiralDetalleQuery,$existeTrabajo,$solicitud;
	
	if ($existeTrabajo == 0){
		$espiralResult = mysqli_query($mysqlCon,$recuperaEspiralQuery);
	}else{
		$recuperaEspiralDetalleQuery = $recuperaEspiralDetalleQuery . $solicitud;
		$espiralResult = mysqli_query($mysqlCon,$recuperaEspiralDetalleQuery);
	}
	if (!$espiralResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaEspiralQuery) en la BD: " . mysql_error();
		exit;
	}
	return $espiralResult;
}


/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleEncoladoConsulta($mysqlCon){

	global $recuperaEncoladoQuery,$recuperaEncoladoDetalleQuery,$existeTrabajo, $solicitud;
	
	if ($existeTrabajo == 0)
		$encoladoResult = mysqli_query($mysqlCon,$recuperaEncoladoQuery);
	else{
		$recuperaEncoladoDetalleQuery = $recuperaEncoladoDetalleQuery . $solicitud;
		$encoladoResult = mysqli_query($mysqlCon,$recuperaEncoladoDetalleQuery);
	}
	if (!$encoladoResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaEncoladoQuery) en la BD: " . mysql_error();
		exit;
	}
	return $encoladoResult;
}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleVarios1Consulta($mysqlCon){
	
	global $recuperaVariosUnoQuery,$recuperaVariosUnoDetalleQuery,$existeTrabajo, $solicitud;
	
	if ($existeTrabajo == 0)
		$variosUnoResult = mysqli_query($mysqlCon,$recuperaVariosUnoQuery);
	else{
		$recuperaVariosUnoDetalleQuery = $recuperaVariosUnoDetalleQuery . $solicitud;
		$variosUnoResult = mysqli_query($mysqlCon,$recuperaVariosUnoDetalleQuery);
	}
	if (!$variosUnoResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaVariosUnoQuery) en la BD: " . mysql_error();
		exit;
	}
	return $variosUnoResult;
}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleColorConsulta($mysqlCon){
	
	global $recuperaColorQuery,$recuperaColorDetalleQuery,$existeTrabajo, $solicitud,$colorResult;
	
	if ($existeTrabajo == 0){
		$colorResult = mysqli_query($mysqlCon,$recuperaColorQuery);
	}else{
		$recuperaColorDetalleQuery = $recuperaColorDetalleQuery . $solicitud;
		$colorResult = mysqli_query($mysqlCon,$recuperaColorDetalleQuery);
	}
	if (!$colorResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaColorQuery) en la BD: " . mysql_error();
		exit;
	}
	return $colorResult;
}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleByNConsulta($mysqlCon){
	
	global $recuperaByNQuery,$recuperaByNDetalleQuery,$existeTrabajo, $solicitud;
	
	if ($existeTrabajo == 0)
		$byNResult = mysqli_query($mysqlCon,$recuperaByNQuery);
	else{
		$recuperaByNDetalleQuery = $recuperaByNDetalleQuery . $solicitud;
		$byNResult = mysqli_query($mysqlCon,$recuperaByNDetalleQuery);
	}
	if (!$byNResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaByNQuery) en la BD: " . mysql_error();
		exit;
	}
	return $byNResult;
}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleVarios2Consulta($mysqlCon){
	
	global $recuperaDetalleVarios2,$existeTrabajo, $solicitud;
	
	$recuperaVariosDosDetalleQuery = $recuperaDetalleVarios2 . $solicitud;
	$variosDosResult = mysqli_query($mysqlCon,$recuperaVariosDosDetalleQuery);
	if (!$variosDosResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaDetalleVarios2) en la BD con el parametro $solicitud: " . mysql_error();
		exit;
	}
	return $variosDosResult;
}

/**
 * Recuperamos los subtotales
 */

function recuperaSubtotalEspiral($mysqlCon){
	
	global $solicitud,$recuperaSubtotalEspiral,$precioEspiral;
	
	$trabajo = 1;
	$espiralReturn = 0;
	/*Prepare Statement*/
	if ($stmt = $mysqlCon->prepare($recuperaSubtotalEspiral)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('ii',$trabajo,$solicitud);
		/*Ejecucion*/
		$stmt->execute();
		/*Asociacion de resultados*/
		$stmt->bind_result($precioEspiral);
		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			$espiralReturn = $precioEspiral;	
		}
		/*Cerramos la conexion*/
		$stmt->close();
	}else{
		echo "NO SE EJECUTA";
	}
	return $espiralReturn;
}

function recuperaSubtotalEncolado($mysqlCon){

	global $solicitud,$recuperaSubtotalEncolado,$col1;
	
	$trabajo = 1;
	$precioEncolado = 0;
	/*Prepare Statement*/
	if ($stmt = $mysqlCon->prepare($recuperaSubtotalEncolado)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('ii',$trabajo,$solicitud);
		/*Ejecucion*/
		$stmt->execute();
		/*Asociacion de resultados*/
		$stmt->bind_result($col1);
		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			$precioEncolado = $col1;	
		}
		/*Cerramos la conexion*/
		$stmt->close();
	}else{
		echo "NO SE EJECUTA";
	}
	return $precioEncolado;
}

function recuperaSubtotalVarios1($mysqlCon){

	global $solicitud,$recuperaSubtotalVarios1,$col1;
	
	$trabajo = 1;
	$precioVarios1 = 0;
	/*Prepare Statement*/
	if ($stmt = $mysqlCon->prepare($recuperaSubtotalVarios1)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('ii',$trabajo,$solicitud);
		/*Ejecucion*/
		$stmt->execute();
		/*Asociacion de resultados*/
		$stmt->bind_result($col1);
		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			$precioVarios1 = $col1;	
		}
		/*Cerramos la conexion*/
		$stmt->close();
	}else{
		echo "NO SE EJECUTA";
	}
	return $precioVarios1;
}

function recuperaSubtotalVarios2($mysqlCon){

	global $solicitud,$recuperaSubtotalVarios2,$col1;
	$trabajo = 1;
	$precioVarios2 = 0;
	/*Prepare Statement*/
	if ($stmt = $mysqlCon->prepare($recuperaSubtotalVarios2)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('ii',$trabajo,$solicitud);
		/*Ejecucion*/
		$stmt->execute();
		/*Asociacion de resultados*/
		$stmt->bind_result($col1);
		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			$precioVarios2 = $col1;
		}
		/*Cerramos la conexion*/
		$stmt->close();
	}else{
		echo "NO SE EJECUTA";
	}
	return $precioVarios2;
}

function recuperaSubtotalColor($mysqlCon){

	global $solicitud,$recuperaSubtotalColor,$col1;
	$trabajo = 1;
	$precioColor = 0;
	
	/*Prepare Statement*/
	if ($stmt = $mysqlCon->prepare($recuperaSubtotalColor)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('ii',$trabajo,$solicitud);
		/*Ejecucion*/
		$stmt->execute();
		/*Asociacion de resultados*/
		$stmt->bind_result($col1);
		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			$precioColor = $col1;
		}
		/*Cerramos la conexion*/
		$stmt->close();
	}else{
		echo "NO SE EJECUTA";
	}
	return $precioColor;
}

function recuperaSubtotalByN($mysqlCon){

	global $solicitud,$recuperaSubtotalByN,$col1;
	$trabajo = 1;
	$precioByN = 0;
	/*Prepare Statement*/
	if ($stmt = $mysqlCon->prepare($recuperaSubtotalByN)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('ii',$trabajo,$solicitud);
		/*Ejecucion*/
		$stmt->execute();
		/*Asociacion de resultados*/
		$stmt->bind_result($col1);
		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			$precioByN = $col1;
		}
		/*Cerramos la conexion*/
		$stmt->close();
	}else{
		echo "NO SE EJECUTA";
	}
	return $precioByN;
}

?>