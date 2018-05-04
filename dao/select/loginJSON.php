<?php
session_start();
include ('query.php');
include '../../utiles/connectDBUtiles.php';

/*Definimos las variables*/
$usuario = "";
$password = "";

/*Recuperamos la request*/
if( isset($_POST['usuario'])) {
	$usuario = utf8_decode($_POST['usuario']);
}

/*Recuperamos la request*/
if( isset($_POST['password'])) {
	$password = utf8_decode($_POST['password']);
}else{
	$password ="NOOOO";
}

/*Realizamos la llamada a la funcion*/
if ($usuario != "" && $password != "")
	recuperaUsuario($usuario,$password);

	function recuperaUsuario($usuario,$password){
		
		global $sentenciaLogonJSON,$mysqlCon;
		
		$usuario_id = "";
		$logon = "";
		$nombre = "";
		$apellido = "";
		$role_id = "";
		
		/*definimos el json*/
		$jsondata = array();
		$jsondata["data"] = array();
		
		/*Prepare Statement*/
		if ($stmt = $mysqlCon->prepare($sentenciaLogonJSON)) {
		
			/*Asociacion de parametros*/
			$stmt->bind_param('ss',$usuario,$password);
			
			/*Ejecucion*/
			if ($stmt->execute()){
				
				/*Almacenamos el resultSet*/
				$stmt->bind_result($usuario_id, $logon, $password, $nombre, $apellido, $role_id);
				/*Incluimos las lineas de la consulta en el json a devolver*/
				$jsondata["message"] = "Errormessage: NO Pasa " . $sentenciaLogonJSON . $usuario . "," . $password;
				while($stmt->fetch()) {
					$_SESSION["role_session"] = $role_id;
					$_SESSION["nombre_session"] = $nombre . " " . $apellido;
					$_SESSION["userId_session"] = $usuario_id;
				
					$tmp = array();
					$tmp["usuario_id"] = $usuario_id;
					$tmp["logon"] = $logon;
					$tmp["password"] = $password;
					$tmp["nombre"] = $nombre;
					$tmp["apellido"] = $apellido;
					$tmp["role_id"] = $role_id;
					array_push($jsondata["data"], $tmp);
					$jsondata["message"] = "Errormessage: Pasa" . $sentenciaLogonJSON . $usuario . "," . $password;
				}

				$jsondata["success"] = true;
			}else{
				$jsondata["success"] = false;
				$jsondata["message"] = "Errormessage: ". $mysqlCon->error . " " . $sentenciaLogonJSON;
			}
		} else {
			/*Llegamos aqui con error, asociamos false para identificarlo en el js*/
			$jsondata["success"] = false;
			$jsondata["message"] = "Errormessage: ". $mysqlCon->error . " " . $sentenciaLogonJSON;
		}
		
		$stmt->close();
		
		/*Devolvemos el JSON con los datos de la consulta*/
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
	}
?>