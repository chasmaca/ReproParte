<?php
session_start();

include_once("../../utiles/connectDBUtiles.php");
include_once("../update/updates.php");

$solicitud = $_GET["solicitudId"];
$status = $_GET["status"];

if ($status==5)
	updateSolicitud($status,$solicitud);

if ($status == 4){
		$usuarioPlantilla = $_SESSION["nombre_session"];
		guardarSolicitudPorUsuario($status,$solicitud,$usuarioPlantilla);
}

if ($status==6)
	cerrarSolicitud($status,$solicitud);

function updateSolicitud($status,$solicitud){
	global $mysqlCon, $sentenciaEstadoSolicitud,$sentenciaEstadoSolicitudPlantilla;
	$jsondata = array();
	
		if ($stmt = $mysqlCon->prepare($sentenciaEstadoSolicitud)) {
			$stmt->bind_param('ii',$status,$solicitud);
			if (!$stmt->execute()){
				$jsondata["success"] = false;
				$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;
			}else 
				$jsondata["success"] = true;
			
		} else {
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;
		}
		
		$stmt->close();
		
		/*Devolvemos el JSON con los datos de la consulta*/
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
	
}

function guardarSolicitudPorUsuario($status,$solicitud,$usuarioPlantilla){
	global $mysqlCon, $sentenciaEstadoSolicitudPlantilla;
	$jsondata = array();
	
	if ($stmt = $mysqlCon->prepare($sentenciaEstadoSolicitudPlantilla)) {

		$stmt->bind_param('isi',$status,$usuarioPlantilla,$solicitud );
	
			if (!$stmt->execute()){
				$jsondata["success"] = false;
				$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;
			}else
				$jsondata["success"] = true;
		
	}
	
	$stmt->close();
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	

}

function cerrarSolicitud($status,$solicitud){
	global $mysqlCon, $sentenciaStatus6Solicitud;
	$jsondata = array();
	
	if ($stmt = $mysqlCon->prepare($sentenciaStatus6Solicitud)) {
		
		$stmt->bind_param('ii',$status,$solicitud );
		
		if (!$stmt->execute()){
			$jsondata["success"] = false;
			$jsondata["errorMessage"] = "Errormessage: ". $mysqlCon->error;
		}else
			$jsondata["success"] = true;
		
	}
	
	$stmt->close();
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	
}