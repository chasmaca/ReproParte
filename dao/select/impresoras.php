<?php


include ('query.php');

function recuperaImpresoras(){
	global $mysqlCon,$consultaImpresoras;
	
	$impresoraResult = mysqli_query($mysqlCon,$consultaImpresoras);
	
	if (!$impresoraResult) {
		echo "No se pudo ejecutar con exito la consulta ($consultaImpresoras) en la BD: " . mysql_error();
		exit;
	}
	
	if (mysqli_num_rows($impresoraResult) == 0) {
		echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
		exit;
	}
	
	return $impresoraResult;
	
}

function recuperaImpresorasPorId($id){
	global $mysqlCon,$consultaImpresorasPorId;
	$valores = "";
	/*Prepare Statement*/
	if ($stmt = $mysqlCon->prepare($consultaImpresorasPorId)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('i',$id);
		/*Ejecucion*/
		$stmt->execute();
		/*Asociacion de resultados*/
		$stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7);

		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			$valores = array($col1,$col2,$col3,$col4,$col5,$col6,$col7);
		}
		/*Cerramos la conexion*/
		$stmt->close();
	}else{
		echo $stmt->error;
	}
	
	return $valores;
	
	
}