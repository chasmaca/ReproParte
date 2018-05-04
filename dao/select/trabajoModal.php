<?php
$path  = "../utiles/connectDBUtiles.php";
$pathQuery = "query.php";
include_once($path);
include_once($pathQuery);

function recuperaVarios2Modal($mysqlCon){

	global $mysqlCon,$recuperaVariosDosQuery;

	$variosDosModalResult = mysqli_query($mysqlCon,$recuperaVariosDosQuery);

	if (!$variosDosModalResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaVariosDosQuery) en la BD: " . mysql_error();
		exit;
	}

	return $variosDosModalResult;
}

?>