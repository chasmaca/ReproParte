<?php
$pathMenu = "../utiles/menuhor.php";
$pathCabecera ="../utiles/cabecera_formulario.php";
$pathAnalitica = "../utiles/analyticstracking.php";

?>

<!doctype html>
<html lang=''>
<head>
<meta charset='utf-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
<link rel="stylesheet" href="../css/styles.css">
<link rel="stylesheet" href="../css/estilos.css">

<title>Administraci&oacute;n</title>
</head>
	<body>
		

<?php 
	include_once($pathAnalitica);
	include_once($pathCabecera);
	include_once($pathMenu);
?>
</body>
</html>