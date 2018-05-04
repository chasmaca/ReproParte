<?php

include_once ('query.php');

function recuperaMaximoPorTipo($mysqlCon,$tipo){
	global $recuperaMaxDetalle;
	
	$valor = 1;
	$recuperaMaxDetalle .= $tipo;

	$detalleMax = mysqli_query($mysqlCon,$recuperaMaxDetalle);
	
	if (!$detalleMax) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaMaxDetalle) en la BD: " . mysql_error();
		exit;
	}
	
	if (mysqli_num_rows($detalleMax) > 0) {
		while ($fila = mysqli_fetch_assoc($detalleMax)) {
			if ($fila['DETALLEID'] == null)
				$valor = 1;
			else
				$valor = $fila['DETALLEID'];
		}
	}
	
	
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