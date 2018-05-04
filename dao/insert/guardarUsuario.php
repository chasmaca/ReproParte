<?php

$pathDB = "../../utiles/connectDBUtiles.php";
$pathQuery = "../select/query.php";
$pathInsert = "inserciones.php";
$pathSubdpto = "../select/subdepartamento.php";


include_once($pathDB);
include_once($pathQuery);
include_once($pathInsert);
include_once($pathSubdpto);

$nombre = utf8_decode(htmlspecialchars($_POST["nombre"]));
$apellido = utf8_decode(htmlspecialchars($_POST["apellido"]));
$logon = utf8_decode(htmlspecialchars($_POST["logon"]));
$pass = utf8_decode(htmlspecialchars($_POST["pass"]));
$role = htmlspecialchars($_POST["role"]);

if (isset($_POST["seleccionado"]))
	$departamento = $_POST["seleccionado"];
else
	$departamento = null;

$usuarioResult = mysqli_query($mysqlCon,$recuperaMaxUsuario);
$idUsuario = 0;

if (!$usuarioResult) {
	echo "No se pudo ejecutar con exito la consulta ($recuperaMaxUsuario) en la BD: " . mysql_error();
	header("Location: ../../formularios/confirmacion.php?mensaje=4");
	exit;
}

if (mysqli_num_rows($usuarioResult) == 0) {
	echo "No se han encontrado filas, nada a imprimir, asi que voy a detenerme.";
	$idUsuario = 1;
}else{
	while ($fila = mysqli_fetch_assoc($usuarioResult)) {
		global $idUsuario;
		$idUsuario = $fila["idUsuario"];
	}
	mysqli_free_result($usuarioResult);
}

$logon = trim($logon);
$pass = trim($pass);
$nombre = trim($nombre);
$apellido = trim($apellido);

if ($stmt = $mysqlCon->prepare($sentenciaInsertUsuario)) {
	global $idUsuario;
	$stmt->bind_param('issssi',$idUsuario,$logon,$pass,$nombre,$apellido,$role);
	$stmt->execute();
} else {
	header("Location: ../../formularios/confirmacion.php?mensaje=4");
	exit;
	die("Mensaje de Error de usuario: ". $mysqlCon->error);
}

$stmt->close();

for($i = 0, $c = count($departamento); $i < $c; $i++){
	if ($departamento[$i] !== ""){
		if ($stmt = $mysqlCon->prepare($sentenciaInsertUsuarioValida)) {
			global $idUsuario;
            
			$subdepartamentos = recuperaIdSubXDpto($departamento[$i]);
			
			if ($subdepartamentos != null){
                $subdepartamento = explode(",", $subdepartamentos);
                for ($x=0; $x<count($subdepartamento);$x++){
                    $stmt->bind_param('iii',$departamento[$i],$idUsuario,$subdepartamento[$x]);
                    $stmt->execute();
			     }
			}else{
			    $stmt->bind_param('iii',$departamento[$i],$idUsuario,null);
			    $stmt->execute();
			}
			
			
			
		} else {
			header("Location: ../../formularios/confirmacion.php?mensaje=4");
			exit;
			die("Mensaje de Error de usuario Validador: ". $mysqlCon->error . $sentenciaInsertUsuarioValida . " con valores " . $departamento[$i] ."," . $idUsuario);
		}
	}
}


$stmt->close();


header("Location: ../../formularios/confirmacion.php?mensaje=3");
exit;

?>