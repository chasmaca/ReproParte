<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathInsert = "borrado.php";

include_once($pathDB);
include_once($pathInsert);

$departamento = htmlspecialchars($_POST["departamento"]);
$subdepartamento = htmlspecialchars($_POST["subdepartamento"]);


if ($stmt = $mysqlCon->prepare($borrarSubdepartamento)) {
	$stmt->bind_param('ii',$departamento,$subdepartamento);
	$stmt->execute();
} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=12");
	exit;
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: ../../formularios/confirmacion.php?mensaje=11");
exit;

?>