<?php
session_start();
include ('query.php');
include '../../utiles/connectDBUtiles.php';
include 'departamentoAutorizador.php';
include ('subdepartamento.php');

/*Definimos las variables*/
$periodo = "";
$departamento = "";
$subdepartamento = "";
$tipoInforme = "";

/*definimos el json*/
$jsondata = array();
$jsondata["data"] = array();

/*Recuperamos la request*/
if( isset($_GET['periodo'])) {
	$periodo = $_GET['periodo'];
}

if( isset($_GET['departamento'])) {
	$departamento = $_GET['departamento'];
}

if( isset($_GET['subdepartamento'])) {
	$subdepartamento = $_GET['subdepartamento'];
}

if( isset($_GET['tipoInforme'])) {
	$tipoInforme = $_GET['tipoInforme'];
}

/*Realizamos la llamada a la funcion*/
if ($periodo != "" && $departamento != "" && $subdepartamento != "" && $tipoInforme != ""){

	if ($tipoInforme == 'global')
		recuperaListadoGlobalValidador($periodo,$departamento,$subdepartamento,$tipoInforme);
	else
		recuperaListadoDetalleValidador($periodo,$departamento,$subdepartamento,$tipoInforme);
}

/**
 * @param unknown $periodo
 * @param unknown $departamento
 * @param unknown $subdepartamento
 * @param unknown $tipoInforme
 */
function recuperaListadoGlobalValidador($periodo,$departamento,$subdepartamento,$tipoInforme){

	$usuario = $_SESSION["userId_session"];
	
	global $recuperaInformeGlobalValida, $mysqlCon;

	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();
	
	$anioPartido = explode("/",$periodo);
	
	if ($departamento == 'aa'){
		$departamento = '%';
		$subdepartamento = '%';
	}
	
	if ($subdepartamento == 'aa'){
		$subdepartamento = '%';
	}
	
	
	if ($departamento == "%"){
	
		$dpto4Usuario = cargarDptoSessionAsArray($usuario);
		
		global $recuperaValidadorGlobalTodosDpto;
		
		/*Prepare Statement*/
		if ($stmt = $mysqlCon->prepare($recuperaValidadorGlobalTodosDpto)) {
		
			/*Asociacion de parametros*/
			$stmt->bind_param('issississ',$usuario,$anioPartido[0],$anioPartido[1],$usuario,$anioPartido[0],$anioPartido[1],$usuario,$anioPartido[0],$anioPartido[1]);
		
			/*Ejecucion*/
			$stmt->execute();
				
			/*Almacenamos el resultSet*/
			$stmt->bind_result($esb, $codigo, $departamento, $subdepartamento,$encuadernacion,$byn,$color,$varios);
				
			/*Incluimos las lineas de la consulta en el json a devolver*/
			while($stmt->fetch()) {
				$tmp = array();
				$tmp["esb"] = $esb;
				$tmp["codigo"] = $codigo;
				$tmp["departamento"] = utf8_decode($departamento);
				$tmp["subdepartamento"] = utf8_decode($subdepartamento);
				$tmp["encuadernacion"] = $encuadernacion;
				$tmp["byn"] = $byn;
				$tmp["color"] = $color;
				$tmp["varios"] =$varios;
			
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
			
	}else{
		if ($departamento!=0){
			$dpto4Usuario = $departamento;
			
			global $recuperaValidadorGlobalPorDpto; 
			
			/*Prepare Statement*/
			if ($stmt = $mysqlCon->prepare($recuperaValidadorGlobalPorDpto)) {
			
				/*Asociacion de parametros*/
				$stmt->bind_param('issississ',$departamento,$anioPartido[0],$anioPartido[1],$departamento,$anioPartido[0],$anioPartido[1],$departamento,$anioPartido[0],$anioPartido[1]);
			
				/*Ejecucion*/
				$stmt->execute();
			
				/*Almacenamos el resultSet*/
				$stmt->bind_result($esb, $codigo, $departamento, $subdepartamento,$encuadernacion,$byn,$color,$varios);
			
				/*Incluimos las lineas de la consulta en el json a devolver*/
				while($stmt->fetch()) {
					$tmp = array();
					$tmp["esb"] = $esb;
					$tmp["codigo"] = $codigo;
					$tmp["departamento"] = utf8_decode($departamento);
					$tmp["subdepartamento"] = utf8_decode($subdepartamento);
					$tmp["encuadernacion"] = $encuadernacion;
					$tmp["byn"] = $byn;
					$tmp["color"] = $color;
					$tmp["varios"] =$varios;

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
		}
	}

	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	
}

/**
 * 
 * @param unknown $periodo
 * @param unknown $departamento
 * @param unknown $subdepartamento
 * @param unknown $tipoInforme
 */
function recuperaListadoDetalleValidador($anio,$dpto,$subdpto,$tipoInforme){

	global $mysqlCon, $recuperaInformeDetalleValida;
	
	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();
	$usuario = $_SESSION["userId_session"];
	
	$anioPartido = explode("/",$anio);

	$recuperaInformeDetalleValida .= $usuario . ")";
	
	if ($dpto == "aa"){
	
		$dpto4Usuario = cargarDptoSessionAsArray($usuario);
	
		$recuperaInformeDetalleValida .= " and s1.departamento_id in (" . $dpto4Usuario . ") ";
	
	}else{
	
		if ($dpto != 0){
	
			$recuperaInformeDetalleValida .= " and s1.departamento_id = " . $dpto;
	
			if ($subdpto == "aa"){
	
				$subdpto4Usuario = cargarSubDptoXDptoAsArray($usuario, $dpto);
	
				$recuperaInformeDetalleValida = $recuperaInformeDetalleValida . " and s1.subdepartamento_id in (" . $subdpto4Usuario . ") ";
	
			}else{
	
				if ($subdpto != 0){
	
					$recuperaInformeDetalleValida = $recuperaInformeDetalleValida . " and s1.subdepartamento_id = " . $subdpto;
				}
			}
		}
	}
	
	$recuperaInformeDetalleValida .= " and month(s1.fecha_validacion) = " . $anioPartido[0] .
	" and year(s1.fecha_validacion) = " . $anioPartido[1];
	
	if ($dpto == "aa"){
	
		$dpto4Usuario = cargarDptoSessionAsArray($usuario);
	
	
		$recuperaInformeDetalleValida .= " UNION
			SELECT
			'0' as solicitudId,
			'MAQUINA' AS esb,
			'MAQUINA' AS codigo,
			'MAQUINA' AS departamento,
			'MAQUINA' AS subdepartamento,
			'' AS fecha,
			'0' AS encuadernacion,
			'0' AS byn,
			'0' AS color,
			'0' AS varios,
			'' AS nombre,
			'' AS apellidos,
			'' AS descripcion,
			ROUND(BYN_TOTAL,2) AS BYN_MAQUINA,
			ROUND(COLOR_TOTAL,2) AS COLOR_MAQUINA,
			'0' AS BYN_IMPRESORA,
			'0'  AS COLOR_IMPRESORA
			FROM gastos_maquina WHERE departamento_ID IN (".$dpto4Usuario."
			) AND MONTH(PERIODO) = " . $anioPartido[0] . " AND YEAR(PERIODO) = " . $anioPartido[1] . "
			UNION
			SELECT
			'0' as solicitudId,
			'IMPRESORA' AS esb,
			'IMPRESORA' AS codigo,
			'IMPRESORA' AS departamento,
			'IMPRESORA' AS subdepartamento,
			'' AS fecha,
			'0' AS encuadernacion,
			'0' AS byn,
			'0' AS color,
			'0' AS varios,
			'' AS nombre,
			'' AS apellidos,
			'' AS descripcion,
			'0' AS BYN_MAQUINA,
			'0' AS COLOR_MAQUINA,
			ROUND(BYN_TOTAL,2) AS BYN_IMPRESORA,
			ROUND(COLOR_TOTAL,2)  AS COLOR_IMPRESORA
			FROM gastos_impresora WHERE departamento_ID IN (".$dpto4Usuario.") AND MONTH(PERIODO) = " . $anioPartido[0] . " AND YEAR(PERIODO) = " . $anioPartido[1];
	}else{
		if ($dpto != 0){

			$recuperaInformeDetalleValida .= " UNION
				SELECT
				'0' as solicitudId,
				'MAQUINA' AS esb,
				'MAQUINA' AS codigo,
				'MAQUINA' AS departamento,
				'MAQUINA' AS subdepartamento,
				'' AS fecha,
				'0' AS encuadernacion,
				'0' AS byn,
				'0' AS color,
				'0' AS varios,
				'' AS nombre,
				'' AS apellidos,
				'' AS descripcion,
				ROUND(BYN_TOTAL,2) AS BYN_MAQUINA,
				ROUND(COLOR_TOTAL,2) AS COLOR_MAQUINA,
				'0' AS BYN_IMPRESORA,
				'0'  AS COLOR_IMPRESORA
				FROM gastos_maquina WHERE departamento_ID IN (".$dpto."
						) AND MONTH(PERIODO) = " . $anioPartido[0] . " AND YEAR(PERIODO) = " . $anioPartido[1] . "
						UNION
						SELECT
						'0' as solicitudId,
						'IMPRESORA' AS esb,
						'IMPRESORA' AS codigo,
						'IMPRESORA' AS departamento,
						'IMPRESORA' AS subdepartamento,
						'' AS fecha,
						'0' AS encuadernacion,
						'0' AS byn,
						'0' AS color,
						'0' AS varios,
						'' AS nombre,
						'' AS apellidos,
						'' AS descripcion,
						'0' AS BYN_MAQUINA,
						'0' AS COLOR_MAQUINA,
						ROUND(BYN_TOTAL,2) AS BYN_IMPRESORA,
						ROUND(COLOR_TOTAL,2)  AS COLOR_IMPRESORA
						FROM gastos_impresora WHERE departamento_ID IN (".$dpto.") AND MONTH(PERIODO) = " . $anioPartido[0] . " AND YEAR(PERIODO) = " . $anioPartido[1];
		}
	}

	//Write action to txt log
	$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
	"Solicitud: ".$recuperaInformeDetalleValida.PHP_EOL.
	
	"-------------------------".PHP_EOL;
	//-
	//file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
	
	error_log($log, 3, "../../log/query.log");
	
	$informeResult = mysqli_query($mysqlCon,$recuperaInformeDetalleValida);

	if (!$informeResult) {
		/*Llegamos aqui con error, asociamos false para identificarlo en el js*/
		$jsondata["success"] = false;
		die("Errormessage: ". $mysqlCon->error);

		echo "No se pudo ejecutar con exito la consulta ($recuperaInformeDetalleValida) en la BD: " . mysql_error();
		exit;

	} else {

		while($row=mysqli_fetch_array($informeResult)){
			$tmp = array();
			$tmp["solicitudId"] = $row['solicitudId'];
			$tmp["esb"] = $row['esb'];
			$tmp["codigo"] = $row['codigo'];
			$tmp["departmento"] = utf8_encode($row['departamento']);
			$tmp["subdepartmento"] =  utf8_encode($row['subdepartamento']);
			$tmp["fecha"] = $row['fecha'];
			$tmp["encuadernacion"] = $row['encuadernacion'];
			$tmp["byn"] = $row['byn'];
			$tmp["color"] = $row['color'];
			$tmp["varios"] = $row['varios'];
			$tmp["nombre"] =  utf8_encode($row['nombre']);
			$tmp["apellidos"] =  utf8_encode($row['apellidos']);
			$tmp["descripcion"] =  utf8_encode($row['descripcion']);
			$tmp["byn_maquina"] = $row['BYN_MAQUINA'];
			$tmp["color_maquina"] = $row['COLOR_MAQUINA'];
			$tmp["byn_impresora"] = $row['BYN_IMPRESORA'];
			$tmp["color_impresora"] = $row['COLOR_IMPRESORA'];

			/*Asociamos el resultado en forma de array en el json*/
			array_push($jsondata["data"], $tmp);

		}
		/*Asociamos el correcto funcionamiento al json para comprobar en el js*/
		$jsondata["success"] = true;
	}

	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);

}
