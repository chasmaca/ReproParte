<?php

	include ('query.php');
	include '../../utiles/connectDBUtiles.php';

	recuperaUsuarios();

	function recuperaUsuarios(){
		
		global $recuperaTodosUsuarios,$mysqlCon;
		
		/*definimos el json*/
		$jsondata = array();
		$jsondata["data"] = array();
		
		
		/*Prepare Statement*/
		if ($stmt = $mysqlCon->prepare($recuperaTodosUsuarios)) {
			
			/*Ejecucion*/
			$stmt->execute();
			//SELECT CONCAT(usuario.nombre, ' ', usuario.apellido) as nombre, role.role_desc as rol, departamento.departamentos_desc as nombreDepartamento, subdepartamento.subdepartamento_desc as nombreSubdepartamento
			/*Almacenamos el resultSet*/
			$stmt->bind_result($nombre, $rol, $nombreDepartamento);

			/*Incluimos las lineas de la consulta en el json a devolver*/
			while($stmt->fetch()) {
				$tmp = array();
				$tmp["nombre"] = utf8_encode($nombre);
				$tmp["rol"] = utf8_encode($rol);
				$tmp["nombreDepartamento"] = utf8_encode($nombreDepartamento);
			
				array_push($jsondata["data"], $tmp);
			}
			$stmt->close();
			/*Asociamos el correcto funcionamiento al json para comprobar en el js*/
			$jsondata["success"] = true;
			} else {
				/*Llegamos aqui con error, asociamos false para identificarlo en el js*/
				$jsondata["success"] = false;
				die("Errormessage: ". $mysqlCon->error);
			}
	
	/*Devolvemos el JSON con los datos de la consulta*/
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
			
}
?>