<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$pathCabecera = "../utiles/cabecera_login.php";
$path  = "../utiles/connectDBUtiles.php";
$pathConsulta = "../dao/select/departamentoAutorizador.php";
$pathSubdepartamento = "../dao/select/subdepartamento.php";
$pathAnalitica = "../utiles/analyticstracking.php";

include_once($path);
include_once($pathConsulta);
include_once($pathSubdepartamento);

$autorizadorCombo = "";
$departamentoCombo = "";

if( isset($_POST['autorizador']) ){
	$autorizadorCombo = $_POST["autorizador"];

	if($autorizadorCombo == 0 ){
		$departamentoResult = cargarTodosDepartamentos($mysqlCon);
	}else{
		$departamentoResult = cargarDptoAutorizador($mysqlCon);
	}
}

$subdepartamentoList = null;

if( isset($_POST['departamento']) ){
    $departamentoCombo = $_POST['departamento'];
    
    if ($departamentoCombo != 0){
        $subdepartamentoList = recuperaSubXDpto($departamentoCombo);
    }
}

if (!empty($_POST["subdepartamento"]))
    $idSub = htmlspecialchars($_POST["subdepartamento"]);
else
    $idSub = "";
    

?>
<html>
	<head>
		<meta charset='utf-8'/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" href="../css/estilos.css" />
		<script type="text/javascript" src="../js/nuevaSolicitud.js"/>
		<script type="text/javascript" src="../js/jquery.1.4.2.min.js"/>
		<script type="text/javascript" src="../js/select_replacement.1.0.0.js"/>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
  		<script src="//code.jquery.com/jquery-1.10.2.js"/>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"/>
		<script>
			$(function() {
				$( document ).tooltip();
			});
		</script>
		<title>Solicitud ENEASP</title>
	</head>
	<body> 
<?
		include_once($pathAnalitica);
?>
		<?php
		include_once($pathCabecera);
		// define variables and set to empty values
		$nombreErr = $apellidosErr = $emailErr = $autorizadorErr = $departamentoErr = $subdepartamentoErr = $commentErr = "";
		$nombre = $apellidos = $email = $autorizador = $comment = $departamento = $subdepartamento = "";
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
			if (empty($_POST["departamento"])) {
				$departamentoErr = "Debe Seleccionar un departamento";
			} else {
				$departamento = test_input($_POST["departamento"]);
			}
			
			if (empty($_POST["subdepartamento"])) {
			    $subdepartamentoErr = "Debe Seleccionar un subdepartamento";
			} else {
			    $subdepartamento = test_input($_POST["subdepartamento"]);
			}

			if (empty($_POST["autorizador"])) {
				$autorizadorErr = "Debe Seleccionar un Autorizador";
			} else {
				$autorizador = test_input($_POST["autorizador"]);
			}

			if (empty($_POST["nombre"])) {
				$nombreErr = "Debe introducir su nombre";
			} else {
				$nombre = test_input($_POST["nombre"]);
				// check if name only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z ]*$/",$nombre)) {
					$nombreErr = "Solo estan admitidos caracteres alfabéticos y espacios en blanco"; 
				}
			}

			if (empty($_POST["apellidos"])) {
				$apellidosErr = "Debe introducir sus apellidos";
			} else {
				$apellidos = test_input($_POST["apellidos"]);
				// check if name only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z ]*$/",$apellidos)) {
					$apellidosErr = "Solo estan admitidos caracteres alfabéticos y espacios en blanco";
				}
			}

			if (empty($_POST["email"])) {
				$emailErr = "Debe introducir un email valido";
			} else {
				$email = test_input($_POST["email"]);
				// check if e-mail address is well-formed
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$emailErr = "Formato Incorrecto de email"; 
				}
			}

			if (empty($_POST["comment"])) {
			     $commentErr = "Debe introducir los comentarios";
			   } else {
			     $comment = test_input($_POST["comment"]);
			   }
			}

			function test_input($data) {
			   $data = trim($data);
			   $data = stripslashes($data);
			   $data = htmlspecialchars($data);
			   return $data;
			}
?>
		<form name="nuevaSoliditudForm" method="post" action="" id="nuevaSolicitudForm">
		 <h1>Peticion de Reprograf&iacute;a</h1>
		  <div class="inset">
		  <label for="email">Autorizador*:</label>
			<select name="autorizador" id="autorizador" onchange="javascript:pasaValores();">
				<option value="0">Seleccione un Autorizador</option>
<?php
				include ('../dao/select/autorizador.php');
				
				$autorizadorResultSet = recuperaTodosValidadores($mysqlCon);
				
				
				while ($fila = mysqli_fetch_assoc($autorizadorResultSet)) {
?>
					<option value='<?php echo $fila["AUTORIZADOR_ID"]; ?>'
<?php 
						
							if ($fila["AUTORIZADOR_ID"] == $autorizadorCombo){
?>
							selected
<?php 
							}
?>
					>
					<?php echo utf8_encode($fila["AUTORIZADOR_NOMBRE"]); ?>&nbsp;<?php echo utf8_encode($fila["AUTORIZADOR_APELLIDOS"]); ?></option>
<?php 				
				}
				mysqli_free_result($autorizadorResultSet);
?>
			</select>
			<img src="../images/help.png" style="width:23px;" title="Campo obligatorio. Seleccione un autorizador de la lista." onclick="" onmouseover=""></img>
			<span class="error" id="errorAutorizador"  style="visibility:hidden; color:red;"><?php echo $autorizadorErr;?></span>
		   	<br/><br/>
			<label for="email">Departamento<span class="error">*</span>:</label>
			
			<select name="departamento" id="departamento" onchange="javascript:pasaValores();">
				<option value="0">Seleccione el Departamento</option>
<?php
				$departamentoResult = cargarDptoAutorizador($mysqlCon);
			//	include ('../dao/select/departamento.php');
				if ($departamentoResult != null){
				while ($fila = mysqli_fetch_assoc($departamentoResult)) {
?>
					<option value='<?php echo $fila["DEPARTAMENTO_ID"]; ?>'
<?php 
                        if ($fila["DEPARTAMENTO_ID"] == $departamentoCombo){
?>					
							selected
<?php 
				        }
?>							
					>
					<?php echo utf8_encode($fila["CECO"]) . " - " . utf8_encode($fila["DEPARTAMENTOS_DESC"]); ?></option>
<?php
				}
				mysqli_free_result($departamentoResult);
				}
?>
			</select>
		   	<img src="../images/help.png" style="width:23px;" title="Campo obligatorio. Seleccione un Departamento de la lista." onclick="" onmouseover=""></img>
		   	<span class="error" id="errorDepartamento" style="visibility:hidden; color:red;"><?php echo $departamentoErr;?></span>
		   	<br/><br/>
			<label for="email">Subdepartamento<span class="error">*</span>:</label>
			<select name="subdepartamento" id="subdepartamento">
				<option value="0">Seleccione el SubDepartamento</option>
<?php 
                    if ($subdepartamentoList != null){
                    for ($row = 0; $row < sizeof($subdepartamentoList); $row++){
                        if ($subdepartamentoList[$row][1] != ""){
?>
							<option value="<?php echo $subdepartamentoList[$row][1]; ?>"
<?php 
					           if ($idSub == $subdepartamentoList[$row][1]){
?>
								   selected 
<?php 
                                }
?>
							> <?php echo utf8_encode($subdepartamentoList[$row][2]);?></option>
<?php
                        }
                    }
                    }
?>
			</select>
		   	<img src="../images/help.png" style="width:23px;" title="Campo obligatorio. Seleccione un Subdepartamento de la lista." onclick="" onmouseover=""></img>
		   	<span class="error" id="errorSubDepartamento" style="visibility:hidden; color:red;"><?php echo $subdepartamentoErr;?></span>
		   	<br/><br/>
		   	<label for="email">Nombre*:</label>
		   	<img src="../images/help.png" style="width:23px;" title="Campo obligatorio. Introduzca su nombre." onclick="" onmouseover=""></img>
		   	<input type="text" name="nombre" id="nombre" value="<?php echo $nombre;?>"/>
		   	<span class="error" id="errorNombre" style="visibility:hidden; color:red;"><?php echo $nombreErr;?></span>
		   	<br/><br/>
		   	<label for="email">Apellidos*:</label>
		   	<img src="../images/help.png" style="width:23px;" title="Campo obligatorio. Introduzca su Apellido." onclick="" onmouseover=""></img>
		   	<input type="text" name="apellidos" id="apellidos" value="<?php echo $apellidos;?>"/>
		   	<span class="error" id="errorApellidos"  style="visibility:hidden; color:red;"><?php echo $apellidosErr;?></span>
		   	<br/><br/>
		   	<label for="email">E-mail*:</label> 
		   	<img src="../images/help.png" style="width:23px;" title="Campo obligatorio. Introduzca un correo donde pueda recibir las notificaciones." onclick="" onmouseover=""></img>
		   	<input type="text" name="email" id="email" value="<?php echo $email;?>"/>
		   	<span class="error" id="errorEmail"  style="visibility:hidden; color:red;"><?php echo $emailErr;?></span>
		   	<br/><br/>
		   	<label for="email">Observaciones*:</label>
		   		<img src="../images/help.png" style="width:23px;" title="Campo obligatorio. Introduzca las observaciones que considere oportunas." onclick="" onmouseover=""></img>
		   	<textarea name="comment" id="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
		   	<span class="error" id="errorComment"  style="visibility:hidden; color:red;"><?php echo $commentErr;?></span>
		   	<br/><br/>
		   	<input type="button" name="alta" value="Enviar" onclick="javascript:envioSolicitud();"/>
		   	</div> 
		</form>
		<script type="text/javascript">
			function handleSubmit() {
				alert('Form vars: '+$('#testForm').serialize(true));
				return false;
			}
			$(document).ready(function() {
				$('select').replaceSelects({
					replaceForIphone: false
				});
			});
		</script>
	</body>
</html>