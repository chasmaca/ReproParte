<?php

$pathDB = "../utiles/connectDBUtiles.php";
$pathCabecera = "../utiles/cabecera_formulario.php";

include_once($pathDB);
include_once($pathCabecera);

$mensaje = htmlspecialchars($_GET["mensaje"]);
$destino = "";
switch ($mensaje) {
	case 1:
		$error = "Operacion Realizada Con Exito.";
		$destino = "modificaUsuario.php";
		break;
	case 2:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "modificaUsuario.php";
		break;
	case 3:
		$error = "Operacion Realizada Con Exito.";
		$destino = "altaUsuario.php";
		break;
	case 4:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "altaUsuario.php";
		break;
	case 5:
		$error = "Operacion Realizada Con Exito.";
		$destino = "borraUsuario.php";
		break;
	case 6:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "borraUsuario.php";
		break;
	case 7:
		$error = "Operacion Realizada Con Exito.";
		$destino = "altaDepartamento.php";
		break;
	case 8:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "altaDepartamento.php";
		break;
	case 9:
		$error = "Operacion Realizada Con Exito.";
		$destino = "modificaDepartamento.php";
		break;
	case 10:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "modificaDepartamento.php";
		break;
	case 11:
		$error = "Operacion Realizada Con Exito.";
		$destino = "borraDepartamento.php";
		break;
	case 12:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "borraDepartamento.php";
		break;
	case 13:
		$error = "Operacion Realizada Con Exito.";
		$destino = "altaArticulo.php";
		break;
	case 14:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "altaArticulo.php";
		break;
	case 15:
		$error = "Operacion Realizada Con Exito.";
		$destino = "modificaArticulo.php";
		break;
	case 16:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "modificaArticulo.php";
		break;
	case 17:
		$error = "Operacion Realizada Con Exito.";
		$destino = "borraArticulo.php";
		break;
	case 18:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "borraArticulo.php";
		break;
	case 19:
		$error = "Operacion Realizada Con Exito.";
		$destino = "altaImpresoras.php";
		break;
	case 20:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "altaImpresoras.php";
		break;
	case 21:
		$error = "Operacion Realizada Con Exito.";
		$destino = "modificacionImpresoras.php";
		break;
	case 22:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "modificacionImpresoras.php";
		break;
	case 23:
		$error = "Operacion Realizada Con Exito.";
		$destino = "bajaImpresoras.php";
		break;
	case 24:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "bajaImpresoras.php";
		break;
	case 25:
		$error = "Operacion Realizada Con Exito.";
		$destino = "../index.php";
		break;
	case 26:
		$error = "Se ha producido un error, por favor, vuelva a intentarlo.";
		$destino = "myAccount/nuevaPassword.php";
		break;
}

?>

<!DOCTYPE HTML> 
<html>
	<head>
		<style>
			.error {color: #FF0000;}
		</style>
<link rel="stylesheet" href="../css/style-menu.css">
<link rel="stylesheet" href="../css/estilos.css">

		<script type="text/javascript" src="../js/accion.js"></script>
	</head>
	<body> 
<?php 
	include_once($pathCabecera);
?>
		<form name="modificaUsuarioConfirm" action="" method="post"  id="modificaUsuarioConfirm">
		 <h1>Peticion de Reprograf&iacute;a</h1>
		  <div class="inset" style="text-align:center;">
			<?php
				echo $error;
			?>
			<br>
			<input type="hidden" name="destino" id="destino" value="<?php echo $destino; ?>"/>
			<input type="button" name="accion" id="accion" onclick="javascript:envioAccion();" value="Continuar"> 
			<br><br>
			</div>
		</form>
	</body>
</html>