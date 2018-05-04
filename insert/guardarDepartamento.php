<?php
$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathInsert = "inserciones.php";

include_once($pathDB);
include_once($pathQuery);
include_once($pathInsert);

$departamentoDesc = utf8_decode(htmlspecialchars($_POST["nombreDepartamento"]));
$ceco = htmlspecialchars($_POST["CeCo"]);


if ($stmt = $mysqlCon->prepare($sentenciaInsertDepartamento)) {
	$stmt->bind_param('ss',trim($departamentoDesc),trim($ceco));
	$stmt->execute();
} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=8");
	exit;
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();


header("Location: ../../formularios/confirmacion.php?mensaje=7");
exit;

?>