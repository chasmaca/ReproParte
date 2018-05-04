<?php
$pathDB = "../../utiles/connectDBUtiles.php";
$pathUpdate = "updates.php";

include_once($pathDB);
include_once($pathUpdate);

$usuario = htmlspecialchars($_POST["email"]);
$password = utf8_decode(htmlspecialchars($_POST["pwd"]));

global $sentenciaUpdatePassword,$mysqlCon;

echo $sentenciaUpdatePassword;
echo $usuario;
echo $password;



if ($stmt = $mysqlCon->prepare($sentenciaUpdatePassword)) {

	$stmt->bind_param('ss',$password,$usuario);

	if (!$stmt->execute()) {
		echo "Falló la ejecución: (" . $sentenciaUpdatePassword->errno . ") " . $sentenciaUpdatePassword->error;
		header("Location: ../../formularios/confirmacion.php?mensaje=26");
		exit;
	}
	$stmt->close();

	header("Location: ../../formularios/confirmacion.php?mensaje=25");
	exit;

} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=26");
	die("Errormessage: ". $mysqlCon->error);
	exit;
}