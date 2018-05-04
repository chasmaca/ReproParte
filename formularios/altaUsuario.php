<?php
$pathMenu = "../utiles/menuhor.php";

$path  = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include($path);
include ('../dao/select/departamento.php');

?>

<!doctype html>
<html lang=''>
<head>

<meta charset="ISO-8859-1">
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
<script type="text/javascript" src="../js/nuevoUsuario.js"></script>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<title>Alta de usuario</title>
</head>
<body>
<?php
	include_once($pathAnalitica);
	include_once($pathCabecera);
?>
<div id='pantallaCompleta' >
<?php 
include_once($pathMenu);
?>
<div id='cssformulario' class='cssformulario'>

	<form name="altaUsuario" id="altaUsuario" method="post" action="../dao/insert/guardarUsuario.php">
		<h2>Nuevo Usuario</h2>
		<div class="inset">
			<br/>
			<span>Nombre:</span><input type="text" id="nombre" name="nombre"/>
			<br/>
			<span>Apellido:</span><input type="text" id="apellido" name="apellido"/>
			<br/>
			<span>Email login:</span><input type="text" id="logon" name="logon"/>
			<br/>
			<span>Contrase&ntilde;a:</span><input type="password" id="pass" name="pass"/>
			<br/>
			<span>Rol:</span>
	
			<select name="role" id="role" onchange="javascript:habilitaCapa();" >
				<option value="1">Administrador</option>
				<option value="2">Gestor</option>
				<option value="3">Autorizador</option>
				<option value="4">Plantilla</option>
				<option value="6">Impresoras</option>
			 </select>
			<br/>
			<div id="capaAutorizador"  style="visibility:hidden">
				<label for="departamento">Seleccione el departamento*:</label>
				<select multiple size="5" id="departamento" name="departamento">
<?php 
					$departamentoResult = recuperaTodosDepartamentos();
					while ($fila = mysqli_fetch_assoc($departamentoResult)) {
?>
					<option value='<?php echo $fila["DEPARTAMENTO_ID"]; ?>' id="<?php echo $fila["DEPARTAMENTO_ID"]; ?>"><?php echo $fila["DEPARTAMENTOS_DESC"]; ?></option>
<?php 
					}
					mysqli_free_result($departamentoResult);
?>
				</select>
				<br/><br/>
			 	<label for="departamento">Departamento Asignado:</label>
				<select multiple size="5" id="seleccionado" name="seleccionado[]" >
				</select>
			</div>

	<script>
	$().ready(function() {  
		 $('#departamento').click(function() {  
		  return !$('#departamento option:selected').remove().appendTo('#seleccionado');  
		 }); 
		 $('#seleccionado').click(function() {
		  return !$('#seleccionado option:selected').remove().appendTo('#departamento');  
		 });  
		});  
	</script>
	
	<input type="hidden" name="dpto" id="dpto">
	<br/>
	<input type="button" name="altaUsuarioSubmit" id="altaUsuarioSubmit" value="Alta Usuario" onclick="javascript:validaFormulario();">
	</div>
	</form>
	
</div>
</div>
</body>
</html>