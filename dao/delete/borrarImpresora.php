<?php
$pathDB = "../../utiles/connectDBUtiles.php";
$pathInsert = "borrado.php";

include_once($pathDB);
include_once($pathInsert);

$impresora = htmlspecialchars($_POST["impresora"]);

if ($stmt = $mysqlCon->prepare($borrarImpresora)) {
	$stmt->bind_param('i',$impresora);
	$stmt->execute();
} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=24");
	exit;
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: ../../formularios/confirmacion.php?mensaje=23");
exit;

?>

