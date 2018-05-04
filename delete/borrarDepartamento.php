<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathInsert = "borrado.php";

include_once($pathDB);
include_once($pathInsert);

global $borradoDepartamento,$mysqlCon;

$log  =
date('l jS \of F Y h:i:s A').PHP_EOL.
"Fichero: delete/borrarDepartamento.php".PHP_EOL.
"Metodo: borrarDepartamento".PHP_EOL.
"-------------------------".PHP_EOL;
error_log($log, 3, "../../log/borrados.log");
exit;

$departamento = htmlspecialchars($_POST["departamento"]);

if ($stmt = $mysqlCon->prepare($borradoDepartamento)) {
	$stmt->bind_param('i',$departamento);
	$stmt->execute();
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
	$log  =
	date('l jS \of F Y h:i:s A').PHP_EOL.
	"Fichero: delete/borrarDepartamento.php".PHP_EOL.
	"Metodo: borrarDepartamento".PHP_EOL.
	"Query: ".$borradoDepartamento.PHP_EOL.
	"Parameter: ".$departamento.PHP_EOL.
	"Ejecucion Erronea".PHP_EOL.
	"-------------------------".PHP_EOL;
	error_log($log, 3, "../../log/borrados.log");
	
	
}
$stmt->close();

?>