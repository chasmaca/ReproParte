<?php

include ('query.php');

$usuario = htmlspecialchars($_POST["usuario"]);
$password = htmlspecialchars($_POST["pwd"]);

$whereQuery = " WHERE LOGON = '" .$usuario . "' AND PASSWORD = '" . $password . "'";
$queryTotal = $loginQuery . $whereQuery;

$loginResult = mysqli_query($mysqlCon,$queryTotal);

if (!$loginResult) {
	echo "No se pudo ejecutar con exito la consulta ($queryTotal) en la BD: ";
	exit;
}

if (mysqli_num_rows($loginResult) == 0 || mysqli_num_rows($loginResult) == null) {
	header("Location: ../index.php?error=1");
	exit;
}

if (mysqli_num_rows($loginResult) > 0) {
	while($row = $loginResult->fetch_assoc()) {

		$_SESSION["role_session"] = $row["role_id"];
		$_SESSION["nombre_session"] = $row["nombre"] . " " . $row["apellido"];
		$_SESSION["userId_session"] = $row["usuario_id"];
	}
	
}else{
	header("Location: ../index.php?error=1");
	exit;
}
?>