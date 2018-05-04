<?php 
$pathDB  = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";
$pathTipo = "../dao/select/tipo.php";
$pathMenu = "../utiles/menuhor.php";

include_once ($pathDB);
include_once($pathTipo);

?>
<!doctype html>
<html lang=''>
<head>
	<meta charset='utf-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/estilos.css">
	<script src="../js/altaArticulo.js" type="text/javascript" ></script>
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
	<title>Alta de Articulo</title>
</head>
	<body>
		<?php
		include_once($pathAnalitica);
		include_once($pathCabecera);
		include_once($pathMenu);
		?>
		<div id='cssformulario' class='cssformulario'>
		
			<form name="altaArticulo" id="altaArticulo" method="post" action="../dao/insert/guardarArticulo.php">
				<h2>Alta Art&iacute;culo</h2>
				<div class="inset">
				<span>Tipo</span>
				<select name="tipoId" id="tipoId">
	<?php
					while ($fila = mysqli_fetch_assoc($tipoResult)) {
	?>
					<option value='<?php echo $fila["TIPO_ID"]; ?>'><?php echo $fila["TIPO_DESC"]; ?></option>
	
	<?php 				
					}
					mysqli_free_result($tipoResult);
	?>
	
				</select>
				<br/><br/>
				<span>Descripcion:</span>
				<input type="text" id="nombreArticulo" name="nombreArticulo" />
				<br/><br/>
				<span>Precio:</span>
				<input type="text" id="precio" name="precio" />
				<br/><br/>
				<input type="button" name="altaArticuloSubmit" id="altaArticuloSubmit" value="Alta Articulo" onclick="javascript:validaFormulario();">
			</div>
			</form>
		</div>
	</body>
</html>