<?php
	include_once '../select/query.php';
	include '../../utiles/connectDBUtiles.php';
	
	//Declaracion de parametros
	$nombre = "";
	$apellido = "";
	$email = "";
	$role = "";

	//Recogemos los valores
	if( isset($_GET['nombre'])) {
		$nombre = $_GET['nombre'];
	}
	
	if( isset($_GET['apellido'])) {
		$apellido = $_GET['apellido'];
	}
	
	if( isset($_GET['email'])) {
		$email = $_GET['email'];
	}
	
	if( isset($_GET['role'])) {
		$role = $_GET['role'];
	}
	
	recuperamosUsuarios($nombre,$apellido,$email,$role);
	
	/**
	 * Funcion para la recuperacion de todos los datos de usuarios.
	 * Las consultas se haran en funcion de los parametros que se han recibido
	 * @param $nombre
	 * @param $apellido
	 * @param $email
	 * @param $role
	 */
	function recuperamosUsuarios($nombreParametro,$apellidoParametro,$emailParametro,$roleParametro){
		
		/*Declaramos como global la conexion y la query*/
		global $mysqlCon,$recuperaUsuariosConsulta;
		
		/*definimos el json*/
		$jsondata = array();
		$jsondata["data"] = array();
		
		/*Asignamos valores comodin para los string de la query en caso que vengan a nulo. 
		 * En el caso de role_id no es necesario porque desde el formulario no le damos opcion a que venga sin datos.*/
		if ($nombreParametro == "" || $nombreParametro == null)
			$nombreParametro = "%";
		
		if ($apellidoParametro == "" || $apellidoParametro == null)
			$apellidoParametro = "%";
		
		if ($emailParametro == "" || $emailParametro == null)
			$emailParametro = "%";
		


		if ($stmt = $mysqlCon->prepare($recuperaUsuariosConsulta)) {
			/*Asociacion de parametros*/
			$stmt->bind_param('sssi',$nombreParametro,$apellidoParametro,$emailParametro,$roleParametro);
			/*Ejecucion de la consulta*/
			$stmt->execute();
			
			/*Almacenamos el resultSet*/
			$stmt->bind_result($usuario_id,$logon, $nombre,$apellido,$role_id);
			
			while($stmt->fetch()) {
				
				$tmp = array();
				$tmp["usuario_id"] = $usuario_id;
				$tmp["logon"] = $logon;
				$tmp["nombre"] = utf8_decode($nombre);
				$tmp["apellido"] = utf8_decode($apellido);
				$tmp["role_id"] = $role_id;
			
				/*Asociamos el resultado en forma de array en el json*/
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