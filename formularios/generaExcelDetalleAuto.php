<?php
session_start();
include ('../dao/select/query.php');
include '../utiles/connectDBUtiles.php';
include ('../dao/select/departamentoAutorizador.php');

/*Definimos las variables*/
$periodo = "";
$departamento = "";
$subdepartamento = "";
$tipoInforme = "";

$usuario = $_SESSION["userId_session"];

/*Recuperamos la request*/
if( isset($_POST['periodo'])) {
	$periodo = $_POST['periodo'];
}

if( isset($_POST['departamento'])) {
	$departamento = $_POST['departamento'];
}

if( isset($_POST['subdepartamento'])) {
	$subdepartamento = $_POST['subdepartamento'];
}

if( isset($_POST['tipoInforme'])) {
	$tipoInforme = $_POST['tipoInforme'];
}

/*Realizamos la llamada a la funcion*/
if ($periodo != "" && $departamento != "" && $subdepartamento != "" && $tipoInforme != ""){

	if ($tipoInforme == 'global')
		recuperaGlobalMesValidadorExcel($usuario, $periodo, $departamento, $subdepartamento);
	else
		recuperaDetalleMesValidadorExcel($mysqlCon,$usuario,$periodo,$departamento,$subdepartamento);

}else{
	echo "No se han recogido los parametros";
}

/**
 * Funcion que recupera de bbdd todos los datos del informe global que este solicitando el usuario Gestor
 * @param  $periodo
 * @param  $departamento
 * @param  $subdepartamento
 * @param  $tipoInforme
 */
function recuperaGlobalMesValidadorExcel($usuario, $anio, $dpto, $subdpto){

	global $mysqlCon, $recuperaInformeGlobalValida;
	

	header("Content-Disposition: attachment; filename=Informe_Global_Gestor.xls");
	header("Content-Type: application/vnd.ms-excel");
	$flag = false;
	
	$anioPartido = explode("/",$anio);
	
	if ($dpto == "aa"){
	
		$dpto4Usuario = cargarDptoSessionAsArray($usuario);
		$recuperaInformeGlobalValida="
			SELECT
			sd1.treintabarra AS esb,
			de1.ceco AS codigo,
			de1.departamentos_desc AS departamento,
			sd1.subdepartamento_desc AS subdepartamento,
			SUM(t1.precioEncuadernacion) AS encuadernacion,
			SUM(t1.precioByN) AS byn,
			SUM(t1.precioColor) AS color,
			SUM(t1.PrecioVarios) AS varios
			FROM
			solicitud s1
			INNER JOIN
			trabajo t1 ON s1.solicitud_id = t1.solicitud_id
			INNER JOIN
			departamento de1 ON s1.departamento_id = de1.departamento_id
			INNER JOIN
			subdepartamento sd1 ON s1.departamento_id = sd1.departamento_id AND s1.subdepartamento_id = sd1.subdepartamento_id
			WHERE
			s1.status_id = 6 AND s1.departamento_id IN(
					SELECT
					ud1.departamento_id
					FROM
					usuariodepartamento ud1
					WHERE
					ud1.usuario_id = ".$usuario."
					)  AND MONTH(s1.fecha_validacion) = " . $anioPartido[0] . " AND YEAR(s1.fecha_validacion) = ". $anioPartido[1] ."
					GROUP BY
					de1.ceco UNION
			SELECT
				'IMPRESORA' AS esb,
				'IMPRESORA' AS codigo,
				'IMPRESORA' AS departamento,
				'IMPRESORA' AS subdepartamento,
				'0' AS encuadernacion,
				round(sum(byn_total),2) as byn,
				round(sum(color_total),2)  as color,
				'0' as varios from gastos_impresora where departamento_id in (SELECT ud1.departamento_id FROM usuariodepartamento ud1 WHERE ud1.usuario_id = ".$usuario.") AND MONTH(periodo) = " . $anioPartido[0] . " AND YEAR(periodo) = ". $anioPartido[1] ." UNION
				SELECT
				'MAQUINA' AS esb,
				'MAQUINA' AS codigo,
				'MAQUINA' AS departamento,
				'MAQUINA' AS subdepartamento,
				'0' AS encuadernacion,
				round(sum(byn_total),2) as byn,
				round(sum(color_total),2)  as color,
				'0' as varios from gastos_maquina where departamento_id in (SELECT ud1.departamento_id FROM usuariodepartamento ud1 WHERE ud1.usuario_id = ".$usuario.") AND MONTH(periodo) = " . $anioPartido[0] . " AND YEAR(periodo) = ". $anioPartido[1];;
	
	}else{
		if ($dpto!=0){
			$dpto4Usuario = $dpto;
			$recuperaInformeGlobalValida="
				SELECT
				sd1.treintabarra AS esb,
				de1.ceco AS codigo,
				de1.departamentos_desc AS departamento,
				sd1.subdepartamento_desc AS subdepartamento,
				SUM(t1.precioEncuadernacion) AS encuadernacion,
				SUM(t1.precioByN) AS byn,
				SUM(t1.precioColor) AS color,
				SUM(t1.PrecioVarios) AS varios
				FROM
				solicitud s1
				INNER JOIN
				trabajo t1 ON s1.solicitud_id = t1.solicitud_id
				INNER JOIN
				departamento de1 ON s1.departamento_id = de1.departamento_id
				INNER JOIN
				subdepartamento sd1 ON s1.departamento_id = sd1.departamento_id AND s1.subdepartamento_id = sd1.subdepartamento_id
				WHERE
				s1.status_id = 6 AND s1.departamento_id IN(".$dpto.")  AND MONTH(s1.fecha_validacion) = " . $anioPartido[0] . " AND YEAR(s1.fecha_validacion) = ". $anioPartido[1] ."
						GROUP BY
						de1.ceco UNION
				SELECT
				'IMPRESORA' AS esb,
				'IMPRESORA' AS codigo,
				'IMPRESORA' AS departamento,
				'IMPRESORA' AS subdepartamento,
				'0' AS encuadernacion,
				round(sum(byn_total),2) as byn,
				round(sum(color_total),2)  as color,
				'0' as varios from gastos_impresora where departamento_id in (".$dpto.") AND MONTH(periodo) = " . $anioPartido[0] . " AND YEAR(periodo) = ". $anioPartido[1] ." UNION
				SELECT
				'MAQUINA' AS esb,
				'MAQUINA' AS codigo,
				'MAQUINA' AS departamento,
				'MAQUINA' AS subdepartamento,
				'0' AS encuadernacion,
				round(sum(byn_total),2) as byn,
				round(sum(color_total),2)  as color,
				'0' as varios from gastos_maquina where departamento_id in (".$dpto.") AND MONTH(periodo) = " . $anioPartido[0] . " AND YEAR(periodo) = ". $anioPartido[1];
	
		}
	}
	
	//INCLUIMOS MAQUINAS E IMPRESORAS
	$informeResult = mysqli_query($mysqlCon,$recuperaInformeGlobalValida);
	
	if (!$informeResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaInformeGlobalValida) en la BD: " . mysql_error();
		exit;
	}
	
	while($row = $informeResult->fetch_assoc()) {
		if(!$flag) {
			// display field/column names as first row
			echo implode("\t", array_keys($row)) . "\r\n";
			$flag = true;
		}
		if ($row!=null){
			//array_walk($row, __NAMESPACE__ . '\cleanData');
			echo implode("\t", array_values($row)) . "\r\n";
		}
	}
}

/**
 * Funcion que recupera de bbdd todos los datos del informe detalle que este solicitando el usuario Gestor
 * @param $periodo
 * @param $departamento
 * @param $subdepartamento
 * @param $tipoInforme
 */
function recuperaDetalleMesValidadorExcel($periodo,$departamento,$subdepartamento,$tipoInforme){
	global $mysqlCon, $recuperaInformeDetalleValida;
	

	header("Content-Disposition: attachment; filename=Informe_Global_Gestor.xls");
	header("Content-Type: application/vnd.ms-excel");
	$flag = false;
	
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
	
	$informeResult = mysqli_query($mysqlCon,$recuperaInformeDetalleValida);
	
	while($row = $informeResult->fetch_assoc()) {
		if(!$flag) {
			// display field/column names as first row
			echo implode("\t", array_keys($row)) . "\r\n";
			$flag = true;
		}
		if ($row!=null){
			//array_walk($row, __NAMESPACE__ . '\cleanData');
			echo implode("\t", array_values($row)) . "\r\n";
		}
	}
}

?>