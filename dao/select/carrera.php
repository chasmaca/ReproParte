<?php
$path  = "../utiles/connectDBUtiles.php";
include_once($path);
$pathQuery = "query.php";
include_once($pathQuery);


$categoriaResult = mysqli_query($mysqlCon,$todasCarrerasQuery);

if (!$categoriaResult) {
	echo "No se pudo ejecutar con exito la consulta ($todasCarrerasQuery) en la BD: " . $mysqli->error;
	exit;
}

if (mysqli_num_rows($categoriaResult) == 0) {
	echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
	exit;
}

?>