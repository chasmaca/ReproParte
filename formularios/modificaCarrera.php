<?php
$path  = "../utiles/connectDBUtiles.php";
include_once($path);
$pathMenu = "../utiles/menu.php";
?>

<!doctype html>
<html lang=''>
<head>
<meta charset='utf-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/styles.css">
<link rel="stylesheet" href="../css/standard.css">
<script src="../js/modificaCarrera.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<title>CSS MenuMaker</title>
</head>
<body>
<?php
include_once($pathMenu);
?>
<div id='cssformulario' class='cssformulario'>
	<form name="modificaCarrera" id="modificaCarrera" method="post" action="../dao/update/modificarCarrera.php">
			Seleccione la Carrera a modificar:
			<select name="carrera" id="carrera" onchange="javascript:seleccionaValores(this);">
				<option value="0">Seleccione la Carrera</option>
<?php
				include ('../dao/select/carrera.php');
				while ($fila = mysqli_fetch_assoc($categoriaResult)) {
?>
					<option value='<?php echo $fila["CARRERA_ID"]; ?>'><?php echo $fila["CARRERA_DESC"]; ?></option>

<?php 				
				}
				mysqli_free_result($categoriaResult);
?>
			</select>
			
			
			<span>Nombre de la Carrera:</span>
			<input type="text" id="nombreCarrera" name="nombreCarrera"/> 
			<input type="hidden" id="idCarrera" name="idCarrera"/>
			
			<input type="submit" name="modificaCarrera" id="modificaCarrera" value="Modificar Carrera"/>
			
			</form>
			
			
</div>
</body>
</html>