<?php
$path  = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";
$pathMenu = "../utiles/menuhor.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include_once($path);
include ('../dao/select/departamento.php');
include_once ('../dao/select/role.php');
include_once ('../dao/select/usuarios.php');

$usuarioCombo = null;
if( isset($_POST['idUsuario']) ){
	$usuarioCombo = $_POST["idUsuario"];
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
			<script src="../js/modificaUsuario.js" type="text/javascript" ></script>
			<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
			<title>Modifica Usuario</title>
		</head>
		<body onload="javascript:muestraCapa();">
<?php
	include_once($pathAnalitica);
	include_once($pathCabecera);
	include_once($pathMenu);
?>
			<div id='cssformulario' class='cssformulario'>
				
				<form name="modificaUsuario" id="modificaUsuario" method="post" action="../dao/update/modificarUsuario.php">
				<h2>Modificar Usuario</h2>
				<div class="inset">
					Seleccione el Usuario:
					<select name="usuario" id="usuario" onchange="javascript:rellenaCampos();">
						<option value="0">Seleccione el usuario</option>
<?php
						while ($fila = mysqli_fetch_assoc($usuariosResult)) {
?>
							<option value='<?php echo $fila["USUARIO_ID"]; ?>'
<?php 
								if ($fila["USUARIO_ID"] == $usuarioCombo){
?>
									selected
<?php 
								}
?>
							>
								<?php echo $fila["NOMBRE"] . " " . $fila["APELLIDO"];?>
							</option>
<?php
						}
						mysqli_free_result($usuariosResult);
?>
					</select>
<?php 
					if (!empty($_POST["idUsuario"]))
						$idUsuario = htmlspecialchars($_POST["idUsuario"]);	
					else
						$idUsuario = "";

					if (!empty($_POST["logon"]) != null)
						$logon = htmlspecialchars($_POST["logon"]);
					else
						$logon = "";
			
					if (!empty($_POST["nombre"]) != null)
						$nombre = htmlspecialchars($_POST["nombre"]);
					else
						$nombre = "";
			
					if (!empty($_POST["apellidos"]) != null)
						$apellidos = htmlspecialchars($_POST["apellidos"]);
					else
						$apellidos = "";
					
					if (!empty($_POST["role"]) != null)
						$role = htmlspecialchars($_POST["role"]);
					else
						$role = "";
			
					if (!empty($_POST["departamento"]) != null)
						$departamento = htmlspecialchars($_POST["departamento"]);
					else
						$departamento = "";
					
					if (!empty($_POST["password"]) != null)
						$password = htmlspecialchars($_POST["password"]);
					else
						$password = "";
					
?>
					<input type="hidden" name='id' id="id" value='<?php echo $idUsuario ?>' />
					<div id="datosUsuario" id="datosUsuario"  style="visibility:hidden;">
						<br/><br/>
						Logon:<input type="text" name='logon' id="logon" value='<?php echo $logon ?>'/>
						<br/><br/>
						Password:<input type="text" name='pwd' id="pwd" value='<?php echo $password ?>'/>
						<br/><br/>
						Nombre:
						<input type="text" name='nombre' id="nombre" value='<?php echo $nombre ?>'/>
						<br/><br/>
						Apellidos:
						<input type="text" name='apellido' id="apellido" value='<?php echo $apellidos ?>'/>
						<br/><br/>
						Role:
						
						<select name="role" id="role" onchange="javascript:ocultarCapa(this);">
<?php

						$roleResult = recuperaTodosRoles();
						while ($fila = mysqli_fetch_assoc($roleResult)) {
?>
							<option value='<?php echo $fila["role_id"]; ?>'
<?php 
								if (intval($fila["role_id"]) == intval($role)){
?>
									selected
<?php 
								}
?>
							>
								<?php echo $fila["role_desc"] ?>
							</option>
<?php
						}
						mysqli_free_result($roleResult);
?>
						</select>
						
						<!-- input type="text" name='role' id="role" value='echo $role '/-->
						<br/><br/>
						<input type="hidden" name='departamento' value='<?php echo $departamento ?>'/>
						<div id="divDpto" id="divDpto"   style="visibility:hidden;">
							Departamentos:
							<select multiple size="5" id="departamento" name="departamento" onclick="javascript:sumaDpto();">
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
							<br><br>
							<label for="departamento">Departamento Asignado:</label>
		 					<select multiple size="5" id="seleccionado" name="seleccionado[]" >
<?php 
								$dptoUsuarioResult = recuperaDepartamentoPorAutorizador($idUsuario);
								if ($dptoUsuarioResult!= null){
								while ($fila = mysqli_fetch_assoc($dptoUsuarioResult)) {
?>
									<option value='<?php echo $fila["DEPARTAMENTO_ID"]; ?>'><?php echo $fila["DEPARTAMENTOS_DESC"]; ?></option>
<?php 
								}
								mysqli_free_result($dptoUsuarioResult);
								}
?>
		 					</select>
						</div>
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
					<br/><br/>
					<input type="hidden" id="dptoArray" name="dptoArray" value="">
					<input type="button" name="actualizar" value="Actualizar" id="actualizar" onclick="habilitaSeleccion();">
				</div>
				</form>
			</div>
		</body>
	</html>