<?php
include ('query.php');


$plantillaResult = mysqli_query($mysqlCon,$solicitudPorRealizarQuery);
if (!$plantillaResult) {
	echo "No se pudo ejecutar con exito la consulta ($solicitudPorRealizarQuery) en la BD: " . mysql_error();
	exit;
}
 
 function recuperaPendientes(){
 	global $mysqlCon,$solicitudPorRealizarQuery;
	  $plantillaPendienteResult = mysqli_query($mysqlCon,$solicitudPorRealizarQuery);
	 if (!$plantillaPendienteResult) {
	 	echo "No se pudo ejecutar con exito la consulta ($solicitudPorRealizarQuery) en la BD: " . mysql_error();
	 	exit;
	 }
	 
	 if (mysqli_num_rows($plantillaPendienteResult) == 0) {
	 	echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
	 }else{
	 	return $plantillaPendienteResult;
	 }
	
 }
 function recuperaGuardadas(){
 	global $mysqlCon,$solicitudGuardadaQuery;
 	$plantillaGuardadaResult = mysqli_query($mysqlCon,$solicitudGuardadaQuery);
 	
 	
 	if (!$plantillaGuardadaResult) {
 		echo "No se pudo ejecutar con exito la consulta ($solicitudGuardadaQuery) en la BD: " . mysql_error();
 		exit;
 	}
 	
 	if (mysqli_num_rows($plantillaGuardadaResult) == 0) {
 		echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
 	}else{
 		return $plantillaGuardadaResult; 		
 	}
 	
 	
 }
 
 function recuperaEnCurso(){
 	global $mysqlCon,$solicitudEnCursoQuery;
 	$plantillaEnCursoResult = mysqli_query($mysqlCon,$solicitudEnCursoQuery);
 	
 	if (!$plantillaEnCursoResult) {
 		echo "No se pudo ejecutar con exito la consulta ($solicitudEnCursoQuery) en la BD: " . mysql_error();
 		exit;
 	}
 	
 	if (mysqli_num_rows($plantillaEnCursoResult) == 0) {
	 	echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
	 }else{
 		return $plantillaEnCursoResult; 		
 	}
 }
 
 
 
 function recuperaEnCursoPlantilla(){
 	global $mysqlCon,$solicitudEnCursoPlantillaQuery;
 	$plantillaEnCursoResult = mysqli_query($mysqlCon,$solicitudEnCursoPlantillaQuery);
 
 	if (!$plantillaEnCursoResult) {
 		echo "No se pudo ejecutar con exito la consulta ($solicitudEnCursoPlantillaQuery) en la BD: " . mysql_error();
 		exit;
 	}
 
 	if (mysqli_num_rows($plantillaEnCursoResult) == 0) {
 		echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
 	}else{
 		return $plantillaEnCursoResult;
 	}
 }
 
 
 
?>
