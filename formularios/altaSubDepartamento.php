<?php
$path  = "../utiles/connectDBUtiles.php";
$pathMenu = "../utiles/menuhor.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include_once($path);

include ('../dao/select/departamento.php');

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
<script type="text/javascript">
    $(function() {
      if ($.browser.msie && $.browser.version.substr(0,1)<7)
      {
		$('li').has('ul').mouseover(function(){
			$(this).children('ul').show();
			}).mouseout(function(){
			$(this).children('ul').hide();
			})
      }
    });       
</script>
<script src="../js/altaDepartamento.js" type="text/javascript" ></script>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<title>Alta SubDepartamentos</title>
</head>
    <body>
<?php
        include_once($pathAnalitica);
        include_once($pathCabecera);
        include_once($pathMenu);
?>
        <div id='cssformulario' class='cssformulario'>
        
        	<form name="altaSubDepartamento" id="altaSubDepartamento" method="post" action="../dao/insert/guardarSubDepartamento.php">
        		<h2>Alta SubDepartamento</h2>		
        		<div class="inset">	
        			<span>Selecciona el Departamento:</span>
        			<select name="departamento" id="departamento" onchange="javascript:cargaValoresDpto();">
        				<option value="0">Seleccione el Departamento</option>
<?php 
        				$departamentoResult = recuperaTodosDepartamentos(); 
        				while ($fila = mysqli_fetch_assoc($departamentoResult)) {
?>
        				<option value='<?php echo $fila["DEPARTAMENTO_ID"]; ?>'><?php echo $fila["DEPARTAMENTOS_DESC"]; ?></option>
<?php 
        				}
        				mysqli_free_result($departamentoResult);
?>
        			</select>
        			<br/><br/>
        			<br/><br/>
        			<span>Nombre del SubDepartamento:</span>
        			<input type="text" id="nombreSubDepartamento" name="nombreSubDepartamento" value=""/> 
        			<br/><br/>
        			<span>Codigo 30 Barra :</span>
        			<input type="text" id="treintabarra" name="treintabarra" value="30/"/> 
        			<br/>
        			<br/>
        			<input type="button" name="guardaSubDepartamento" id="guardaSubDepartamento" value="Alta SubDepartamento" onclick="javascript:validaFormularioSub();"/>
        		</div>
        	</form>
        </div>
    </body>
</html>
