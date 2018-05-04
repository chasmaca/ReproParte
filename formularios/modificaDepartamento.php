<?php
$path  = "../utiles/connectDBUtiles.php";
include($path);
$pathMenu = "../utiles/menuhor.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include ('../dao/select/departamento.php');

    if (!empty($_POST["idDepartamento"]))
        $id = htmlspecialchars($_POST["idDepartamento"]);
    else
        $id = "";
    
    if (!empty($_POST["descDepartamento"]))
        $des = utf8_decode($_POST["descDepartamento"]);
    else
        $des = "";
    
    if (!empty($_POST["cecoDepartamento"]) != null)
        $ceco = htmlspecialchars($_POST["cecoDepartamento"]);
    else
        $ceco = "";

?>

<!doctype html>
<html lang=''>
<head>
<meta charset='utf-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/estilos.css">
<link rel="stylesheet" href="../css/styles.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="../js/modificaDepartamento.js" type="text/javascript" ></script>
<title>Modificar Departamentos</title>
</head>
<body>
<?php
include_once($pathAnalitica);
include_once($pathCabecera);
include_once($pathMenu);

?>
<div id='cssformulario' class='cssformulario'>

	<form name="modificaDepartamento" id="modificaDepartamento" method="post" action="../dao/update/modificarDepartamento.php">
			<h2>Modificar Departamento</h2>
			<div class="inset">	
			Seleccione el departamento a modificar:
			<select name="departamento" id="departamento">

			</select>
			
			<br/><br/>
			<span>Nombre del Departamento:</span>
			<input type="text" id="nombreDepartamento" name="nombreDepartamento" value="<?php echo utf8_encode($des); ?>"/> 
			<br/><br/>
			<span>CeCo:</span>
			<input type="text" id="CeCo" name="CeCo" value="<?php echo $ceco ?>"/> 
			<input type="hidden" id="idDepartamento" name="idDepartamento" value="<?php echo $id ?>"/>
			<br/><br/>
			<input type="button" name="modificaDpto" id="modificaDpto" value="Modificar Departamento"/>
		</div>
			</form>
		</div>
	</body>
</html>