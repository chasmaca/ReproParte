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
		mostrarListadoGlobalValidador($periodo,$departamento,$subdepartamento,$tipoInforme);
	else
		mostrarListadoDetalleValidador($periodo,$departamento,$subdepartamento,$tipoInforme);
}else{
	echo "No se han recogido los parametros";
}

function mostrarListadoGlobalValidador($periodo,$departamento,$subdepartamento,$tipoInforme){
	$usuario = $_SESSION["userId_session"];
	
	global $recuperaInformeGlobalValida, $mysqlCon;
	
	/*definimos el json*/
	$usuario = $_SESSION["userId_session"];

	header("Content-Disposition: attachment; filename=Informe_Global_Validador.xls");
	header("Content-Type: application/vnd.ms-excel");
	$flag = false;
	
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
	
		$recuperaValidadorGlobal =
		"SELECT
			sd1.treintabarra AS esb,de1.ceco AS codigo,de1.departamentos_desc AS departamento,sd1.subdepartamento_desc AS subdepartamento,SUM(t1.precioEncuadernacion) AS encuadernacion,SUM(t1.precioByN) AS byn,SUM(t1.precioColor) AS color,SUM(t1.PrecioVarios) AS varios
		FROM
			solicitud s1 INNER JOIN trabajo t1 ON s1.solicitud_id = t1.solicitud_id INNER JOIN departamento de1 ON s1.departamento_id = de1.departamento_id INNER JOIN subdepartamento sd1 ON s1.departamento_id = sd1.departamento_id AND s1.subdepartamento_id = sd1.subdepartamento_id
		WHERE
			s1.status_id = 6 AND s1.departamento_id IN(	SELECT ud1.departamento_id FROM usuariodepartamento ud1 WHERE ud1.usuario_id = " . $usuario .") AND MONTH(s1.fecha_validacion) = " .$anioPartido[0]. " AND YEAR(s1.fecha_validacion) = " .$anioPartido[1]. "
		GROUP BY de1.ceco
			UNION
		SELECT
			'IMPRESORA' AS esb, 'IMPRESORA' AS codigo, 'IMPRESORA' AS departamento, 'IMPRESORA' AS subdepartamento, '0' AS encuadernacion, round(sum(byn_total),2) as byn, round(sum(color_total),2)  as color, '0' as varios
		FROM
			gastos_impresora
		WHERE
			departamento_id in (SELECT ud1.departamento_id FROM usuariodepartamento ud1 WHERE ud1.usuario_id = " . $usuario .") AND MONTH(periodo) = " . $anioPartido[0] . " AND YEAR(periodo) = " . $anioPartido[1] . "
		UNION
		SELECT
			'MAQUINA' AS esb, 'MAQUINA' AS codigo, 'MAQUINA' AS departamento, 'MAQUINA' AS subdepartamento, '0' AS encuadernacion, round(sum(byn_total),2) as byn, round(sum(color_total),2)  as color, '0' as varios
		FROM
			gastos_maquina
		WHERE
			departamento_id in (SELECT ud1.departamento_id FROM usuariodepartamento ud1 WHERE ud1.usuario_id = " . $usuario .") AND MONTH(periodo) = " . $anioPartido[0] . " AND YEAR(periodo) = " . $anioPartido[1];
					
		
				
	}else{
		if ($departamento!=0){
			$dpto4Usuario = $departamento;
				
			
			$recuperaValidadorGlobal =
			"SELECT
				sd1.treintabarra AS esb,de1.ceco AS codigo,de1.departamentos_desc AS departamento,sd1.subdepartamento_desc AS subdepartamento,SUM(t1.precioEncuadernacion) AS encuadernacion,SUM(t1.precioByN) AS byn,SUM(t1.precioColor) AS color,SUM(t1.PrecioVarios) AS varios
			FROM
				solicitud s1 INNER JOIN trabajo t1 ON s1.solicitud_id = t1.solicitud_id INNER JOIN departamento de1 ON s1.departamento_id = de1.departamento_id INNER JOIN subdepartamento sd1 ON s1.departamento_id = sd1.departamento_id AND s1.subdepartamento_id = sd1.subdepartamento_id
			WHERE
				s1.status_id = 6 AND s1.departamento_id IN(" . $dpto4Usuario . ") AND MONTH(s1.fecha_validacion) = " .$anioPartido[0] . " AND YEAR(s1.fecha_validacion) = " . $anioPartido[1] . "
			GROUP BY de1.ceco UNION
			SELECT
				'IMPRESORA' AS esb,'IMPRESORA' AS codigo,'IMPRESORA' AS departamento,'IMPRESORA' AS subdepartamento,'0' AS encuadernacion,round(sum(byn_total),2) as byn,round(sum(color_total),2)  as color,'0' as varios
			FROM
				gastos_impresora
			WHERE
				departamento_id in (" . $dpto4Usuario . ") AND MONTH(periodo) =  " . $anioPartido[0] . "  AND YEAR(periodo) = " . $anioPartido[1] . "
			UNION
			SELECT
				'MAQUINA' AS esb,'MAQUINA' AS codigo,'MAQUINA' AS departamento,'MAQUINA' AS subdepartamento,'0' AS encuadernacion,round(sum(byn_total),2) as byn,round(sum(color_total),2)  as color,'0' as varios
			FROM
				gastos_maquina
			WHERE
				departamento_id in (" . $dpto4Usuario . ") AND MONTH(periodo) =  " .$anioPartido[0] . "  AND YEAR(periodo) = " . $anioPartido[1];
			
		}
	}
	
	$result = mysqli_query($mysqlCon,$recuperaValidadorGlobal);
	

	$totalGrupo = 0;
	while($row = $result->fetch_assoc()) {
		if(!$flag) {
			// display field/column names as first row
			echo implode("\t", array_keys($row)) . "\tSUBTOTAL\r\n";
			$flag = true;
		}
		if ($row!=null){
			//array_walk($row, __NAMESPACE__ . '\cleanData');
			$totalLinea = 0;
			$totalLinea = $row['encuadernacion'] + $row['byn'] + $row['color'] + $row['varios'];
			$totalGrupo = $totalGrupo + $totalLinea;
				
			echo implode("\t", array_values($row)) . "\t".$totalLinea."\r\n";
				
		}
	}
	echo "\t\t\t\t\t\t\tTOTAL\t".$totalGrupo."\r\n";
}


function mostrarListadoDetalleValidador($anio,$dpto,$subdpto,$tipoInforme){

	global $mysqlCon, $recuperaInformeDetalleValida;

	header("Content-Disposition: attachment; filename=Informe_Global_Validador.xls");
	header("Content-Type: application/vnd.ms-excel");
	$flag = false;
	
	
	/*definimos el json*/
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
			'SOLICITUD' as solicitudId,
			'MAQUINA' AS esb,
			'MAQUINA' AS codigo,
			'MAQUINA' AS departamento,
			'MAQUINA' AS subdepartamento,
			'' AS nombre,
			'' AS apellidos,
			'' AS descripcion,
			'' AS fecha,
			'0' AS encuadernacion,
			'0' AS byn,
			'0' AS color,
			'0' AS varios,
			ROUND(BYN_TOTAL,2) AS BYN_MAQUINA,
			ROUND(COLOR_TOTAL,2) AS COLOR_MAQUINA,
			'0' AS BYN_IMPRESORA,
			'0'  AS COLOR_IMPRESORA
			FROM gastos_maquina WHERE departamento_ID IN (".$dpto4Usuario."
			) AND MONTH(PERIODO) = " . $anioPartido[0] . " AND YEAR(PERIODO) = " . $anioPartido[1] . "
			UNION
			SELECT
			'SOLICITUD' as solicitudId,
			'IMPRESORA' AS esb,
			'IMPRESORA' AS codigo,
			'IMPRESORA' AS departamento,
			'IMPRESORA' AS subdepartamento,
			'' AS nombre,
			'' AS apellidos,
			'' AS descripcion,
			'' AS fecha,
			'0' AS encuadernacion,
			'0' AS byn,
			'0' AS color,
			'0' AS varios,
			'0' AS BYN_MAQUINA,
			'0' AS COLOR_MAQUINA,
			ROUND(BYN_TOTAL,2) AS BYN_IMPRESORA,
			ROUND(COLOR_TOTAL,2)  AS COLOR_IMPRESORA
			FROM gastos_impresora WHERE departamento_ID IN (".$dpto4Usuario.") AND MONTH(PERIODO) = " . $anioPartido[0] . " AND YEAR(PERIODO) = " . $anioPartido[1];
	}else{
		if ($dpto != 0){

			$recuperaInformeDetalleValida .= " UNION
				SELECT
				'SOLICITUD' as solicitudId,
				'MAQUINA' AS esb,
				'MAQUINA' AS codigo,
				'MAQUINA' AS departamento,
				'MAQUINA' AS subdepartamento,
				'' AS nombre,
				'' AS apellidos,
				'' AS descripcion,
				'' AS fecha,
				'0' AS encuadernacion,
				'0' AS byn,
				'0' AS color,
				'0' AS varios,
				ROUND(BYN_TOTAL,2) AS BYN_MAQUINA,
				ROUND(COLOR_TOTAL,2) AS COLOR_MAQUINA,
				'0' AS BYN_IMPRESORA,
				'0'  AS COLOR_IMPRESORA
				FROM gastos_maquina WHERE departamento_ID IN (".$dpto."
						) AND MONTH(PERIODO) = " . $anioPartido[0] . " AND YEAR(PERIODO) = " . $anioPartido[1] . "
						UNION
						SELECT
						'SOLICITUD' as solicitudId,
						'IMPRESORA' AS esb,
						'IMPRESORA' AS codigo,
						'IMPRESORA' AS departamento,
						'IMPRESORA' AS subdepartamento,
						'' AS nombre,
						'' AS apellidos,
						'' AS descripcion,
						'' AS fecha,
						'0' AS encuadernacion,
						'0' AS byn,
						'0' AS color,
						'0' AS varios,
						'0' AS BYN_MAQUINA,
						'0' AS COLOR_MAQUINA,
						ROUND(BYN_TOTAL,2) AS BYN_IMPRESORA,
						ROUND(COLOR_TOTAL,2)  AS COLOR_IMPRESORA
						FROM gastos_impresora WHERE departamento_ID IN (".$dpto.") AND MONTH(PERIODO) = " . $anioPartido[0] . " AND YEAR(PERIODO) = " . $anioPartido[1];
		}
	}

	$informeResult = mysqli_query($mysqlCon,$recuperaInformeDetalleValida);


	$totalGrupo = 0;
	while($row = $informeResult->fetch_assoc()) {
		
		if(!$flag) {
			// display field/column names as first row
			echo implode("\t", array_keys($row)) . "\tSUBTOTAL\r\n";
			$flag = true;
		}
		
		if ($row!=null){
			$totalLinea = 0;
			$totalLinea = $row['encuadernacion'] + $row['byn'] + $row['color'] + $row['varios']+$row['BYN_MAQUINA']+$row['COLOR_MAQUINA']+
					$row['BYN_IMPRESORA']+$row['COLOR_IMPRESORA'];
			$totalGrupo = $totalGrupo + $totalLinea;
	
			filter_array_empty_value($row);
			echo $totalLinea."\r\n";
		}
	}

	echo "TOTAL:\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t".$totalGrupo."\r\n";
		
}

function filter_array_empty_value($arr){
	foreach($arr as $k=>$v){

		$v = str_replace("\n","",$v);
		$v = str_replace(","," ",$v);
		$v = trim($v);

		echo $v."\t";

	}

	return $arr;
}
