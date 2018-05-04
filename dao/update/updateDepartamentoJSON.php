<?php

include_once 'updates.php';
include '../../utiles/connectDBUtiles.php';

$id = $_GET["departamentoId"];
$nombre = $_GET["departamentoNombre"];
$ceco = $_GET["departamentoCeco"];

updateDepartamento($id,$nombre,$ceco);

/*Funcion que recupera todos los departamentos asociados al validador*/
function updateDepartamento($id,$nombre,$ceco){

	/*Declaramos como global la conexion y la query y el id de validador*/
	global $mysqlCon, $sentenciaUpdateDepartamento;
	/*definimos el json*/
	$jsondata = array();
	$jsondata["data"] = array();

	if ($stmt = $mysqlCon->prepare($sentenciaUpdateDepartamento)) {
		$stmt->bind_param('ssi',$nombre,$ceco,$id);
		$stmt->execute();
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

?>