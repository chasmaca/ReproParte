<?php

include ('query.php');


function recuperaGastoByN(){

/*INICIO NO VALIDO CON LA VERSION PHP DEL SERVER
 	global $mysqlCon, $recuperaPrecioByNMaquCierre;
 	$precioByN = "";

 	$res =& $mysqlCon->query($recuperaPrecioByNMaquCierre);

 	$precioByN = $res->fetch_row()[0];

 	$res->free();

 	return $precioByN;
FIN NO VALIDO CON LA VERSION PHP DEL SERVER*/
	
	global $mysqlCon, $recuperaPrecioByNMaquCierre;
	$precioByN = "";
	
	$precioResult = mysqli_query($mysqlCon,$recuperaPrecioByNMaquCierre);
	
	if (!$precioResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaPrecioByNMaquCierre) en la BD: " . $mysqli->error;
		exit;
	}
	
	if (mysqli_num_rows($precioResult) == 0) {
		echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
		exit;
	}
	
	
	if (mysqli_num_rows($precioResult) > 1) {
		echo "Hay varios precios que se corresponden con la selección, por favor, revise la bbdd.";
		exit;
	}
	
	while ($fila = mysqli_fetch_assoc($precioResult)) {
		if ($fila['precio'] == null)
			$precioByN = 0;
			else
				$precioByN = $fila['precio'];
	}
	
	return $precioByN;
	

}

function recuperaGastoColor(){
	
	/*INICIO NO VALIDO CON LA VERSION PHP DEL SERVER
	global $mysqlCon,$recuperaPrecioColorMaquCierre;
	$precioColor = "";

	$res =& $mysqlCon->query($recuperaPrecioColorMaquCierre);

	$precioColor = $res->fetch_row()[0];

	$res->free();

	return $precioColor;
	FIN NO VALIDO CON LA VERSION PHP DEL SERVER*/
	
	global $mysqlCon,$recuperaPrecioColorMaquCierre;
	$precioColor = "";
	
	$precioResult = mysqli_query($mysqlCon,$recuperaPrecioColorMaquCierre);
	
	if (!$precioResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaPrecioColorMaquCierre) en la BD: " . $mysqli->error;
		exit;
	}
	
	if (mysqli_num_rows($precioResult) == 0) {
		echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
		exit;
	}
	
	
	if (mysqli_num_rows($precioResult) > 1) {
		echo "Hay varios precios que se corresponden con la selección, por favor, revise la bbdd.";
		exit;
	}
	
	while ($fila = mysqli_fetch_assoc($precioResult)) {
		if ($fila['precio'] == null)
			$precioColor = 0;
			else
				$precioColor = $fila['precio'];
	}
	
	return $precioColor;
}


?>