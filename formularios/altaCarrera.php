<?php
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
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<title>CSS MenuMaker</title>
</head>
<body>
<?php
include_once($pathMenu);
?>
<div id='cssformulario' class='cssformulario'>
	<form name="altaCarrera" id="altaCarrera" method="post" action="../dao/insert/guardarCarrera.php">
	<span>Nombre de la carrera:</span>
	<input type="text" id="nombreCarrera" name="nombreCarrera"/>
	<br/>
	<input type="submit" name="altaCarrera" id="altaCarrera" value="Alta Carrera">
	</form>
	
</div>
</body>
</html>