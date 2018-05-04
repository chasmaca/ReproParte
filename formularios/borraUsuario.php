<?php
$pathMenu = "../utiles/menuhor.php";
$path  = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include_once($path);
include ('../dao/select/usuarios.php');

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
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<title>Borrar Usuario</title>
</head>
<body>
<?php
	include_once($pathAnalitica);
	include_once($pathCabecera);
	include_once($pathMenu);
?>
<div id='cssformulario' class='cssformulario'>

			<form name="borraUsuario" id="borraUsuario" method="post" action="../dao/insert/borrarUsuario.php">
				<h2>Borrar Usuario</h2>	
				<div class="inset">
					Seleccione el Usuario:
					<select name="usuarioId" id="usuarioId">
						<option value="0">Seleccione el usuario</option>
<?php
						while ($fila = mysqli_fetch_assoc($usuariosResult)) {
?>
							<option value='<?php echo $fila["USUARIO_ID"]; ?>'><?php echo $fila["NOMBRE"] . " " . $fila["APELLIDO"];?></option>
					
<?php
						}
						mysqli_free_result($usuariosResult);
?>
					</select>
			
					<br><br>
					<input type="submit" name="borraUsuarioSubmit" id="borraUsuarioSubmit" value="Borrar Usuario"/>
				</div>
			</form>
		</div>
	</body>
</html>