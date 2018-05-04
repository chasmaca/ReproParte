<?php

include ('query.php');

global $recuperaAnioMes;

$periodoResult = mysqli_query($mysqlCon,$recuperaAnioMes);

if (!$periodoResult) {
	echo "No se pudo ejecutar con exito la consulta ($recuperaAnioMes) en la BD: " . mysql_error();
	exit;
}

if (mysqli_num_rows($periodoResult) == 0) {
	echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
	exit;
}

?>