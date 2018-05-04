<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

function login($username, $password)
{

	$path = "connectDBUtiles.php";
	include_once($path);
	
	$pathQuery = "../dao/select/query.php";
	include_once($pathQuery);
	
	$stmt = $mysqlCon->stmt_init();
	
	if ($stmt->prepare($loginQuery)) {
		$stmt->bind_param('ss', $username, $password);
		$stmt->execute();
		$stmt->store_result();
		$num_row = $stmt->num_rows;
		//usuario_id, nombre, apellido, role_id
		$stmt->bind_result($role_id);
		$stmt->fetch();
		$stmt->close();
	}else die("Failed to prepare query");


	if( $num_row === 1 ) {
		$_SESSION['roleid'] = $role_id;
		
		return true;
	}

	return false;

}