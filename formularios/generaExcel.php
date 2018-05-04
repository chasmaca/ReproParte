<?php

include ('../dao/select/query.php');
include '../utiles/connectDBUtiles.php';

/*Definimos las variables*/
$periodo = "";
$departamento = "";
$subdepartamento = "";
$tipoInforme = "";

$periodo = htmlspecialchars($_POST["periodo"]);
$departamento = htmlspecialchars($_POST["depParametro"]);
$subdepartamento = htmlspecialchars($_POST["subdptoParametro"]);
$tipoInforme = htmlspecialchars($_POST["tipoInforme"]);

/*Realizamos la llamada a la funcion*/
if ($periodo != "" && $departamento != "" && $subdepartamento != "" && $tipoInforme != ""){
	if ($tipoInforme=='global')
		recuperaInformesGlobalMesAdmin($periodo, $departamento, $subdepartamento);
	else
		recuperaInformesMesAdmin($periodo,$departamento,$subdepartamento);
}else{
	echo "No se han recogido los parametros";
}


function recuperaInformesMesAdmin( $anio, $dpto,$subdpto){

	global $generaInformeMes, $mysqlCon;

	$anioPartido = explode("/",$anio);
	header("Content-Disposition: attachment; filename=Informe_Detallado_Repro.xls");
	header("Content-Type: application/vnd.ms-excel");
	$flag = false;
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
		'Impresoras' as subdepartamentos_desc
		from gastos_impresora i inner join departamento d1 on i.departamento_id=d1.departamento_id  where YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) = " . $anioPartido[0];

			$generaInformeMes .= " UNION
		select
		'treintabarraMaq' as codigo, 'ceco',
		i.departamento_id, concat('Maquinas ', d1.departamentos_desc)  as Maquinas, i.periodo,
		ROUND(byn_total,2) as byn, ROUND(color_total,2) as color,
		0 as encuadernacion,
		0 as varios,
		'Maquinas' as subdepartamentos_desc
		from gastos_maquina i inner join departamento d1 on i.departamento_id=d1.departamento_id where YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) =  " . $anioPartido[0];

		}else{
			$generaInformeMes .= " UNION
		select
		'treintabarra' as codigo, 'ceco',
		i.departamento_id, 'Impresoras', i.periodo,
		ROUND(byn_total,2) as byn, ROUND(color_total,2) as color,
		0 as encuadernacion,
		0 as varios,
		'Impresoras' as subdepartamentos_desc
		from gastos_impresora i where i.departamento_id = " . $dpto ." and YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) = " . $anioPartido[0];

			$generaInformeMes .= " UNION
		select
		'treintabarraMaq' as codigo, 'ceco',
		i.departamento_id, 'Maquinas', i.periodo,
		ROUND(byn_total,2) as byn, ROUND(color_total,2) as color,
		0 as encuadernacion,
		0 as varios,
		'Maquinas' as subdepartamentos_desc
		from gastos_maquina i where i.departamento_id = " . $dpto ." and YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) = " . $anioPartido[0];

		}

		$informeResult = mysqli_query($mysqlCon,$generaInformeMes);


		$totalGrupo = 0;
		while($row = $informeResult->fetch_assoc()) {
			if(!$flag) {
				// display field/column names as first row
				echo implode("\t", array_keys($row)) . "\tSUBTOTAL\r\n";
				$flag = true;
			}
			if ($row!=null){
				$totalLinea = 0;
				$totalLinea = $row['encuadernacion'] + $row['byn'] + $row['color'] + $row['varios'];
				$totalGrupo = $totalGrupo + $totalLinea;
				//array_walk($row, __NAMESPACE__ . '\cleanData');
				echo implode("\t", array_values($row)) . "\t".$totalLinea."\r\n";
			}
		}
		echo "\t\t\t\t\t\t\t\t\tTOTAL\t".$totalGrupo."\r\n";
}

function recuperaInformesGlobalMesAdmin($anio, $dpto, $subdpto){

	global $mysqlCon;
	header("Content-Disposition: attachment; filename=Informe_Global_Repro.xls");
	header("Content-Type: application/vnd.ms-excel");
	$flag = false;
	$anioPartido = explode("/",$anio);

	if ($dpto == 'aa'){
		$dpto = '%';
	}

	$generaInformeMes=
	"SELECT
									d1.departamento_id, d1.departamentos_desc,
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
												month(i1.periodo) = ".$anioPartido[0]." and
												YEAR(i1.periodo) = ".$anioPartido[1]."
										LEFT OUTER JOIN
											gastos_maquina m1 on
												m1.departamento_id=d1.departamento_id and
												month(m1.periodo) = ".$anioPartido[0]." and
												YEAR(m1.periodo) = ".$anioPartido[1]."
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
                                                    	month(fecha_cierre) = ".$anioPartido[0]." and
                                                    	YEAR(fecha_cierre) = ".$anioPartido[1].")
								WHERE d1.departamento_id like '". $dpto ."'
								GROUP BY d1.departamento_id";
	
	$informeResult = mysqli_query($mysqlCon,$generaInformeMes);
	
	$totalGrupo = 0;
	while($row = $informeResult->fetch_assoc()) {
	
		if(!$flag) {
			// display field/column names as first row
			echo implode("\t", array_keys($row)) . "\tSUBTOTAL\r\n";
			$flag = true;
		}
		if ($row!=null){
			//array_walk($row, __NAMESPACE__ . '\cleanData');
			$totalLinea = 0;
			$totalLinea = $row['totalImpresoras'] + $row['totalMaquinas'] + $row['encuadernacion'] + $row['byn'] + $row['color'] + $row['varios'];
			$totalGrupo = $totalGrupo + $totalLinea;
			
			echo implode("\t", array_values($row)) . "\t".$totalLinea."\r\n";
		}
	}
	echo "\t\t\t\t\t\t\tTOTAL\t".$totalGrupo."\r\n";
}


?>