<?php

include ('query.php');
include '../../utiles/connectDBUtiles.php';

mostrarExcelUsuario();

function mostrarExcelUsuario(){
	global $mysqlCon;
	
	header("Content-Disposition: attachment; filename=Exportacion de usuarios.xls");
	header("Content-Type: application/vnd.ms-excel");
	$flag = false;
	
	$queryGlobal = "SELECT 
						DISTINCT CONCAT(usuario.nombre, ' ', usuario.apellido) as nombre, 
						role.role_desc as rol, 
						departamento.departamentos_desc as nombreDepartamento 
					from 
						usuario 
							inner join role on role.role_id = usuario.role_id 
							inner join usuariodepartamento on usuariodepartamento.usuario_id = usuario.usuario_id 
							inner join departamento on departamento.departamento_id = usuariodepartamento.departamento_id 
					ORDER BY nombre, nombreDepartamento ASC";

	$result = mysqli_query($mysqlCon, $queryGlobal);
	
	while($row = $result->fetch_assoc()) {
		if(!$flag) {
			// display field/column names as first row
			echo implode("\t", array_keys($row)) . "\r\n";
			$flag = true;
		}
		if ($row!=null){
			//array_walk($row, __NAMESPACE__ . '\cleanData');
			echo implode("\t", array_values($row)) . "\r\n";
		}
	}
	
}