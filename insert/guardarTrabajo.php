<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathDetalle = "../select/detalle.php";
$pathInsert = "inserciones.php";
$pathUpdate = "../update/updates.php";

include_once($pathDB);
include_once($pathQuery);
include_once($pathInsert);
include_once($pathDetalle);
include_once($pathUpdate);

$solicitud = htmlspecialchars($_POST["solicitud"]);
$orden = htmlspecialchars($_POST["orden"]);
$codigo = htmlspecialchars($_POST["codigo"]);
$esb = htmlspecialchars($_POST["esb"]);
$cerrar = htmlspecialchars($_POST["cerrar"]);
$departamento = htmlspecialchars($_POST["departamento"]);

$tablaValores1 = htmlspecialchars($_POST["tablaValores1"]);
$tablaValores2 = htmlspecialchars($_POST["tablaValores2"]);
$tablaValores3 = htmlspecialchars($_POST["tablaValores3"]);
$tablaValores4 = htmlspecialchars($_POST["tablaValores4"]);
$tablaValores5 = htmlspecialchars($_POST["tablaValores5"]);
$tablaValores6 = htmlspecialchars($_POST["tablaValores6"]);
$tablaValores7 = htmlspecialchars($_POST["tablaValores7"]);

$subtotalEspiral = htmlspecialchars($_POST["subtotalEspiral"]);
$subtotalEncolado = htmlspecialchars($_POST["subtotalEncolado"]);
$subtotalVarios1 = htmlspecialchars($_POST["subtotalVarios1"]);
$subtotalColor = htmlspecialchars($_POST["subtotalColor"]);
$subtotalVarios2 = htmlspecialchars($_POST["subtotalVarios2"]);
$subtotalByN = htmlspecialchars($_POST["subtotalByN"]);

$cerramosTrabajo = htmlspecialchars($_POST["cerramosTrabajo"]);

$totalVarios = $subtotalVarios1 + $subtotalVarios2;
$totalEncuadernacion = $subtotalEspiral + $subtotalEncolado;

$existeTrabajoPorSol = $existeTrabajoQuery . $solicitud;
$filaTrabajo = operacionARealizar($mysqlCon,$existeTrabajoPorSol);

//Write action to txt log
$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
"Solicitud: ".$solicitud.PHP_EOL.
"ImporteVarios1: ".$subtotalVarios1.PHP_EOL.
"ImporteVarios2: ".$subtotalVarios2.PHP_EOL.
"ImporteByN: ".$subtotalByN.PHP_EOL.
"ImporteColor: ".$subtotalColor.PHP_EOL.
"ImporteEncuadernacion: ".$subtotalEspiral.PHP_EOL.
"ImporteEncolado: ".$subtotalEncolado.PHP_EOL.

"-------------------------".PHP_EOL;
//-
//file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);

error_log($log, 3, "../../log/importes.log");


if ($filaTrabajo == 0) {

	insertaTrabajo($mysqlCon,$sentenciaInsertTrabajo,$sentenciaInsertDetalle,$orden,$codigo,$esb);

}else{

	actualizaDetalle($mysqlCon);

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
 * Funcion para la insercion del trabajo. 
 * No entrara en los detalles, unicamente se limita a la cabecera del informe y las cantidades agrupadas-
 * Si todo va bien se enlaza la insercion del detalle
 * @param unknown $mysqlCon
 */
function insertaTrabajo($mysqlCon,$sentenciaInsertTrabajo,$sentenciaInsertDetalle,$orden,$codigo,$esb){

	//Se declara global para que pueda llegar a los valores del post declarados al comienzo del php
	global $solicitud,$totalEncuadernacion,$totalVarios,$departamento;
	global $subtotalEspiral,$subtotalEncolado,$subtotalVarios1,$subtotalColor,$subtotalVarios2,$subtotalByN;

	//Por ahora la relacion entre solicitud y trabajo es 1-1 aunque en bbdd es de 1-N para preveer posibles cambios
	$trabajo = 1;
	$fechafin = null;
	$usuario_id = null;
	$observaciones = null;
	$status = 4;

	if ($subtotalByN == null)
		$subtotalByN = 0;

	if ($subtotalColor == null)
		$subtotalColor = 0;

	if ($totalEncuadernacion == null)
		$totalEncuadernacion = 0;

	if ($totalVarios == null)
		$totalVarios = 0;

	if ($subtotalEspiral == null)
		$subtotalEspiral = 0;

	if ($subtotalEncolado == null)
		$subtotalEncolado = 0;

	if ($subtotalVarios1 == null)
		$subtotalVarios1 = 0;

	if ($subtotalVarios2 == null)
		$subtotalVarios2 = 0;

	$stmt = $mysqlCon->prepare($sentenciaInsertTrabajo);

	$stmt->bind_param('iississsddddddddii',$trabajo,$solicitud,$fechafin,$esb,$usuario_id,$observaciones,$codigo,$orden,$subtotalByN,$subtotalColor,$totalEncuadernacion,$totalVarios, $subtotalEspiral, $subtotalEncolado, $subtotalVarios1, $subtotalVarios2,$status,$departamento);

	$stmt->execute();

	if ($stmt->affected_rows > 0){

		$stmt->close();
		insertaDetalle($mysqlCon,$sentenciaInsertDetalle);

	}else{

		$stmt->close();
		actualizaDetalle($mysqlCon);

	}

}

/**
 * Funcion que es lanzada por insertaTrabajo.
 * Insertara el detalle de cada articulo en bbdd.
 * @param unknown $mysqlCon
 */
function insertaDetalle($mysqlCon,$sentenciaInsertDetalle){

	global $solicitud,$tablaValores7;

	$observaciones = "";

	$fechaCierre = null;

	$trabajo = 1;

	$unidades = 0;

	$precio = 0;
	//Recuperamos los datos.

	if ($tablaValores7!=null){
		insertaExtra($tablaValores7,$mysqlCon);
		exit;
	}
	
	$espiralRs = recuperaDetalleEspiral($mysqlCon);

	$encoladoRs = recuperaDetalleEncolado($mysqlCon);

	$colorRs = recuperaDetalleColor($mysqlCon);

	$varios1Rs = recuperaDetalleVarios1($mysqlCon);

	$blancoNegroRs = recuperaDetalleByN($mysqlCon);

	$varios2Rs = recuperaDetalleVarios2($mysqlCon);

	$varios2ExtraRs = recuperaDetalleVarios2Extra($mysqlCon);

	$stmt = $mysqlCon->prepare($sentenciaInsertDetalle);

	while ($fila = mysqli_fetch_assoc($espiralRs)) {

		$stmt->bind_param('iiiissid',$trabajo,$fila['TIPO_ID'],$fila['DETALLE_ID'],$unidades,$observaciones,$fechaCierre,$solicitud,$precio);
		$stmt->execute();

	}

	$stmt->close();

	$stmt1 = $mysqlCon->prepare($sentenciaInsertDetalle);

	while ($fila1 = mysqli_fetch_assoc($encoladoRs)) {

		$stmt1->bind_param('iiiissid',$trabajo,$fila1['TIPO_ID'],$fila1['DETALLE_ID'],$unidades,$observaciones,$fechaCierre,$solicitud,$precio);
		$stmt1->execute();

	}

	$stmt1->close();

	$stmt2 = $mysqlCon->prepare($sentenciaInsertDetalle);

	while ($fila2 = mysqli_fetch_assoc($colorRs)) {

		$stmt2->bind_param('iiiissid',$trabajo,$fila2['TIPO_ID'],$fila2['DETALLE_ID'],$unidades,$observaciones,$fechaCierre,$solicitud,$precio);
		$stmt2->execute();

	}

	$stmt2->close();

	$stmt3 = $mysqlCon->prepare($sentenciaInsertDetalle);

	while ($fila3 = mysqli_fetch_assoc($varios1Rs)) {

		$stmt3->bind_param('iiiissid',$trabajo,$fila3['TIPO_ID'],$fila3['DETALLE_ID'],$unidades,$observaciones,$fechaCierre,$solicitud,$precio);
		$stmt3->execute();

	}

	$stmt3->close();

	$stmt4 = $mysqlCon->prepare($sentenciaInsertDetalle);

	while ($fila4 = mysqli_fetch_assoc($blancoNegroRs)) {

		$stmt4->bind_param('iiiissid',$trabajo,$fila4['TIPO_ID'],$fila4['DETALLE_ID'],$unidades,$observaciones,$fechaCierre,$solicitud,$precio);
		$stmt4->execute();

	}

	$stmt4->close();

	$stmt5 = $mysqlCon->prepare($sentenciaInsertDetalle);

	while ($fila5 = mysqli_fetch_assoc($varios2Rs)) {

		$stmt5->bind_param('iiiissid',$trabajo,$fila5['TIPO_ID'],$fila5['DETALLE_ID'],$unidades,$observaciones,$fechaCierre,$solicitud,$precio);
		$stmt5->execute();

	}

	$stmt5->close();

	$stmt6 = $mysqlCon->prepare($sentenciaInsertDetalle);

	while ($fila6 = mysqli_fetch_assoc($varios2ExtraRs)) {

		$stmt6->bind_param('iiiissid',$trabajo,$fila6['TIPO_ID'],$fila6['DETALLE_ID'],$unidades,$observaciones,$fechaCierre,$solicitud,$precio);
		$stmt6->execute();

	}

	$stmt6->close();

	actualizaDetalle($mysqlCon);

}

/**
 * Actualizacion de la hoja de trabajo, con los distintos valores.
 * @param unknown $mysqlCon
 */
function actualizaDetalle($mysqlCon){

	global $cerrar,$solicitud,$tablaValores1,$tablaValores2,$tablaValores3,$tablaValores4,$tablaValores5,$tablaValores6,$tablaValores7,$cerramosTrabajo;
	global $subtotalByN, $subtotalColor, $totalEncuadernacion, $totalVarios, $subtotalEspiral, $subtotalEncolado, $subtotalVarios1, $subtotalVarios2;

	$valores1 = explode(";", $tablaValores1);
 	$valores2 = explode(";", $tablaValores2);
 	$valores3 = explode(";", $tablaValores3);
	$valores4 = explode(";", $tablaValores4);
 	$valores5 = explode(";", $tablaValores5);
 	$valores6 = explode(";", $tablaValores6);

 	if ($tablaValores7!=null){
		insertaExtra($tablaValores7,$mysqlCon);
	
 	}
 	
 	for($i = 0, $c = count($valores1); $i < $c; $i++){

 		if ($valores1[$i] !== ""){
 
	 		$valores11 = explode("_", $valores1[$i]);
	 		$tipo = substr($valores11[0], 0, strpos($valores11[0], "-"));
	 		$detalle = substr($valores11[0], strpos($valores11[0], "-")+1);
	 		$unidades = $valores11[1];
	 		$precio = $valores11[2];

	 		actualizaTrabajoDetalle($tipo,$detalle,$unidades,$precio,$mysqlCon);

 		}

 	}

	 for($i = 0, $c = count($valores2); $i < $c; $i++){

	 	if ($valores2[$i] !== ""){

		 	$valores22 = explode("_", $valores2[$i]);
		 	$tipo = substr($valores22[0], 0, strpos($valores22[0], "-"));
		 	$detalle = substr($valores22[0], strpos($valores22[0], "-")+1);
		 	$unidades = $valores22[1];
		 	$precio = $valores22[2];

		 	actualizaTrabajoDetalle($tipo,$detalle,$unidades,$precio,$mysqlCon);

		 }

	 }

	 for($i = 0, $c = count($valores3); $i < $c; $i++){

	 	if ($valores3[$i] !== ""){
	 		
		 	$valores33 = explode("_", $valores3[$i]);
		 	
		 	
		 	$tipo = substr($valores33[0], 0, strpos($valores33[0], "-"));
		 	$detalle = substr($valores33[0], strpos($valores33[0], "-")+1);
		 	$unidades = $valores33[1];
		 	$precio = $valores33[2];
		 	
		 	actualizaTrabajoDetalle($tipo,$detalle,$unidades,$precio,$mysqlCon);

	 	}

	 }

	 for($i = 0, $c = count($valores4); $i < $c; $i++){

	 	if ($valores4[$i] !== ""){

		 	$valores44 = explode("_", $valores4[$i]);
		 	$tipo = substr($valores44[0], 0, strpos($valores44[0], "-"));
		 	$detalle = substr($valores44[0], strpos($valores44[0], "-")+1);
		 	$unidades = $valores44[1];
		 	$precio = $valores44[2];

		 	actualizaTrabajoDetalle($tipo,$detalle,$unidades,$precio,$mysqlCon);

	 	}

	 }

	 for($i = 0, $c = count($valores5); $i < $c; $i++){

	 	if ($valores5[$i] !== ""){

		 	$valores55 = explode("_", $valores5[$i]);
		 	$tipo = substr($valores55[0], 0, strpos($valores55[0], "-"));
		 	$detalle = substr($valores55[0], strpos($valores55[0], "-")+1);
		 	$unidades = $valores55[1];
		 	$precio = $valores55[2];

		 	actualizaTrabajoDetalle($tipo,$detalle,$unidades,$precio,$mysqlCon);

	 	}

	 }

	 for($i = 0, $c = count($valores6); $i < $c; $i++){

	 	if ($valores6[$i] !== ""){

		 	$valores66 = explode("_", $valores6[$i]);
		 	$tipo = substr($valores66[0], 0, strpos($valores66[0], "-"));
		 	$detalle = substr($valores66[0], strpos($valores66[0], "-")+1, count($valores66[0]));
		 	$unidades = $valores66[1];
		 	$precio = $valores66[2];

		 	
			actualizaTrabajoDetalle($tipo,$detalle,$unidades,$precio,$mysqlCon);

	 	}

	 }

	 actualizaSubtotales($solicitud, $subtotalByN, $subtotalColor, $totalEncuadernacion, $totalVarios, $subtotalEspiral, $subtotalEncolado, $subtotalVarios1, $subtotalVarios2);

	 if ($cerrar ==1){

	 	cierraTrabajo($mysqlCon);

	 }else {

	 	actualizaEstado($solicitud, $mysqlCon, 5);

	 	if ($cerramosTrabajo == 1){

	 		header("Location: ../../formularios/cerrarSolicitud.php?solicitud=".$solicitud);
	 		exit;

	 	}

		header("Location: ../../formularios/homeTrabajo.php");
		exit;

	 }

}

/**
 * Da el trabajo por cerrado, ya se podria ver en los informes.
 * Cambia el status de la solicitud a 5
 * @param unknown $mysqlCon
 */
function cierraTrabajo($mysqlCon){

	global $solicitud,$sentenciaCierreSolicitud;
	$status = 5;


	if ($stmt = $mysqlCon->prepare($sentenciaCierreSolicitud)) {

		$stmt->bind_param('ii',$status,$solicitud);
		$stmt->execute();

	} else {

	    die("Errormessage: ". $mysqlCon->error);

	}

	$stmt->close();

	header("Location: ../../formularios/homeTrabajo.php");
	exit;

}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleEspiral($mysqlCon){

	global $recuperaEspiralQuery;

	$espiralResult = mysqli_query($mysqlCon,$recuperaEspiralQuery);

	if (!$espiralResult) {

		echo "No se pudo ejecutar con exito la consulta ($recuperaEspiralQuery) en la BD: " . mysql_error();
		exit;

	}

	return $espiralResult;

}


/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleEncolado($mysqlCon){

	global $recuperaEncoladoQuery;

	$encoladoResult = mysqli_query($mysqlCon,$recuperaEncoladoQuery);

	if (!$encoladoResult) {

		echo "No se pudo ejecutar con exito la consulta ($recuperaEncoladoQuery) en la BD: " . mysql_error();
		exit;

	}

	return $encoladoResult;

}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleVarios1($mysqlCon){

	global $recuperaVariosUnoQuery;

	$variosUnoResult = mysqli_query($mysqlCon,$recuperaVariosUnoQuery);

	if (!$variosUnoResult) {

		echo "No se pudo ejecutar con exito la consulta ($recuperaVariosUnoQuery) en la BD: " . mysql_error();
		exit;

	}

	return $variosUnoResult;

}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleColor($mysqlCon){

	global $recuperaColorQuery;

	$colorResult = mysqli_query($mysqlCon,$recuperaColorQuery);

	if (!$colorResult) {

		echo "No se pudo ejecutar con exito la consulta ($recuperaColorQuery) en la BD: " . mysql_error();
		exit;

	}
	
	echo $recuperaColorQuery;

	return $colorResult;

}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleByN($mysqlCon){

	global $recuperaByNQuery;

	$byNResult = mysqli_query($mysqlCon,$recuperaByNQuery);

	if (!$byNResult) {

		echo "No se pudo ejecutar con exito la consulta ($recuperaByNQuery) en la BD: " . mysql_error();
		exit;

	}

	return $byNResult;

}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleVarios2($mysqlCon){

	global $recuperaVariosDosQuery;

	$variosDosResult = mysqli_query($mysqlCon,$recuperaVariosDosQuery);

	if (!$variosDosResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaVariosDosQuery) en la BD: " . mysql_error();
		exit;
	}

	return $variosDosResult;

}

/**
 * Recuperamos el detalle de Espiral recuperaTiposDetalleEspiralNew
 */
function recuperaDetalleVarios2Extra($mysqlCon){

	global $recuperaVariosDosExtraQuery;

	$variosDosExtraResult = mysqli_query($mysqlCon,$recuperaVariosDosExtraQuery);

	if (!$variosDosExtraResult) {

		echo "No se pudo ejecutar con exito la consulta ($recuperaVariosDosExtraQuery) en la BD: " . mysql_error();
		exit;
		
	}

	return $variosDosExtraResult;
}

/**
 * insertamos trabajodetalle
 * @param unknown $tipo
 * @param unknown $detalle
 * @param unknown $unidades
 * @param unknown $precio
 * @param unknown $mysqlCon
 */
function actualizaTrabajoDetalle ($tipo,$detalle,$unidades,$precio,$mysqlCon){

	global $sentenciaUpdateTrabajoDetalle,$solicitud;

	$trabajo = 1;

	$stmt = $mysqlCon->prepare($sentenciaUpdateTrabajoDetalle);
	$stmt->bind_param('idiiii',$unidades,$precio,$solicitud,$trabajo,$tipo,$detalle);
	$stmt->execute();
	$stmt->close();

}

/**
 * Actualizamos los subtotales despues de cada actualizacion
 * @param unknown $solicitud
 * @param unknown $subtotalByN
 * @param unknown $subtotalColor
 * @param unknown $totalEncuadernacion
 * @param unknown $totalVarios
 * @param unknown $totalEspiral
 * @param unknown $totalEncolado
 * @param unknown $totalVarios1
 * @param unknown $totalVarios2
 */
function actualizaSubtotales($solicitud,$subtotalByN,$subtotalColor,$totalEncuadernacion,$totalVarios,$totalEspiral,$totalEncolado,$totalVarios1,$totalVarios2){

	global $sentenciaUpdateTrabajoSubtotal,$mysqlCon;
	$trabajo = 1;

	if ($subtotalByN == null)
		$subtotalByN = 0;

	if ($subtotalColor == null)
		$subtotalColor = 0;

	if ($totalEncuadernacion ==null)
		$totalEncuadernacion = 0;

	if ($totalVarios == null)
		$totalVarios = 0;

	if ($totalEspiral == null)
		$totalEspiral = 0;

	if($totalEncolado == null)
		$totalEncolado = 0;

	if($totalVarios1 == null)
		$totalVarios1 = 0;

	if($totalVarios2 == null)
		$totalVarios2= 0;

	$stmt = $mysqlCon->prepare($sentenciaUpdateTrabajoSubtotal);
	$stmt->bind_param('ddddddddii',$subtotalByN,$subtotalColor,$totalEncuadernacion,$totalVarios,$totalEspiral,$totalEncolado,$totalVarios1,$totalVarios2,$trabajo,$solicitud);
	$stmt->execute();
	$stmt->close();

}


/**
 * 
 */
function actualizaEstado($solicitud,$conexion,$status){

	global $sentenciaEstadoSolicitud;

	if ($stmt = $conexion->prepare($sentenciaEstadoSolicitud)) {

		$stmt->bind_param('ii',$status,$solicitud);
		$stmt->execute();

	} else {
		die("Errormessage: ". $conexion->error);
	}

	$stmt->close();

}


function insertaExtra($tablaValores7,$conexion){

	global $sentenciaInsertaExtra,$solicitud,$sentenciaInsertDetalle;
	$valores1 = explode(";", $tablaValores7);
	$trabajo = 1;
	$observaciones = "";
	$fechaCierre = "";

	echo count($valores1);
	
	for($i = 0; $i < count($valores1); $i++){
		$detalle = 0;
		if ($valores1[$i] !== ""){
			echo "pasamos por aqui n veces <br>";		
			$valores11 = explode("#", $valores1[$i]);
			$tipo = substr($valores11[0], 0, strpos($valores11[0], "-"));
			$detalle = recuperaMaximoPorTipo($conexion, 7);
				
			$descripcion = $valores11[1];
			$precio = $valores11[3];
			$unidades = $valores11[2];
			$precioTotal = $valores11[4];

			$stmt = $conexion->prepare($sentenciaInsertaExtra);
			$stmt->bind_param('iisd',$detalle,$tipo,$descripcion,$precio);
		//	$stmt->execute();
			$stmt->close();
			
			$fechaCierre = null;
			$stmt1 = $conexion->prepare($sentenciaInsertDetalle);
			
			$stmt1->bind_param('iiiissid',$trabajo,$tipo,$detalle,$unidades,$observaciones,$fechaCierre,$solicitud,$precioTotal);
		//	$stmt1->execute();
			$stmt1->close();
			
		}
	}
	
	
	
}
?>