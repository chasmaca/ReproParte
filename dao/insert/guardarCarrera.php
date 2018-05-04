<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathInsert = "inserciones.php";


include_once($pathDB);
include_once($pathQuery);
include_once($pathInsert);

$carrera = utf8_decode(htmlspecialchars($_POST["nombreCarrera"]));

if ($stmt = $mysqlCon->prepare($sentenciaInsertCarrera)) {
	$stmt->bind_param('s',$carrera);
	$stmt->execute();
} else {
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: ../../formularios/homeAdministrador.php");
exit;


?>