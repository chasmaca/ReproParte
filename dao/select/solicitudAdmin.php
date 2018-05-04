<?php

include ('query.php');

function recuperaTrabajos($mysqlCon){

	global $consultaTodosTrabajos;

	$solicitudResult = mysqli_query($mysqlCon,$consultaTodosTrabajos);
	
	if (!$solicitudResult) {
		echo "No se pudo ejecutar con exito la consulta ($consultaTodosTrabajos) en la BD: " . mysql_error();
		exit;
	}

	return $solicitudResult;
}

function recuperaTrabajosMes($mysqlCon,$anio,$dpto){

	global $consultaTodosTrabajosMes;
	
	
///Hacerlo mediante procedimiento almacenado y no esta chapu!!!

	if ($anio != null && $anio!= "0"){
		$anioPartido = explode("/",$anio);
		$consultaTodosTrabajosMes .= " and YEAR(s1.fecha_alta) = ".  $anioPartido[1] . " and month(s1.fecha_alta) = " . $anioPartido[0];
	}
	
	if ($dpto!= null && $dpto!= "0" ){
		$consultaTodosTrabajosMes .= " and s1.departamento_id = " . $dpto;
	}
	
	$consultaTodosTrabajosMes .= " order by s1.solicitud_id";
	
	$solicitudResult = mysqli_query($mysqlCon,$consultaTodosTrabajosMes);

	if (!$solicitudResult) {
		echo "No se pudo ejecutar con exito la consulta ($consultaTodosTrabajosMes) en la BD: " . mysql_error();
		exit;
	}

	return $solicitudResult;
}
?>