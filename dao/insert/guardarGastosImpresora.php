<?php
include_once 'inserciones.php';
include_once '../select/query.php';
include_once '../update/updates.php';
include '../../utiles/connectDBUtiles.php';

	//Declaracion de parametros
	/*Parametros que nos llega en la request*/
	$periodo = "";
	$departamento = "";
	$unidades = "";
	$precio = "";
	$total = "";
	$tipo = "";
	
	/*Parametros para el tratamiento del periodo*/
	$mes = "";
	$anio = "";
	$fecha = "";
	
	/*JSON de vuelta*/
	$jsondata = "";
	

	//Recogemos los valores
	if( isset($_GET['periodo'])) {
		$periodo = $_GET['periodo'];
	}

	if( isset($_GET['departamento'])) {
		$departamento = $_GET['departamento'];
	}
	
	if( isset($_GET['unidades'])) {
		$unidades = $_GET['unidades'];
	}
	
	if( isset($_GET['precio'])) {
		$precio = $_GET['precio'];
	}
	
	if( isset($_GET['total'])) {
		$total = $_GET['total'];
	}
	
	if( isset($_GET['tipo'])) {
		$tipo = $_GET['tipo'];
	}
	
	if ($periodo != "" && $departamento != "" && $unidades != "" && $precio != "" && $total != ""  && $tipo != ""){
		
		$mes = substr($periodo, 0, strpos($periodo,"/"));
		$anio = substr($periodo, strpos($periodo,"/")+1, strlen($periodo));
		
		$fecha = $anio.'-'.$mes.'-01 23:59:00';
		
		if ($tipo == 'Color')
			insertamosGastosColor($departamento,$unidades,$precio,$total);
		else
			insertamosGastosByN($departamento,$unidades,$precio,$total);
	
	} else {
		die("Debe Cumplimentar correctamente los campos.");
	}

	
	
	/**
	 * Insertamos Gastos de ByN por departamento y periodo
	 * @param Timestamp $periodo
	 * @param Integer $departamento
	 * @param Integer $unidades
	 * @param Float $precio
	 * @param Float $total
	 */
	function insertamosGastosByN($departamento,$unidades,$precio,$total){
		
		global $mysqlCon,$sentenciaInsertGastosImpresora,$mes,$anio,$fecha,$jsondata;
		
		$unidadesColor = 0;
		$precioColor = 0;
		$totalColor = 0;

		/**
		 * Comprobamos si existe el registro para realizar la insercion o la actualizacion.
		 * Si existeRegistro devuelve true se realiza la insercion.
		 * Si existeRegistro devuelve false se realiza una actualizacion.
		 */
		if (existeRegistro($departamento, $anio,$mes)){
			if ($stmt = $mysqlCon->prepare($sentenciaInsertGastosImpresora)) {
				$stmt->bind_param('isiddidd',$departamento,$fecha,$unidades,$precio,$total,$unidadesColor,$precioColor,$totalColor);

				if (!$stmt->execute()) {
					$jsondata["success"] = false;
					echo "Falló la ejecución: (" . $sentenciaInsertGastosImpresora->errno . ") " . $sentenciaInsertGastosImpresora->error;
				}else{
					$jsondata["success"] = true;
				}

			} else {
				$jsondata["success"] = false;
				die("Errormessage: ". $mysqlCon->error);
			}
		}else{
			actualizamosGastosByN($departamento,$unidades,$precio,$total, $anio,$mes);
			exit;
		}
		
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata["success"], JSON_FORCE_OBJECT);
	}
	
	/**
	 * Actualizamos los gastos de Blanco y Negro por departamento y por periodo.
	 * @param Timestamp $periodo
	 * @param Integer $departamento
	 * @param Integer $unidades
	 * @param Float $precio
	 * @param Float $total
	 */
	function actualizamosGastosByN($departamento,$unidades,$precio,$total, $anio,$mes){
		
		global $mysqlCon,$sentenciaUpdateGastosImpresoraByN,$jsondata;

		if ($stmt = $mysqlCon->prepare($sentenciaUpdateGastosImpresoraByN)) {
			$stmt->bind_param('iddiss',$unidades,$precio,$total,$departamento,$anio,$mes);
				
			if (!$stmt->execute()) {
				$jsondata["success"] = false;
				echo "Falló la ejecución: (" . $sentenciaUpdateGastosImpresoraByN->errno . ") " . $sentenciaUpdateGastosImpresoraByN->error;
			}else{
				$jsondata["success"] = true;
			}
		
		} else {
			$jsondata["success"] = false;
			die("Errormessage: ". $mysqlCon->error);
		}
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
	}
	
	/**
	 * Insertamos los gastos de Color por departamento y periodo
	 * @param Timestamp $periodo
	 * @param Integer $departamento
	 * @param Integer $unidades
	 * @param Float $precio
	 * @param Float $total
	 */
	function insertamosGastosColor($departamento,$unidades,$precio,$total){
	
		global $mysqlCon,$sentenciaInsertGastosImpresora,$mes,$anio,$fecha,$jsondata;
		
		$unidadesByN = 0;
		$precioByN = 0;
		$totalByN = 0;
		
		/**
		 * Comprobamos si existe el registro para realizar la insercion o la actualizacion.
		 * Si existeRegistro devuelve true se realiza la insercion.
		 * Si existeRegistro devuelve false se realiza una actualizacion.
		 */
		if (existeRegistro($departamento, $anio,$mes)){
			if ($stmt = $mysqlCon->prepare($sentenciaInsertGastosImpresora)) {
				$stmt->bind_param('isiddidd',$departamento,$fecha,$unidadesByN,$precioByN,$totalByN,$unidades,$precio,$total);
		
				if (!$stmt->execute()) {
					$jsondata["success"] = false;
					echo "Falló la ejecución: (" . $sentenciaInsertGastosImpresora->errno . ") " . $sentenciaInsertGastosImpresora->error;
				}else{
					$jsondata["success"] = true;
				}
				$stmt->close();
		
			} else {
				$jsondata["success"] = false;
				die("Errormessage: ". $mysqlCon->error);
			}
		}else{
			actualizamosGastosColor($departamento,$unidades,$precio,$total,$anio,$mes);
			exit;
		}
		
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
	}
	
	/**
	 * Actualizamos los gastos de Color por departamento y por periodo.
	 * @param Timestamp $periodo
	 * @param Integer $departamento
	 * @param Integer $unidades
	 * @param Float $precio
	 * @param Float $total
	 */
	function actualizamosGastosColor($departamento,$unidades,$precio,$total,$anio,$mes){
		
		global $mysqlCon,$sentenciaUpdateGastosImpresoraColor,$jsondata;
		
		if ($stmt = $mysqlCon->prepare($sentenciaUpdateGastosImpresoraColor)) {
			$stmt->bind_param('iddiss',$unidades,$precio,$total,$departamento,$anio,$mes);
		
			if (!$stmt->execute()) {
				$jsondata["success"] = false;
				echo "Falló la ejecución: (" . $sentenciaUpdateGastosImpresoraColor->errno . ") " . $sentenciaUpdateGastosImpresoraColor->error;
			}else{
				$jsondata["success"] = true;
			}
		
		} else {
			$jsondata["success"] = false;
			die("Errormessage: ". $mysqlCon->error);
		}
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
	}
	
	/**
	 * Comprobamos si existe un reistro para ese departamento y ese periodo 
	 * y devuelve true si no existe y false si existe
	 * @param Integer $departamento
	 * @return boolean
	 */
	function existeRegistro($departamento,$anio,$mes){
		
		global $mysqlCon,$existeGastoImpresora;
		$insertamos = true;

		/*Prepare Statement*/
		if ($stmt = $mysqlCon->prepare($existeGastoImpresora)) {
			/*Asociacion de parametros*/
			$stmt->bind_param('iss',$departamento,$anio,$mes);
			/*Ejecucion*/
			$stmt->execute();
			
			$stmt->store_result();
			$row_cnt = $stmt->num_rows;

			if ($row_cnt>0) 
				$insertamos = false;
			
			/*Cerramos la conexion*/
			$stmt->close();
		}else{
			echo $stmt->error;
		}

		return $insertamos;
	}
	
?>