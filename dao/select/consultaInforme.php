<?php

include ('query.php');
include ('departamentoAutorizador.php');
include ('subdepartamento.php');

function recuperaInformes($mysqlCon){

	global $generaInforme;

	$informeResult = mysqli_query($mysqlCon,$generaInforme);

	if (!$informeResult) {
		echo "No se pudo ejecutar con exito la consulta ($generaInforme) en la BD: " . mysql_error();
		exit;
	}

	return $informeResult;
}

function recuperaInformesMesAdminConsulta($mysqlCon, $anio, $dpto,$subdpto){

	global $generaInformeMes;

	$anioPartido = explode("/",$anio);

	$generaInformeMes = $generaInformeMes . $anioPartido[1] . " and month(s1.fecha_cierre) = " . $anioPartido[0];

	if ($dpto != 0 && $dpto != "aa")
		$generaInformeMes = $generaInformeMes . " and s1.departamento_id = " . $dpto;

		
	
	$resumentSub = "";
	if ($subdpto == "aa"){
		if ($dpto =="aa"){
			
		}else{

			$subdepartamentoList = recuperaSubXDpto($dpto);
			//	$subdpto4Usuario = cargarDptoSessionAsArray($usuario);
			for ($row = 0; $row < sizeof($subdepartamentoList); $row++){
				if ($resumentSub=="")
					$resumentSub = $subdepartamentoList[$row][1];
				else
					$resumentSub = $resumentSub . "," . $subdepartamentoList[$row][1];
			
			}
			$generaInformeMes = $generaInformeMes . " and s1.subdepartamento_id in (" . $resumentSub . ") ";
				
		}
		
	}else{
		
		if ($subdpto!=0)
		$generaInformeMes = $generaInformeMes . " and s1.subdepartamento_id = " . $subdpto;

	}
	
	if ($dpto =="aa"){
		$generaInformeMes .= " UNION
		select
		'treintabarra' as codigo, 'ceco',
		i.departamento_id, concat('Impresoras ', d1.departamentos_desc)  as 'Impresoras', i.periodo,
		ROUND(byn_total,2) as byn, ROUND(color_total,2) as color,
		0 as encuadernacion,
		0 as varios,
		'Impresoras' as subdepartamentos_desc,
		'' as descripcion,
		'' as nombre,
		'' as apellido
		from gastos_impresora i inner join departamento d1 on i.departamento_id=d1.departamento_id  where YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) = " . $anioPartido[0];

		$generaInformeMes .= " UNION
		select
		'treintabarraMaq' as codigo, 'ceco',
		i.departamento_id, concat('Maquinas ', d1.departamentos_desc)  as Maquinas, i.periodo,
		ROUND(byn_total,2) as byn, ROUND(color_total,2) as color,
		0 as encuadernacion,
		0 as varios,
		'Maquinas' as subdepartamentos_desc,
		'' as descripcion,
		'' as nombre,
		'' as apellido
		from gastos_maquina i inner join departamento d1 on i.departamento_id=d1.departamento_id where YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) =  " . $anioPartido[0];

	}else{
		$generaInformeMes .= " UNION
		select
		'treintabarra' as codigo, 'ceco',
		i.departamento_id, 'Impresoras', i.periodo,
		ROUND(byn_total,2) as byn, ROUND(color_total,2) as color,
		0 as encuadernacion,
		0 as varios,
		'Impresoras' as subdepartamentos_desc,
		'' as descripcion,
		'' as nombre,
		'' as apellido
		from gastos_impresora i where i.departamento_id = " . $dpto ." and YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) = " . $anioPartido[0];
			
		$generaInformeMes .= " UNION
		select
		'treintabarraMaq' as codigo, 'ceco',
		i.departamento_id, 'Maquinas', i.periodo,
		ROUND(byn_total,2) as byn, ROUND(color_total,2) as color,
		0 as encuadernacion,
		0 as varios,
		'Maquinas' as subdepartamentos_desc,
		'' as descripcion,
		'' as nombre,
		'' as apellido
		from gastos_maquina i where i.departamento_id = " . $dpto ." and YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) = " . $anioPartido[0];
		
	}
//	$generaInformeMes .= " order by codigo";
	
	$informeResult = mysqli_query($mysqlCon,$generaInformeMes);

	if (!$informeResult) {
		echo "No se pudo ejecutar con exito la consulta ($generaInformeMes) en la BD: " . mysql_error();
		exit;
	}

	return $informeResult;
}

function recuperaInformesMes($mysqlCon, $anio, $dpto,$subdpto){

	global $generaInformeMes;
	
	$anioPartido = explode("/",$anio);
	
	$generaInformeMes = $generaInformeMes . $anioPartido[1] . " and month(s1.fecha_cierre) = " . $anioPartido[0];

	if ($dpto != 0 && $dpto != "aa")
		$generaInformeMes = $generaInformeMes . " and s1.departamento_id = " . $dpto;
	
	$resumentSub = "";
	if ($subdpto == "aa"){
	
		$subdepartamentoList = recuperaSubXDpto($dpto);

		for ($row = 0; $row < sizeof($subdepartamentoList); $row++){
			if ($resumentSub=="")
				$resumentSub = $subdepartamentoList[$row][1];
			else
				$resumentSub = $resumentSub . "," . $subdepartamentoList[$row][1];
				
		}
		
		
		$generaInformeMes = $generaInformeMes . " and s1.subdepartamento_id in (" . $resumentSub . ") ";
	
	}else{
	
		$generaInformeMes = $generaInformeMes . " and s1.subdepartamento_id = " . $subdpto;
	
	}

	$informeResult = mysqli_query($mysqlCon,$generaInformeMes);

	if (!$informeResult) {
		echo "No se pudo ejecutar con exito la consulta ($generaInformeMes) en la BD: " . mysql_error();
		exit;
	}

	return $informeResult;
}

function recuperaInformesMesGestores($mysqlCon, $anio, $dpto, $subdpto){

	global $generaInformeMes;

	$anioPartido = explode("/",$anio);

	$generaInformeMes = $generaInformeMes . $anioPartido[1] . " and month(s1.fecha_cierre) = " . $anioPartido[0];

	if ($dpto != 0 && $dpto != "aa")
		$generaInformeMes = $generaInformeMes . " and s1.departamento_id = " . $dpto;

		$resumentSub = "";
		if ($subdpto == "aa"){

			

		}else{

			$generaInformeMes = $generaInformeMes . " and s1.subdepartamento_id = " . $subdpto;

		}
		
		$informeResult = mysqli_query($mysqlCon,$generaInformeMes);

		if (!$informeResult) {
			echo "No se pudo ejecutar con exito la consulta ($generaInformeMes) del metodo recuperaInformesMesGestores en la BD: " . mysql_error();
			exit;
		}

		return $informeResult;
}

function recuperaInformesGlobal($mysqlCon){

	global $generaInformeGlobal;

	$informeGlobalResult = mysqli_query($mysqlCon,$generaInformeGlobal);

	if (!$informeGlobalResult) {
		echo "No se pudo ejecutar con exito la consulta ($generaInformeGlobal) en la BD: " . mysql_error();
		exit;
	}

	return $informeGlobalResult;
}

function recuperaInformesGlobalMesAdminListado($mysqlCon,$anio, $dpto, $subdpto){

	global $generaInformeGlobalMes, $generaInformeGlobalMesAdmin, $arrayData;
	$arrayData = array();
	
	$anioPartido = explode("/",$anio);

	if ($dpto == 'aa'){
		$dpto = '%';
	}
	
	if ($stmt = $mysqlCon->prepare($generaInformeGlobalMesAdmin)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('sssssss',$anioPartido[0],$anioPartido[1],$anioPartido[0],$anioPartido[1],$anioPartido[0],$anioPartido[1],$dpto);
		/*Ejecucion de la consulta*/
		$stmt->execute();
		
		/*Almacenamos el resultSet*/
		$stmt->bind_result($departamento_id,$departamentos_desc,$totalImpresoras, $totalMaquinas, $byn, $color,$encuadernacion, $varios);

	
		while($stmt->fetch()) {

			$tmp = array();
			$tmp["departamento_id"] = $departamento_id;
			$tmp["departamentos_desc"] = $departamentos_desc;
			$tmp["totalImpresoras"] = $totalImpresoras;
			$tmp["totalMaquinas"] = $totalMaquinas;
			$tmp["byn"] = $byn;
			$tmp["color"] = $color;
			$tmp["encuadernacion"] =$encuadernacion;
			$tmp["varios"] =$varios;
			/*Asociamos el resultado en forma de array en el json*/
			array_push($arrayData, $tmp);
		}
		$stmt->close();
		/*Asociamos el correcto funcionamiento al json para comprobar en el js*/
		
		} else {
			/*Llegamos aqui con error, asociamos false para identificarlo en el js*/
		//	$jsondata["success"] = false;
			die("Errormessage: ". $mysqlCon->error);
		}
		/*Devolvemos el JSON con los datos de la consulta*/
// 		header('Content-type: application/json; charset=utf-8');
// 		echo json_encode($jsondata, JSON_FORCE_OBJECT);

		return $arrayData;
	}
	

function recuperaInformesGlobalMes($mysqlCon,$anio, $dpto, $subdpto){

	global $generaInformeGlobalMes, $generaInformeGlobal;
	
	$anioPartido = explode("/",$anio);

	$generaInformeGlobalMes = $generaInformeGlobalMes . " inner join subdepartamento sd1 on d1.departamento_id = sd1.departamento_id and sd1.subdepartamento_id = s1.subdepartamento_id where YEAR(s1.fecha_cierre) = " . $anioPartido[1] . " and month(s1.fecha_cierre) = " . $anioPartido[0];
	
	if ($dpto != 0 && $dpto != "aa")
		$generaInformeGlobalMes = $generaInformeGlobalMes . " and s1.departamento_id = " . $dpto;
	
	if ($subdpto == "aa"){
		
// 			$subdpto4Usuario = cargarDptoSessionAsArray($usuario);
		
// 			$generaInformeGlobalMes = $generaInformeGlobalMes . " and s1.subdepartamento_id in (" . $dpto4Usuario . ") ";
		
	}else{
	
		$generaInformeGlobalMes = $generaInformeGlobalMes . " and s1.subdepartamento_id = " . $subdpto;
	
	}
		
	$generaInformeGlobalMes = $generaInformeGlobalMes . " group by t1.codigo";
		

	$informeGlobalResult = mysqli_query($mysqlCon,$generaInformeGlobalMes);

	if (!$informeGlobalResult) {
		echo "No se pudo ejecutar con exito la consulta ($generaInformeGlobalMes) en la BD: " . mysql_error();
		exit;
	}
	
	return $informeGlobalResult;
}

function recuperaInformesMesGestor($mysqlCon, $mes, $usuario){

	global $generaInformeMesGestor;

	$generaInformeMesGestor = $generaInformeMesGestor . $mes;

	$informeResult = mysqli_query($mysqlCon,$generaInformeMesGestor);

	if (!$informeResult) {
		echo "No se pudo ejecutar con exito la consulta ($generaInformeMesGestor) en la BD: " . mysql_error();
		exit;
	}

	return $informeResult;
}

function recuperaDetalleValidador($usuario){
	
	global $mysqlCon, $recuperaInformeDetalleValida;
	
	$recuperaInformeDetalleValida = $recuperaInformeDetalleValida . $usuario . ")";	
	
	$informeResult = mysqli_query($mysqlCon,$recuperaInformeDetalleValida);
	
	if (!$informeResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaInformeDetalleValida) en la BD: " . mysql_error();
		exit;
	}
	
	return $informeResult;

}

function recuperaDetalleMesValidador($mysqlCon,$usuario,$anio,$dpto,$subdpto){

	global $mysqlCon, $recuperaInformeDetalleValida;

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

	if (!$informeResult) {

		echo "No se pudo ejecutar con exito la consulta ($recuperaInformeDetalleValida) en la BD: " . mysql_error();

		exit;

	}

	return $informeResult;

}

?>