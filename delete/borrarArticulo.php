<?php
$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "borrado.php";
include_once($pathDB);
include_once($pathQuery);

$tipo = $_POST["tipoId"];
$detalle = $_POST["detalle"];

$detalleSimple = explode("-", $detalle);

global $mysqlCon,$sentenciaBorradoProducto;

if ($stmt = $mysqlCon->prepare($sentenciaBorradoProducto)) {
	$stmt->bind_param('ii',$detalleSimple[0],$tipo);
	$stmt->execute();
	
} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=18");
	exit;
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: ../../formularios/confirmacion.php?mensaje=17");
exit;
?>