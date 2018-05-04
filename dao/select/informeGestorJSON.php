<?php

	include ('query.php');
	include '../../utiles/connectDBUtiles.php';
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
			recuperaListadoGlobalGestor($periodo,$departamento,$subdepartamento,$tipoInforme);
		else
			recuperaListadoDetalleGestor($periodo,$departamento,$subdepartamento,$tipoInforme);
	}
	
	/**
	 * Funcion que recupera de bbdd todos los datos del informe global que este solicitando el usuario Gestor
	 * @param  $periodo
	 * @param  $departamento
	 * @param  $subdepartamento
	 * @param  $tipoInforme
	 */
	function recuperaListadoGlobalGestor($periodo,$departamento,$subdepartamento,$tipoInforme){
		
		global $generaInformeGlobalMesGestor, $jsondata,$mysqlCon;
		
		$periodoPartido = explode("/",$periodo);
		
		if ($departamento == 'aa'){
			$departamento = '%';
			$subdepartamento = '%';
		}
		
		if ($subdepartamento == 'aa'){
			$subdepartamento = '%';
		}
	
		if ($stmt = $mysqlCon->prepare($generaInformeGlobalMesGestor)) {
			
			/*Asociacion de parametros*/
			$stmt->bind_param('sssssss',$periodoPartido[0],$periodoPartido[1],$periodoPartido[0],$periodoPartido[1],$periodoPartido[0],$periodoPartido[1],$departamento);
			//$stmt->bind_param('ssss',$periodoPartido[1],$periodoPartido[0],$departamento,$subdepartamento);
			/*Ejecucion de la consulta*/
			$stmt->execute();
			
			/*Almacenamos el resultSet*/
		$stmt->bind_result($departamento_id,$departamentos_desc,$totalImpresoras, $totalMaquinas, $byn, $color,$encuadernacion, $varios,$ceco);

	
		while($stmt->fetch()) {

			$tmp = array();
			$tmp["departamento_id"] = $departamento_id;
			$tmp["departamentos_desc"] = utf8_encode($departamentos_desc);
			$tmp["totalImpresoras"] = $totalImpresoras;
			$tmp["totalMaquinas"] = $totalMaquinas;
			$tmp["byn"] = $byn;
			$tmp["color"] = $color;
			$tmp["encuadernacion"] =$encuadernacion;
			$tmp["varios"] =$varios;
			$tmp["ceco"] =$ceco;
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
	
	/**
	 * Funcion que recupera de bbdd todos los datos del informe detalle que este solicitando el usuario Gestor 
	 * @param $periodo
	 * @param $departamento
	 * @param $subdepartamento
	 * @param $tipoInforme
	 */
	function recuperaListadoDetalleGestor($periodo,$departamento,$subdepartamento,$tipoInforme){
		
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
		from gastos_maquina i where 
			i.departamento_id = " . $departamento ." and YEAR(i.periodo) = " . $anioPartido[1] . " and month(i.periodo) = " . $anioPartido[0];
		
		}
		
		/**
		 * 
		 * select sd1.treintabarra as codigo, d1.CeCo mas ceco,t1.departamento_id as departamentoId,d1.departamentos_desc as departamentoDesc,s1.fecha_cierre as fechaCierre, t1.precioByN as byn,t1.precioColor as color, t1.precioEncuadernacion as encuadernacion,t1.PrecioVarios as varios, sd1.subdepartamento_desc as subdepartamentos_desc 
		 */

		
		$informeResult = mysqli_query($mysqlCon,$generaInformeMes);
		
		while($row = $informeResult->fetch_assoc()) {
			
				$tmp = array();

				$tmp["codigo"] = $row["codigo"];
				$tmp["ceco"] = utf8_encode($row["ceco"]);
				$tmp["departamentoId"] = $row["departamentoId"];
				$tmp["departamentoDesc"] = utf8_encode($row["departamentoDesc"]);
				$tmp["fechaCierre"] = $row["fechaCierre"];
				$tmp["byn"] = $row["byn"];
				$tmp["color"] = $row["color"];
				$tmp["encuadernacion"] =$row["encuadernacion"];
				$tmp["varios"] =$row["varios"];
				$tmp["subdepartamentos_desc"] =utf8_encode($row["subdepartamentos_desc"]);
				/*Asociamos el resultado en forma de array en el json*/
				array_push($jsondata["data"], $tmp);
		}
// 			/*Asociamos el correcto funcionamiento al json para comprobar en el js*/
			
			$jsondata["success"] = true;
// 			/*Devolvemos el JSON con los datos de la consulta*/
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata, JSON_FORCE_OBJECT);
	}
	
	
?>