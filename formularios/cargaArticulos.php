<?php
$pathQuery = "../dao/select/query.php";
include_once($pathQuery);

function cargarDetalle($mysqlCon){
	
	$detallesResult = null;

	if( isset($_POST['tipoId']) ){
		$tipo = $_POST["tipoId"];

		global $recuperaTodosDetalles;

		$recuperaTodosDetalles = $recuperaTodosDetalles .$tipo;
	
		$detallesResult = mysqli_query($mysqlCon,$recuperaTodosDetalles);

		if (!$detallesResult) {
			echo "No se pudo ejecutar con exito la consulta ($recuperaTodosDetalles) en la BD: " . mysql_error();
			exit;
		}
	}
	
	return $detallesResult;
}



?>