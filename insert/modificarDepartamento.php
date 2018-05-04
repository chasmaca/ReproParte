<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathInsert = "inserciones.php";

include_once($pathDB);
include_once($pathQuery);
include_once($pathInsert);

$departamentoDesc = utf8_decode(htmlspecialchars($_POST["nombreDepartamento"]));
$departamentoId = htmlspecialchars($_POST["idDepartamento"]);
$ceco = htmlspecialchars($_POST["CeCo"]);
$treinta = htmlspecialchars($_POST["treintabarra"]);

if ($stmt = $mysqlCon->prepare($sentenciaUpdateDepartamento)) {
	$stmt->bind_param('sssi',trim($departamentoDesc),$treinta,$ceco,$departamentoId);
	$stmt->execute();
} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=10");
	exit;
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: ../../formularios/confirmacion.php?mensaje=9");
exit;
