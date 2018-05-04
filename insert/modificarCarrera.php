<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathInsert = "inserciones.php";

include_once($pathDB);
include_once($pathQuery);
include_once($pathInsert);

$carreraDesc = utf8_decode(htmlspecialchars($_POST["nombreCarrera"]));
$carreraId = htmlspecialchars($_POST["idCarrera"]);

if ($stmt = $mysqlCon->prepare($sentenciaUpdateCarrera)) {
	$stmt->bind_param('si',$carreraDesc,$carreraId);
	$stmt->execute();
} else {
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: ../../formularios/homeAdministrador.php");
exit;


?>