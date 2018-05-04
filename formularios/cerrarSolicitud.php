<?php

$path  = "../utiles/connectDBUtiles.php";
$pathInsert = "../dao/insert/inserciones.php";
$pathInsert = "../dao/update/updates.php";

include_once($path);
include_once($pathInsert);

$solicitud = htmlspecialchars($_GET["solicitud"]);
$status = 6;


global $sentenciaEstadoSolicitud;

echo $status . "," . $solicitud . "," . $sentenciaEstadoSolicitud;

	if ($stmt = $mysqlCon->prepare($sentenciaEstadoSolicitud)) {
		$stmt->bind_param('ii',$status,$solicitud);
		$stmt->execute();
	} else {
		die("Errormessage: ". $mysqlCon->error);
	}
	
	$stmt->close();
	
	$sentenciaFechaCierre = "update solicitud set fecha_cierre = now() where solicitud_id = " . $solicitud;
	
	//Realizamos la insercion
	mysqli_query($mysqlCon,$sentenciaFechaCierre);
	
	// Ahora comprobaremos que todo ha ido correctamente
	$my_error = mysqli_error($mysqlCon);
	
	if(!empty($my_error)) {
		$error = "Ha habido un error al insertar los valores. $my_error ";
	}
	
	header("Location: homeTrabajo.php");
	exit;
	


?>