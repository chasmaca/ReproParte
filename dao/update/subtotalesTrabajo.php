<?php
include_once("../../utiles/connectDBUtiles.php");
include_once("../update/updates.php");

$solicitud = $_GET["solicitudId"];
$varios1 = $_GET["varios1"];
$varios2 = $_GET["varios2"];
$color = $_GET["color"];
$blancoYNegro = $_GET["byn"];
$espiral = $_GET["espiral"];
$encolado = $_GET["encolado"];


actualizarSubtotales ($solicitud,$varios1,$varios2,$color,$blancoYNegro,$espiral,$encolado);

function actualizarSubtotales ($solicitud,$varios1,$varios2,$color,$blancoYNegro,$espiral, $encolado){
	global $mysqlCon, $sentenciaActualizaSubTotales;
	$jsondata = array();
	//UPDATE trabajo set precioVarios = ?, precioVarios1 = ?, precioVarios2 = ?, precioColor = ?, precioByN = ?, precioEncuadernacion = ?, precioEspiral = ?, precioEncolado = ? where solicitud_id = ?
	
	$precioVarios = $varios1 + $varios2;
	$precioEncuadenaciones = $espiral + $encolado;
	if ($stmt = $mysqlCon->prepare($sentenciaActualizaSubTotales)) {
		
		$stmt->bind_param('ddddddddi',$precioVarios,$varios1,$varios2,$color,$blancoYNegro,$precioEncuadenaciones, $espiral, $encolado, $solicitud);
		if ($stmt->execute()){
			$jsondata["success"] = true;
			$jsondata["message"] = "Actualizacion realizada con exito.";
		}else{
			$jsondata["success"] = false;
			$jsondata["message"] = "Ha habido un problema con el cálculo de subtotales, por favor recargue la pagina.";
		}
		
	} else {
	
		$jsondata["success"] = false;
		$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;
		$jsondata["message"] = "Ha habido un problema con el cálculo de subtotales, por favor recargue la pagina.";
		
	}
	
	$stmt->close();
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
}
?>