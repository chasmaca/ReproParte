<?php

include_once '../select/query.php';
include '../../utiles/connectDBUtiles.php';

//Declaracion de parametros
$periodo = "";

//Recogemos los valores
if( isset($_GET['periodo'])) {
	$periodo = $_GET['periodo'];
}

/*En caso que el combo no tenga seleccionado un periodo no se realizara ninguna operacion.*/
if ($periodo != ""){

	recuperamosGastos($periodo);

} else {

	die("Debe Cumplimentar correctamente los campos.");

}

/**
 * Funcion para la recuperacion de todos los datos de gastos de cierre en impresoras.
 * Las consultas se haran en funcion del periodo del combo del html
 * @param unknown $periodo
 */
function recuperamosGastos($periodoCierre){

	global $mysqlCon,$recuperaGastosMaquinaCierre;

	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();

	//Realizaremos un split del periodo que vendra con este formato--> 11/2016

	$separador = strrpos($periodoCierre, '/');

	$mes = substr($periodoCierre, 0, $separador);
	$anio = substr($periodoCierre, $separador+1);

	if ($stmt = $mysqlCon->prepare($recuperaGastosMaquinaCierre)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('ss',$anio,$mes);
		/*Ejecucion de la consulta*/
		$stmt->execute();
		/*Almacenamos el resultSet*/
			//$resultSet = $stmt->get_result();
			/*Asociamos el resultado en forma de array en el json*/
			//$jsondata["data"] = $resultSet->fetch_all();
			
			//FIN Esta sentencia no es valida con la version de PHP del server
		
			/*Almacenamos el resultSet*/
			$stmt->bind_result($departamento_id,$periodo, $byn_precio,$byn_total,$color_unidades, $color_precio,$color_total, $byn_unidades);

			while($stmt->fetch()) {
				
				$tmp = array();
				$tmp["departamento_id"] = $departamento_id;
				$tmp["periodo"] = $periodo;
				$tmp["byn_precio"] = $byn_precio;
				$tmp["byn_total"] = $byn_total;
				$tmp["color_unidades"] = $color_unidades;
				$tmp["color_precio"] = $color_precio;
				$tmp["color_total"] =$color_total;
				$tmp["byn_unidades"] =$byn_unidades;
				
				/*Asociamos el resultado en forma de array en el json*/
				array_push($jsondata["data"], $tmp);
			}
			$stmt->close();
		/*Asociamos el correcto funcionamiento al json para comprobar en el js*/
		$jsondata["success"] = true;
	} else {
		/*Llegamos aqui con error, asociamos false para identificarlo en el js*/
		$jsondata["success"] = false;
		die("Errormessage: ". $mysqlCon->error);
	}
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}
?>