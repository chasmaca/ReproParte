<?php
$pathMenu = "../utiles/menuhor.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";
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
<script src="../js/altaDepartamento.js" type="text/javascript" ></script>
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
<title>Alta Departamentos</title>
</head>
    <body>
<?php
        include_once($pathAnalitica);
        include_once($pathCabecera);
        include_once($pathMenu);
?>
        <div id='cssformulario' class='cssformulario'>
        
        	<form name="altaDepartamento" id="altaDepartamento" method="post" action="../dao/insert/guardarDepartamento.php">
        		<h2>Alta Departamento</h2>		
        		<div class="inset">	
        			<span>Nombre del departamento:</span>
        			<input type="text" id="nombreDepartamento" name="nombreDepartamento" value=""/> 
        			<br/><br/>
        			<span>CeCo:</span>
        			<input type="text" id="CeCo" name="CeCo" value=""/> 
        			<br/><br/>
        			<input type="button" name="guardaDepartamento" id="guardaDepartamento" value="Alta Departamento"/>
        		</div>
        	</form>
        </div>
    </body>
</html>
	