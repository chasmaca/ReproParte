<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathUpdate = "updates.php";

include_once($pathDB);
include_once($pathUpdate);

$departamentoDesc = utf8_encode(htmlspecialchars($_POST["nombreDepartamento"]));
$departamentoId = htmlspecialchars($_POST["idDepartamento"]);
$ceco = htmlspecialchars($_POST["CeCo"]);

if ($stmt = $mysqlCon->prepare($sentenciaUpdateDepartamento)) {
	$stmt->bind_param('ssi',trim($departamentoDesc),$ceco,$departamentoId);
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