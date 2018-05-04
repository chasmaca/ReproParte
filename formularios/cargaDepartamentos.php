<?php

$path  = "../utiles/connectDBUtiles.php";
include_once($path);
$pathQuery = "../dao/select/query.php";
include_once($pathQuery);

$departamento = $_POST["departamento"];

global $departamento,$actualizaDepartamentoQuery;

$idDepartamento = $descDepartamento = $treintaDepartamento = $cecoDepartamento = "";

/*Prepare Statement*/
if ($stmt = $mysqlCon->prepare($actualizaDepartamentoQuery)) {
		/*Asociacion de parametros*/
		$stmt->bind_param('i',$departamento);
		/*Ejecucion*/
		$stmt->execute();
		/*Asociacion de resultados*/
		$stmt->bind_result($col1,$col2,$col3);
		/*Recogemos el resultado en la variable*/
		while ($stmt->fetch()) {
			$idDepartamento = $col1;
			$descDepartamento = $col2;
			$cecoDepartamento = $col3;
		}
		/*Cerramos la conexion*/
		$stmt->close();
	}else{
		echo "NO SE EJECUTA";
	}

?>
<html>
<body  onload="javascript:document.forms[0].submit();">
<form name="modificarDpto" method="post" action="modificaDepartamento.php" >
	<input type="hidden" name="idDepartamento" value="<?php echo $idDepartamento ?>"/>
	<input type="hidden" name="descDepartamento" value="<?php echo $descDepartamento ?>"/>
	<input type="hidden" name="cecoDepartamento" value="<?php echo $cecoDepartamento ?> "/>
</form>
</body>
</html>
	