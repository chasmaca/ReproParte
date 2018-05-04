<?php

include ('query.php');

function recuperaTodosDepartamentos(){

	global $mysqlCon,$todosDepartamentosQuery;
	
	$departamentoResult = mysqli_query($mysqlCon,$todosDepartamentosQuery);
	
	if (!$departamentoResult) {
		echo "No se pudo ejecutar con exito la consulta ($departamentoResult) en la BD: " . mysql_error();
		exit;
	}
	
	if (mysqli_num_rows($departamentoResult) == 0) {
		echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
		exit;
	}
	
	return $departamentoResult;
	
}

function recuperaDepartamentoPorAutorizador($usuario){

	global $mysqlCon,$departamentosAutorizadorQuery;
	$depautResult = null;
	
	if ($usuario != null){
	   $departamentosAutorizadorQuery = $departamentosAutorizadorQuery . $usuario;
	
	   $depautResult = mysqli_query($mysqlCon,$departamentosAutorizadorQuery);
	}
	
	return $depautResult;

}



?>