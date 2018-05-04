<?php
$pathQuery = "query.php";
include_once($pathQuery);

function cargarDptoAutorizador($mysqlCon){

	$detallesResult = null;

	if( isset($_POST['autorizador']) ){
		$autorizador = $_POST["autorizador"];
		global $recuperaDptoXAutorizador;

		$recuperaDptoXAutorizador = $recuperaDptoXAutorizador . $autorizador;

		$detallesResult = mysqli_query($mysqlCon,$recuperaDptoXAutorizador);

		if (!$detallesResult) {
			echo "No se pudo ejecutar con exito la consulta ($recuperaDptoXAutorizador) en la BD: " . mysql_error();
			exit;
		}
	}

	return $detallesResult;
}

function cargarTodosDepartamentos(){

	global $mysqlCon;
	$detallesResult = null;

	global $todosDepartamentosQuery;

	$detallesResult = mysqli_query($mysqlCon,$todosDepartamentosQuery);

	if (!$detallesResult) {
		echo "No se pudo ejecutar con exito la consulta ($todosDepartamentosQuery) en la BD: " . mysql_error();
		exit;
	}


	return $detallesResult;
}

function cargarDptoSession($usuario){

	$detallesResult = null;
	$autorizador = $usuario;

	global $recuperaDptoXAutorizador,$mysqlCon;

	$recuperaDptoXAutorizador = $recuperaDptoXAutorizador . $autorizador;

	$detallesResult = mysqli_query($mysqlCon,$recuperaDptoXAutorizador);

	if (!$detallesResult) {
		echo "No se pudo ejecutar con exito la consulta ($recuperaDptoXAutorizador) en la BD: " . mysql_error();
		exit;
	}
	
	return $detallesResult;
}

function cargarDptoSessionAsArray($usuario){

	global $recuperaDptoXAutorizadorArray,$mysqlCon;

	$valores = "";
	/*Prepare Statement*/
	if ($stmt = $mysqlCon->prepare($recuperaDptoXAutorizadorArray)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('i',$usuario);
		/*Ejecucion*/
		$stmt->execute();
		/*Asociacion de resultados*/
		$stmt->bind_result($col1);
		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			if ($valores == "")
				$valores = $col1;
			else
				$valores .= "," . $col1;
		}
		/*Cerramos la conexion*/
		$stmt->close();
	}else{
		echo $stmt->error;
	}
	
	return $valores;
}

function cargarSubDptoXDptoAsArray($usuario, $dpto){

	global $recuperaSubdptoXDpto,$mysqlCon;

	$valores = "";
	/*Prepare Statement*/
	if ($stmt = $mysqlCon->prepare($recuperaSubdptoXDpto)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('i',$dpto);
		/*Ejecucion*/
		$stmt->execute();
		/*Asociacion de resultados*/
		$stmt->bind_result($col1,$col2,$col3,$col4);
		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			if ($valores == "")
				$valores = $col2;
			else
				$valores .= "," . $col2;
		}
		/*Cerramos la conexion*/

		$stmt->close();
	}else{
		echo $stmt->error;
	}

	return $valores;
}

function cargarSubDptoSessionAsArray($usuario){

    global $recuperaSubDptoXAutorizadorArray,$mysqlCon;

    $valores = "";
    /*Prepare Statement*/
    if ($stmt = $mysqlCon->prepare($recuperaSubDptoXAutorizadorArray)) {
        /*Asociacion de parametros*/
        $stmt->bind_param('i',$usuario);
        /*Ejecucion*/
        $stmt->execute();
        /*Asociacion de resultados*/
        $stmt->bind_result($col1);
        /*Recogemos el resultado en la variable*/
        while ($stmt->fetch()) {
            if ($valores == "")
                $valores = $col1;
                else
                    $valores .= "," . $col1;
        }
        /*Cerramos la conexion*/
        
        echo $recuperaSubDptoXAutorizadorArray . "-->" . $usuario;
        exit;
        $stmt->close();
    }else{
        echo $stmt->error;
    }

    return $valores;
}
?>