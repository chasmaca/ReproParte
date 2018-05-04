<?php
$pathDB = "../utiles/connectDBUtiles.php";
$pathClase = "../dao/select/informe.php";
$pathCabecera ="../utiles/cabecera_formulario.php";


include_once($pathDB);
include_once($pathClase);

?>

<html>
	<head>
		<style>
			.error {color: #FF0000;}
		</style>
		
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		
	</head>
	<body> 
	<?php 
	include_once($pathCabecera);
	?>
	
	<table>
		<thead>
			<tr>
				<th>
					Solicitud
				</th>
				<th>
					CeCo
				</th>
				<th>
					Codigo
				</th>
				<th>
					Precio Encuadernacion
				</th>
				<th>
					Precio Varios
				</th>
				<th>
					Precio Color
				</th>
				<th>
					Precio ByN
				</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$informeResult = generaInforme($mysqlCon);
			while ($fila = mysqli_fetch_assoc($informeResult)) {
?>
			<tr>
				<td><?php echo $fila['solicitud_id']; ?></td>
				<td><?php echo $fila['CeCo']; ?></td>
				<td><?php echo $fila['codigo']; ?></td>
				<td><?php echo $fila['precioEncuadernacion']; ?></td>
				<td><?php echo $fila['PrecioVarios']; ?></td>
				<td><?php echo $fila['precioColor']; ?></td>
				<td><?php echo $fila['precioByN']; ?></td>

			</tr>
<?php 				
			}
?>
		</tbody>
	</table>
	</body>
	
</html>
