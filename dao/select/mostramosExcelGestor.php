<?php

include ('query.php');
include '../../utiles/connectDBUtiles.php';

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
		mostrarListadoGlobalGestor($periodo,$departamento,$subdepartamento,$tipoInforme);
	else
//		mostrarListadoDetalleGestor($periodo,$departamento,$subdepartamento,$tipoInforme);
		excelDetalleGestor($periodo,$departamento,$subdepartamento,$tipoInforme);
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
function mostrarListadoGlobalGestor($periodo,$departamento,$subdepartamento,$tipoInforme){

	global $mysqlCon;

	$periodoPartido = explode("/",$periodo);

	header("Content-Disposition: attachment; filename=Informe_Global_Gestor.xls");
	header("Content-Type: application/vnd.ms-excel");
	$flag = false;

	$queryGlobal = "SELECT 
						d1.departamento_id as departamentoId, d1.departamentos_desc as departamento, 
						round(i1.byn_total+i1.color_total,2) as totalImpresoras,
						round(m1.byn_total+m1.color_total,2) as totalMaquinas,
						round(sum(t1.precioByN),2) as byn, 
						round(sum(t1.precioColor),2) as color, 
						round(sum(t1.precioEncuadernacion),2) as encuadernacion, 
						round(sum(t1.PrecioVarios),2) as varios 
					FROM
						departamento d1
							LEFT OUTER JOIN 
								gastos_impresora i1 on 
									i1.departamento_id = d1.departamento_id and 
									month(i1.periodo) = ".$periodoPartido[0]." and 
									YEAR(i1.periodo) = ".$periodoPartido[1]."
							LEFT OUTER JOIN 
								gastos_maquina m1 on 
									m1.departamento_id=d1.departamento_id and 
									month(m1.periodo) = ".$periodoPartido[0]." and 
									YEAR(m1.periodo) = ".$periodoPartido[1]."
							LEFT OUTER JOIN 
								trabajo t1 on 
									t1.departamento_id = d1.departamento_id
									and t1.solicitud_id in (
										select 
											solicitud_id 
										from
											solicitud 
										where 
                                        	status_id = 6 and 
                                            month(fecha_cierre) = ".$periodoPartido[0]." and 
                                            YEAR(fecha_cierre) = ".$periodoPartido[1].")";
	if ($departamento != 'aa'){
		
		$queryGlobal .= " WHERE d1.departamento_id like '".$departamento."'";
	}
		
	$queryGlobal .=	" GROUP BY d1.departamento_id";

	
	$result = mysqli_query($mysqlCon, $queryGlobal);
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
			$totalLinea = $row['totalImpresoras'] + $row['totalMaquinas'] + $row['byn'] + $row['color'] + $row['encuadernacion'] + $row['varios'];
			$totalGrupo = $totalGrupo + $totalLinea;
			if ($totalLinea!=0)
				echo implode("\t", array_values($row)) . "\t".$totalLinea."\r\n";
		}
	}
	echo "\t\t\t\t\t\t\tTOTAL\t" . $totalGrupo . "\r\n";

}

/**
 * Funcion que recupera de bbdd todos los datos del informe detalle que este solicitando el usuario Gestor
 * @param $periodo
 * @param $departamento
 * @param $subdepartamento
 * @param $tipoInforme
 */
function mostrarListadoDetalleGestor($periodo,$departamento,$subdepartamento,$tipoInforme){

	global $mysqlCon;
	
	$periodoPartido = explode("/",$periodo);
	
	if ($departamento == 'aa'){
		$departamento = '%';
		$subdepartamento = '%';
	}
	
	if ($subdepartamento == 'aa'){
		$subdepartamento = '%';
	}
	
	header("Content-Disposition: attachment; filename=Informe_Detalle_Gestor.xls");
	header("Content-Type: application/vnd.ms-excel");
	$flag = false;
	
	$sqlDetalle = "SELECT
	sd1.treintabarra as codigo,
	d1.CeCo as ceco,
	t1.departamento_id as departamento_id,
	d1.departamentos_desc,
	ROUND(t1.precioByN,2) as byn,
	ROUND(t1.precioColor,2) as color,
	ROUND(t1.precioEncuadernacion,2) as encuadernacion,
	ROUND(t1.PrecioVarios,2) as varios,
	'0' as total_byn,'0' as total_color,
	sd1.subdepartamento_desc as subdepartamentos_desc
	FROM
	trabajo t1
	INNER JOIN departamento d1 ON t1.departamento_id = d1.departamento_id
	INNER JOIN solicitud s1 on t1.solicitud_id = s1.solicitud_id
	inner join subdepartamento sd1 on d1.departamento_id = sd1.departamento_id and sd1.subdepartamento_id = s1.subdepartamento_id
	WHERE
	YEAR(s1.fecha_cierre) = ".$periodoPartido[1]." and
	month(s1.fecha_cierre) = ".$periodoPartido[0]." and
	s1.status_id = 6 and
	s1.departamento_id like '".$departamento."' AND
	s1.subdepartamento_id like '".$subdepartamento ."'";
	
	if ($departamento =="%"){
		$sqlDetalle .= " UNION
		select
		'treintabarra' as codigo, 
		'ceco' as ceco,
		i.departamento_id as departamento_id, 
		concat('Impresoras ', d1.departamentos_desc)  as 'Impresoras',
		'0'  as byn,
		'0' as color,
		'0' as encuadernacion,
		'0' as varios,
		ROUND(byn_total,2) as total_byn, 
		ROUND(color_total,2) as total_color,
		'Impresoras' as subdepartamentos_desc
		from gastos_impresora i inner join departamento d1 on i.departamento_id=d1.departamento_id  where YEAR(i.periodo) = " . $periodoPartido[1] . " and month(i.periodo) = " . $periodoPartido[0];
	
		$sqlDetalle .= " UNION
		select
		'treintabarraMaq' as codigo, 'ceco' as ceco,
		i.departamento_id, concat('Maquinas ', d1.departamentos_desc)  as Maquinas,'0'  as byn,'0' as color,'0' as encuadernacion,'0' as varios,
		ROUND(byn_total,2) as total_byn, ROUND(color_total,2) as total_color,
		'Maquinas' as subdepartamentos_desc
		from gastos_maquina i inner join departamento d1 on i.departamento_id=d1.departamento_id where YEAR(i.periodo) = " . $periodoPartido[1] . " and month(i.periodo) =  " . $periodoPartido[0];
	
	}else{
		$sqlDetalle .= " UNION
		select
		'treintabarra' as codigo, 'ceco',
		i.departamento_id, 'Impresoras','0' as byn,'0' as color,'0' as encuadernacion,'0' as varios,
		ROUND(byn_total,2) as total_byn, ROUND(color_total,2) as total_color,
		'Impresoras' as subdepartamentos_desc
		from gastos_impresora i where i.departamento_id = " . $departamento ." and YEAR(i.periodo) = " . $periodoPartido[1] . " and month(i.periodo) = " . $periodoPartido[0];
			
		$sqlDetalle .= " UNION
		select
		'treintabarraMaq' as codigo, 'ceco',
		i.departamento_id, 'Maquinas','0'  as byn,'0' as color,'0' as encuadernacion,'0' as varios,
		ROUND(byn_total,2) as total_byn, ROUND(color_total,2) as total_color,
		'Maquinas' as subdepartamentos_desc
		from gastos_maquina i where i.departamento_id = " . $departamento ." and YEAR(i.periodo) = " . $periodoPartido[1] . " and month(i.periodo) = " . $periodoPartido[0];
	
	}
	
	$result = mysqli_query($mysqlCon,$sqlDetalle);
	$totalGrupo = 0;
	while($row = $result->fetch_assoc()) {
		if(!$flag) {
			// display field/column names as first row
			echo implode("\t", array_keys($row)) . "\t SUBTOTAL \r\n";
			$flag = true;
		}
		if ($row!=null){
			//array_walk($row, __NAMESPACE__ . '\cleanData');
			$totalLinea = 0;
			$totalLinea = $row['encuadernacion'] + $row['byn'] + $row['color'] + $row['varios'] + $row['total_byn'] + $row['total_color'];
			$totalGrupo = $totalGrupo + $totalLinea;
			if ($totalLinea!=0)
				echo implode("\t", array_values($row)) . "\t".$totalLinea."\r\n";
		}
	}
	echo "\t\t\t\t\t\t\t\t\t\tTOTAL\t" . $totalGrupo . "\r\n";
}

function excelDetalleGestor($periodo,$departamento,$subdepartamento,$tipoInforme){

	header("Content-Disposition: attachment; filename=Informe_Detalle_Gestor.xls");
	header("Content-Type: application/vnd.ms-excel");
	$flag = false;
	
	global $generaInformeMes, $jsondata,$mysqlCon;

	$anioPartido = explode("/",$periodo);

	$generaInformeMes = $generaInformeMes . $anioPartido[1] . " and month(s1.fecha_cierre) = " . $anioPartido[0];

	if ($departamento != 0 && $departamento != "aa")
		$generaInformeMes = $generaInformeMes . " and s1.departamento_id = " . $departamento;



		$resumentSub = "";
		if ($subdepartamento == "aa"){
			if ($departamento =="aa"){

			}else{

				$subdepartamentoList = recuperaSubXDpto($departamento);
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

			if ($subdepartamento!=0)
				$generaInformeMes = $generaInformeMes . " and s1.subdepartamento_id = " . $subdepartamento;

		}

		if ($departamento =="aa"){
			$generaInformeMes .= " UNION
		select
		'treintabarra' as codigo, 'cecoImpresoras' as ceco,
		i.departamento_id as departamentoId, concat('Impresoras ', d1.departamentos_desc)  as departamentoDesc, i.periodo as fechaCierre,
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
		'treintabarraMaq' as codigo,  'cecoMaquinas' as ceco,
		i.departamento_id as departamentoId,  concat('Maquinas ', d1.departamentos_desc)  as departamentoDesc, i.periodo as fechaCierre,
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
		'treintabarra' as codigo, 'cecoImpresoras' as ceco,
		i.departamento_id as departamentoId, 'Impresoras' as departamentoDesc, i.periodo as fechaCierre,
		ROUND(byn_total,2) as byn, ROUND(color_total,2) as color,
		0 as encuadernacion,
		0 as varios,
		'Impresoras' as subdepartamentos_desc,
		'' as descripcion,
		'' as nombre,
		'' as apellido
		from gastos_impresora i where i.departamento_id = " . $departamento ." and YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) = " . $anioPartido[0];
				
			$generaInformeMes .= " UNION
		select
		'treintabarraMaq' as codigo, 'cecoMaquinas' as ceco,
		i.departamento_id as departamentoId, 'Maquinas' as departamentoDesc, i.periodo as fechaCierre,
		ROUND(byn_total,2) as byn, ROUND(color_total,2) as color,
		0 as encuadernacion,
		0 as varios,
		'Maquinas' as subdepartamentos_desc,
		'' as descripcion,
		'' as nombre,
		'' as apellido
		from gastos_maquina i where i.departamento_id = " . $departamento ." and YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) = " . $anioPartido[0];

		}

		/**
		 *
		 * select sd1.treintabarra as codigo, d1.CeCo mas ceco,t1.departamento_id as departamentoId,d1.departamentos_desc as departamentoDesc,s1.fecha_cierre as fechaCierre, t1.precioByN as byn,t1.precioColor as color, t1.precioEncuadernacion as encuadernacion,t1.PrecioVarios as varios, sd1.subdepartamento_desc as subdepartamentos_desc
		 */

		$informeResult = mysqli_query($mysqlCon,$generaInformeMes);
		$totalGrupo = 0;
		while($row = $informeResult->fetch_assoc()) {
			if(!$flag) {
				// display field/column names as first row
				echo implode("\t", array_keys($row)) . "\t SUBTOTAL \r\n";
				$flag = true;
			}
			if ($row!=null){
				//array_walk($row, __NAMESPACE__ . '\cleanData');
				$totalLinea = 0;
				$totalLinea = $row['encuadernacion'] + $row['byn'] + $row['color'] + $row['varios'] ;
				$totalGrupo = $totalGrupo + $totalLinea;
				if ($totalLinea!=0)
					echo implode("\t", array_values($row)) . "\t".$totalLinea."\r\n";
			}
		}
		echo "\t\t\t\t\t\t\t\t\t\tTOTAL\t" . $totalGrupo . "\r\n";
		
}


?>