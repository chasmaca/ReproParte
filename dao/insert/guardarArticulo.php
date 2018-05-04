<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathDetalle =  "../select/detalle.php";

$pathInsert = "inserciones.php";

include_once($pathDB);
include_once($pathQuery);
include_once($pathInsert);
include_once($pathDetalle);

$tipo = htmlspecialchars($_POST["tipoId"]);
$descripcion =  utf8_decode(htmlspecialchars($_POST["nombreArticulo"]));
$precio = htmlspecialchars($_POST["precio"]);
$detalle = recuperaMaximoPorTipo($mysqlCon,$tipo);

if ($stmt = $mysqlCon->prepare($sentenciaInsertArticulo)) {
	$stmt->bind_param('iisd',$detalle,$tipo,trim($descripcion),$precio);
	$stmt->execute();
} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=14");
	exit;
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: ../../formularios/confirmacion.php?mensaje=13");
exit;

?>