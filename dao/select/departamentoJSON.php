<?php

include_once 'query.php';
include '../../utiles/connectDBUtiles.php';

	/*Realizamos la llamada a la funcion que devolvera los departamentos*/
	recuperamosDepartamentos();
	
	/*Funcion que recupera todos los departamentos*/
	function recuperamosDepartamentos(){
		
		/*Declaramos como global la conexion y la query*/
		global $mysqlCon,$todosDepartamentosQuery;
		
		/*definimos el json*/
		$jsondata = array();
		$jsondata["data"] = array();
		
		
		$departamentoResult = mysqli_query($mysqlCon,$todosDepartamentosQuery);
		
		if (!$departamentoResult) {
			$jsondata["success"] = false;
			echo "No se pudo ejecutar con exito la consulta ($departamentoResult) en la BD: " . mysql_error();
			exit;
		}
		
		if (mysqli_num_rows($departamentoResult) == 0) {
			$jsondata["success"] = false;
			echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
			exit;
		}
		
		while ($fila = mysqli_fetch_assoc($departamentoResult)) {
			$tmp = array();
			$tmp["identificador"] = $fila["DEPARTAMENTO_ID"];
			$tmp["descripcion"] = utf8_encode($fila["DEPARTAMENTOS_DESC"]);
			$tmp["ceco"] = $fila["ceco"];
		
			/*Asociamos el resultado en forma de array en el json*/
			array_push($jsondata["data"], $tmp);
		
		}
		
		/*Asociamos el correcto funcionamiento al json para comprobar en el js*/
		$jsondata["success"] = true;
		
		/*Devolvemos el JSON con los datos de la consulta*/
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
		
	}
?>