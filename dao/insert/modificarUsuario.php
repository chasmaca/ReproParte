<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathBorrado = "borrado.php";
$pathInsert = "inserciones.php";

include_once($pathDB);
include_once($pathQuery);
include_once($pathInsert);
include_once($pathBorrado);

$nombre = utf8_decode(htmlspecialchars($_POST["nombre"]));
$apellido = utf8_decode(htmlspecialchars($_POST["apellido"]));
$logon = utf8_decode(htmlspecialchars($_POST["logon"]));
$role = htmlspecialchars($_POST["role"]);
$pwd = utf8_decode(htmlspecialchars($_POST["pwd"]));
$departamentoArray = htmlspecialchars($_POST["dptoArray"]);
$idUsuario = htmlspecialchars($_POST["id"]);
$departamento = null;

if (isset($_POST["seleccionado"]))
	$departamento = $_POST["seleccionado"];


$mensaje = "";

if ($stmt = $mysqlCon->prepare($sentenciaUpdateUsuario)) {
	global $idUsuario,$departamento;
	$stmt->bind_param('sssisi',trim($logon),trim($nombre),trim($apellido),$role,$pwd,$idUsuario);
	$stmt->execute();
	
	if ($departamento != null){
		
		borrarUsuarioDepartamento();
		
		$sqlMultiple = "INSERT INTO usuariodepartamento VALUES ";
		for($i = 0, $c = count($departamento); $i < $c; $i++){
			if ($i>0)
				$sqlMultiple .= ",";
			$sqlMultiple .= "(". $departamento[$i] . ",$idUsuario)";
		}
		$operacion = mysqli_query($mysqlCon,$sqlMultiple);
		
		if (!$operacion) {
			$mensaje =  "No se pudo ejecutar con exito la consulta ($sqlMultiple) en la BD: " . mysql_error();
			header("Location: ../../formularios/confirmacion.php?mensaje=2");
			exit;
		}
	}
} else {
	die("Mensaje de Error de usuario: ". $mysqlCon->error);
	header("Location: ../../formularios/confirmacion.php?mensaje=2");
	exit;
}

$stmt->close();
header("Location: ../../formularios/confirmacion.php?mensaje=1");
exit;

function consultaDptoAlta($departamentos){
	$departamentoArray = array();
	
	global $idUsuario,$mysqlCon,$recuperaDptoAlta;

	if ($departamentos!=null){
		
		for($i = 0, $c = count($departamentos); $i < $c; $i++){
	
			$sqlConsulta = "select departamento_id from usuariodepartamento where usuario_id = " . $idUsuario ." and departamento_id = " . $departamentos[$i];
			
			echo $sqlConsulta;
			$operacion = mysqli_query($mysqlCon,$sqlConsulta);
			
			if (!$operacion) {
				echo "No se pudo ejecutar con exito la consulta ($sqlConsulta) en la BD: " . mysql_error();
				header("Location: ../../formularios/confirmacion.php?mensaje=2");
				exit;
			}
			
			if (mysqli_num_rows($operacion) > 0) {
			}else{
				array_push($departamentoArray, $departamentos[$i]);
			}
		}
	}
	return $departamentoArray;
}

function borrarUsuarioDepartamento(){
	
	global $idUsuario,$mysqlCon,$borrarUsuarioDepartamento;
	
		if ($stmt = $mysqlCon->prepare($borrarUsuarioDepartamento)) {
			$stmt->bind_param('i',$idUsuario);
			$stmt->execute();
		} else {
			header("Location: ../../formularios/confirmacion.php?mensaje=2");
			exit;
			die("Error Al Actualizar el usuario: ". $mysqlCon->error);
		}
}
?>