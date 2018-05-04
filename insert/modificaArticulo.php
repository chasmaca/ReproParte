<?php
$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "inserciones.php";
include_once($pathDB);
include_once($pathQuery);

$tipo = $_POST["tipoId"];
$detalle = $_POST["detalle"];
$nombre = utf8_decode($_POST["nombreDetalle"]);
$precio = $_POST["precioDetalle"];

$detalleSimple = explode("-", $detalle);

global $mysqlCon,$sentenciaUpdateProducto;

if ($stmt = $mysqlCon->prepare($sentenciaUpdateProducto)) {
	$stmt->bind_param('sdii',trim($nombre),$precio,$detalleSimple[0],$tipo);
	$stmt->execute();
} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=16");
	exit;
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: ../../formularios/confirmacion.php?mensaje=15");
	exit;
?>