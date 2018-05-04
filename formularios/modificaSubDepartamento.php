<?php
    $path  = "../utiles/connectDBUtiles.php";
    include($path);
    $pathMenu = "../utiles/menuhor.php";
    $pathCabecera = "../utiles/cabecera_formulario.php";
    $pathAnalitica = "../utiles/analyticstracking.php";

    include ('../dao/select/departamento.php');
    include ('../dao/select/subdepartamento.php');

    $dptoCombo = null;

    if (!empty($_POST["departamento"]))
        $id = htmlspecialchars($_POST["departamento"]);
    else
        $id = "";

    if (!empty($_POST["subdepartamento"]))
        $idSub = htmlspecialchars($_POST["subdepartamento"]);
    else
        $idSub = "";

    if (!empty($_POST["nombreSubDepartamento"]))
        $des = htmlspecialchars($_POST["nombreSubDepartamento"]);
    else
        $des = "";

    if (!empty($_POST["treintabarra"]) != null)
        $treinta = htmlspecialchars($_POST["treintabarra"]);
    else
        $treinta = "";

    $cadenaValor = null;
        
    if( isset($_POST['departamento']) ){
        $dptoCombo = $_POST["departamento"];
        if($dptoCombo != 0 ){
            $cadenaValor = recuperaSubXDpto($dptoCombo);
        }else{
            $cadenaValor = null;
        }
    }

    $valores = "";
    

    if ( $cadenaValor != null){
        for ($row = 0; $row < sizeof($cadenaValor); $row++){
            if ($valores == "")
                $valores = implode(";", $cadenaValor[$row]);
            else 
                $valores .= "|" . implode(";", $cadenaValor[$row]);
        }
    }
    
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
<script src="../js/modificaSubDepartamento.js" type="text/javascript" ></script>
<title>Modificar SubDepartamentos</title>
</head>
<body>
<?php
include_once($pathAnalitica);
include_once($pathCabecera);
include_once($pathMenu);

?>
<div id='cssformulario' class='cssformulario'>

	<form name="modificaSubDepartamento" id="modificaSubDepartamento" method="post" action="../dao/update/modificarSubDepartamento.php">
			<h2>Modificar SubDepartamento</h2>
			<div class="inset">	
			
			Seleccione el departamento a modificar:
			<select name="departamento" id="departamento" >

				</select>
    			<br/><br/>
				
				Seleccione el subdepartamento a modificar:
				<select name="subdepartamento" id="subdepartamento">
					<option value="0">Seleccione el SubDepartamento</option>

    			</select>
    			<br/><br/>
				<input type="hidden" name="arrayValores" id="arrayValores" value="<?php print_r ($valores); ?>"/>
    			<span>Nombre del SubDepartamento:</span>
    			<input type="text" id="nombreSubDepartamento" name="nombreSubDepartamento" value="<?php echo $des; ?>"/> 
    			<br/><br/>

    			<span>CeCo:</span>
    			<input type="text" id="treintabarra" name="treintabarra" value="<?php echo $treinta; ?>"/> 
    			<br/><br/>

    			<input type="button" name="modificaSubDpto" id="modificaSubDpto" value="Modificar SubDepartamento"/>
			</div>
			</form>
		</div>
	</body>
</html>