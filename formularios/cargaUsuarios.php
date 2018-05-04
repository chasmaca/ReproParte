<?php

$path  = "../utiles/connectDBUtiles.php";
include_once($path);
$pathQuery = "../dao/select/query.php";
include_once($pathQuery);

$usuario = $_POST["usuario"];

global $consultaUsuarioQuery,$consultaUsuarioValidador;

$idUsuario = $logon = $nombre = $apellidos = $role = $departamento = "";

/*Prepare Statement*/
if ($stmt = $mysqlCon->prepare($consultaUsuarioQuery)) {
	/*Asociacion de parametros*/
	$stmt->bind_param('i',$usuario);
	/*Ejecucion*/
	$stmt->execute();
	/*Asociacion de resultados*/
	$stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6);
	/*Recogemos el resultado en la variable*/
	while ($stmt->fetch()) {
		$idUsuario = $col1;
		$logon = $col2;
		$nombre = $col3;
		$apellidos = $col4;
		$role = $col5;
		$password = $col6;
	}
	/*Cerramos la conexion*/
	$stmt->close();
}else{
	echo "NO SE EJECUTA";
}

/*Prepare Statement*/
if ($stmt = $mysqlCon->prepare($consultaUsuarioValidador)) {
	/*Asociacion de parametros*/
	$stmt->bind_param('i',$usuario);
	/*Ejecucion*/
	$stmt->execute();
	/*Asociacion de resultados*/
	$stmt->bind_result($col1);
	/*Recogemos el resultado en la variable*/
	while ($stmt->fetch()) {
		$departamento = $idUsuario . "|" . $col1;
	}
	/*Cerramos la conexion*/
	$stmt->close();
}else{
	echo "NO SE EJECUTA";
}

?>

<html>
	<body  onload="javascript:document.forms[0].submit();">
		<form name="modificarUsuarios" method="post" action="modificaUsuario.php" >
			<input type="hidden" name="idUsuario" value="<?php echo $idUsuario ?>"/>
			<input type="hidden" name="logon" value="<?php echo $logon ?>"/>
			<input type="hidden" name="nombre" value="<?php echo $nombre ?> "/>
			<input type="hidden" name="apellidos" value="<?php echo $apellidos ?> "/>
			<input type="hidden" name="role" value="<?php echo $role ?> "/>
			<input type="hidden" name="departamento" value="<?php echo $departamento ?> "/>
			<input type="hidden" name="password" value="<?php echo $password ?> "/>
		</form>
	</body>
</html>
