<?php
$pathCabecera = "../utiles/cabecera_formulario.php";

?>
<!DOCTYPE HTML> 
<html>
	<head>
		<style>
			.error {color: #FF0000;}
		</style>
		<script type="text/javascript" src="../js/login.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<script>
		
			function validaDatos(){
				var envio = 0;

				if (document.getElementById('usuario').value==""){
					document.getElementById('errorUsuario').style.visibility = "visible";
					envio = 1;
				}
				
				var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

				if (re.test(document.getElementById('usuario').value)==false){
					document.getElementById('errorFormato').style.visibility = "visible";
					envio = 1;
				}
			    
				if (document.getElementById('pwd').value==""){
					document.getElementById('errorPwd').style.visibility = "visible";
					envio = 1;
				}

				if (envio==0){
					document.forms[0].submit();
				}
				
			}
			
		</script>
	</head>
	<body> 
	<?php
	include_once($pathCabecera);
	
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
		// define variables and set to empty values
		$usuarioErr = $pwdErr = "";
		$usuario = $pwd = "";
	//	if ( isset ( $_POST['login'] ) ){
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (empty($_POST["usuario"])) {
				$usuarioErr = "El usuario debe ser un correo valido.";
			} else {
				$usuario = test_input($_POST["usuario"]);
			}
			
			if (empty($_POST["pwd"])) {
				$pwdErr = "Debe rellenar el usuario";
			} else {
				$pwd = test_input($_POST["pwd"]);
			}
		}


?>
		<h2>Login</h2>
		<p><span class="error">* required field.</span></p>
		<form name="login" action="homeRedireccion.php" method="post">
			 Usuario: <input type="text" name="usuario" id="usuario" value="<?php echo $usuario;?>"/>*
		   	<span class="error" id="errorUsuario" style="visibility:hidden"> <?php echo $usuarioErr;?></span>
		   	<br><br>
			 Password: <input type="password" name="pwd" id="pwd" value="<?php echo $pwd;?>"/>*
		   	<span class="error" id="errorPwd" style="visibility:hidden"> <?php echo $pwdErr;?></span>
		   	<br><br>
		   	<input type="button" name="login" id="login" value="Entrar" onclick="javascript:validaDatos();">
		</form>
	</body>
</html>