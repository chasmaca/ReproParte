<?php

include_once 'query.php';
include '../../utiles/connectDBUtiles.php';

	/*Realizamos la llamada a la funcion que calculara el periodo*/
	if ($_GET["opcion"]!=null){
		recuperamosPeriodoCierre();
	}else{
		recuperamosPeriodo();
	}
	
	/*Funcion que recupera todos los periodos con actividad*/
	function recuperamosPeriodo(){

		/*Declaramos como global la conexion y la query*/
		global $mysqlCon,$recuperaAnioMes;
		
		/*definimos el json*/
		$jsondata = array();
		$jsondata["data"] = array();

		$periodoResult = mysqli_query($mysqlCon,$recuperaAnioMes);
		
			if (!$periodoResult) {
				echo "No se pudo ejecutar con exito la consulta ($recuperaAnioMes) en la BD: " . mysql_error();
				exit;
			}
			
			if (mysqli_num_rows($periodoResult) == 0) {
				echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
				exit;
			}
			
			while ($fila = mysqli_fetch_assoc($periodoResult)) {
				$tmp = array();
				$tmp["mes_alta"] = $fila["mes_alta"];
				$tmp["anio_alta"] = $fila["anio_alta"];

				/*Asociamos el resultado en forma de array en el json*/
				array_push($jsondata["data"], $tmp);

			}

			/*Asociamos el correcto funcionamiento al json para comprobar en el js*/
			$jsondata["success"] = true;
		
		/*Devolvemos el JSON con los datos de la consulta*/
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
	}
	
	/*Funcion que recupera todos los periodos con actividad*/
	function recuperamosPeriodoCierre(){
	
		/*Declaramos como global la conexion y la query*/
		global $mysqlCon,$recuperaAnioMesCierre;
	
		/*definimos el json*/
		$jsondata = array();
		$jsondata["data"] = array();
	
		$periodoResult = mysqli_query($mysqlCon,$recuperaAnioMesCierre);
	
		if (!$periodoResult) {
			echo "No se pudo ejecutar con exito la consulta ($recuperaAnioMesCierre) en la BD: " . mysql_error();
			exit;
		}
			
		if (mysqli_num_rows($periodoResult) == 0) {
			echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
			exit;
		}
			
		while ($fila = mysqli_fetch_assoc($periodoResult)) {
			$tmp = array();
			$tmp["mes_alta"] = $fila["mes_alta"];
			$tmp["anio_alta"] = $fila["anio_alta"];
	
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