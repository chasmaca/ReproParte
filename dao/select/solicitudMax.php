<?php

$path  = "../../utiles/connectDBUtiles.php";
include_once($path);
include ('query.php');

$maxSolicitudId = mysqli_query($mysqlCon,$maximaSolicidud);

if (!$maxSolicitudId) {
	echo "No se pudo ejecutar con exito la consulta ($maximaSolicidud) en la BD: " . mysql_error();
	exit;
}

if (mysqli_num_rows($maxSolicitudId) == 0) {
	echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
	exit;
}

?>
