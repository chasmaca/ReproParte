<?php
$pathDB = "../../utiles/connectDBUtiles.php";
$pathInsert = "inserciones.php";

include_once($pathDB);
include_once($pathInsert);

$carreraDesc = htmlspecialchars($_POST["nombreCarrera"]);
$carreraId = htmlspecialchars($_POST["idCarrera"]);

if ($stmt = $mysqlCon->prepare($sentenciaBorradoCarrera)) {
	$stmt->bind_param('i',$carreraId);
	$stmt->execute();
} else {
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: ../../formularios/homeAdministrador.php");
exit;


?>