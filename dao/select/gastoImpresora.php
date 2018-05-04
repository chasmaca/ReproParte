<?php

include ('query.php');


function recuperaGastoByN(){

	global $mysqlCon, $recuperaPrecioByNCierre;
	$precioByN = "";

	$precioResult = mysqli_query($mysqlCon,$recuperaPrecioByNCierre);

	if (!$precioResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaPrecioByNCierre) en la BD: " . $mysqli->error;
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
	global $mysqlCon,$recuperaPrecioColorCierre;
	$precioColor = "";

	$precioResult = mysqli_query($mysqlCon,$recuperaPrecioColorCierre);

	if (!$precioResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaPrecioColorCierre) en la BD: " . $mysqli->error;
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