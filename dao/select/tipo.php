<?php
include_once ('query.php');

$tipoResult = mysqli_query($mysqlCon,$recuperaTipos);

if (!$tipoResult) {
	echo "No se pudo ejecutar con exito la consulta ($recuperaTipos) en la BD: " . mysql_error();
	exit;
}

if (mysqli_num_rows($tipoResult) == 0) {
	echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
	exit;
}

?>
