<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathInsert = "borrado.php";

include_once($pathDB);
include_once($pathInsert);

$usuarioId = htmlspecialchars($_POST["usuarioId"]);

if ($stmt = $mysqlCon->prepare($sentenciaBorradoUsuario)) {
	$stmt->bind_param('i',$usuarioId);
	$stmt->execute();
} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=6");
	exit;
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();
header("Location: ../../formularios/confirmacion.php?mensaje=5");
exit;

?>