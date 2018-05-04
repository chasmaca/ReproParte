<?php

include_once 'query.php';
include '../../utiles/connectDBUtiles.php';

$solicitudId = $_GET['solicitudId'];
/*Realizamos la llamada a la funcion que devolvera los departamentos*/
recuperamosEncuadernacion($solicitudId);

/*Funcion que recupera todos los departamentos*/
function recuperamosEncuadernacion($solicitudId){

	/*Declaramos como global la conexion y la query*/
	global $mysqlCon,$encuadernacionQuery;

	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();

	if($stmt = $mysqlCon->prepare($encuadernacionQuery)){
		$stmt->bind_param("i", $solicitudId);
		if ($stmt->execute()){
			// distinct(d1.departamento_id) as DEPARTAMENTO_ID, d1.departamentos_desc as DEPARTAMENTOS_DESC, d1.ceco as CECO
			/*Almacenamos el resultSet*/
			$stmt->bind_result($tipo,$detalle,$descripcion,$precio,$unidades,$precioTotal);
			while($stmt->fetch()){
				$tmp = array();
				$tmp["tipo"] = $tipo;
				$tmp["detalle"] = $detalle;
				$tmp["descripcion"] = utf8_encode($descripcion);
				$tmp["precio"] = $precio;
				$tmp["unidades"] = $unidades;
				$tmp["precioTotal"] = $precioTotal;
				/*Asociamos el resultado en forma de array en el json*/
				array_push($jsondata["data"], $tmp);
			}
			$jsondata["success"] = true;
		}else{
			$jsondata["success"] = false;
		}
		$stmt->close();
	}else{
		/*Asociamos el correcto funcionamiento al json para comprobar en el js*/
		$jsondata["success"] = false;
	}
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}
?>