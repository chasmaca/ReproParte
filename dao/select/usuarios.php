<?php

include ('query.php');

$usuariosResult = mysqli_query($mysqlCon,$recuperaUsuarios);

if (!$usuariosResult) {
	echo "No se pudo ejecutar con exito la consulta ($recuperaUsuarios) en la BD: " . mysql_error();
	exit;
}

if (mysqli_num_rows($usuariosResult) == 0) {
	echo "No se han encontrado usuarios.";
}

?>