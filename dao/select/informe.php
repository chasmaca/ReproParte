<?php
$path  = "../utiles/connectDBUtiles.php";
include_once($path);

$pathQuery = "query.php";
include_once($pathQuery);

function generaInforme($mysqlCon){
	global $generaInforme;

	$informeResult = mysqli_query($mysqlCon,$generaInforme);

	if (!$informeResult) {
		echo "No se pudo ejecutar con exito la consulta ($informeResult) en la BD: " . mysql_error();
		exit;
	}

	return $informeResult;
}

?>