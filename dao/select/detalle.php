<?php

include_once ('query.php');

function recuperaMaximoPorTipo($mysqlCon,$tipo){
	global $recuperaMaxDetalle;
	
	$valor = 1;
	
	$stmt = $mysqlCon->prepare($recuperaMaxDetalle);
	$stmt->bind_param('i',$tipo);
	/*Ejecucion de la consulta*/
	$stmt->execute();
		
	/*Almacenamos el resultSet*/
	$stmt->bind_result($DETALLEID);
	
	while($stmt->fetch()) {
		$valor = $DETALLEID;
	}
	
	if ($valor == null)
		$valor = 1;
	
	return $valor;
}

function recuperaTodosDetalles($mysqlCon){
	global $recuperaTodosDetalles;
	
	$detalles = mysqli_query($mysqlCon,$recuperaMaxDetalle);

	if (!$detalles) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaMaxDetalle) en la BD: " . mysql_error();
		exit;
	}

	return $detalles;
}


?>