<?php
include ('query.php');

function recuperaTodosRoles(){
	
	global $mysqlCon,$recuperaRole;
	
	$roleResult = mysqli_query($mysqlCon,$recuperaRole);
	
	if (!$roleResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaRole) en la BD: " . mysql_error();
		exit;
	}
	
	if (mysqli_num_rows($roleResult) == 0) {
		echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
		exit;
	}
	
	return $roleResult;
	
}