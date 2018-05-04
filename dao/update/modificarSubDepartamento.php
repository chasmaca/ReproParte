<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathUpdate = "updates.php"; 

include_once($pathDB);
include_once($pathUpdate);

$departamentoId = htmlspecialchars($_POST["departamento"]);
$subdepartamentoDesc = utf8_encode(htmlspecialchars($_POST["nombreSubDepartamento"]));
$subdepartamentoId = htmlspecialchars($_POST["subdepartamento"]);
$treinta = htmlspecialchars($_POST["treintabarra"]);

if ($stmt = $mysqlCon->prepare($sentenciaUpdateSubDepartamento)) {
	$stmt->bind_param('ssii',trim($subdepartamentoDesc),$treinta,$departamentoId,$subdepartamentoId);
	$stmt->execute();
} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=10");
	exit;
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: ../../formularios/confirmacion.php?mensaje=9");
exit;
?>