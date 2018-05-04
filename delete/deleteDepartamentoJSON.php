<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathInsert = "borrado.php";

include_once($pathDB);
include_once($pathInsert);

$departamento = $_GET["departamentoId"];

global $mysqlCon,$borradoDepartamento;

$jsondata = array();
$jsondata["data"] = array();

if ($stmt = $mysqlCon->prepare($borradoDepartamento)) {
	$stmt->bind_param('i',$departamento);
	$stmt->execute();
	$jsondata["success"] = true;
	$log  =
	date('l jS \of F Y h:i:s A').PHP_EOL.
	"Fichero: delete/borrarDepartamento.php".PHP_EOL.
	"Metodo: borrarDepartamento".PHP_EOL.
	"Query: ".$borradoDepartamento.PHP_EOL.
	"Parameter: ".$departamento.PHP_EOL.
	"Ejecucion Correcta".PHP_EOL.
	"-------------------------".PHP_EOL;
	error_log($log, 3, "../../log/borrados.log");
	
} else {
	/*Llegamos aqui con error, asociamos false para identificarlo en el js*/
	$jsondata["success"] = false;
	$log  =
	date('l jS \of F Y h:i:s A').PHP_EOL.
	"Fichero: delete/borrarDepartamento.php".PHP_EOL.
	"Metodo: borrarDepartamento".PHP_EOL.
	"Query: ".$borradoDepartamento.PHP_EOL.
	"Parameter: ".$departamento.PHP_EOL.
	"Ejecucion Erronea".PHP_EOL.
	"-------------------------".PHP_EOL;
	error_log($log, 3, "../../log/borrados.log");
	
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

/*Devolvemos el JSON con los datos de la consulta*/
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

?>