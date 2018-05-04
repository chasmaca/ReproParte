<?php

$path  = "../utiles/connectDBUtiles.php";
$pathInsert = "../dao/insert/inserciones.php";
$pathUpdate = "../dao/update/updates.php";

include_once($path);
include_once($pathInsert);
include_once($pathUpdate);

$solicitud = htmlspecialchars($_GET["solicitudId"]);
$status = 5;

global $sentenciaEstadoSolicitud;

if ($stmt = $mysqlCon->prepare($sentenciaEstadoSolicitud)) {
	$stmt->bind_param('ii',$status,$solicitud);
	$stmt->execute();
} else {
	die("Errormessage: ". $mysqlCon->error);
}

$stmt->close();

header("Location: consultaTrabajos.php");
exit;

?>