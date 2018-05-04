<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();

	include_once("../utiles/connectDBUtiles.php");
	include_once("../dao/select/trabajo.php");
	include_once("../dao/insert/inserciones.php");
	include_once("../dao/update/updates.php");
	include_once("../dao/select/subdepartamento.php");

	$solicitudId = $_GET['solicitudId'];
?>

<html>
	<head>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/realizarTrabajoNoCache.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/estilosTrabajo.css"> </link>
	</head>
	<body> 
<?php 
		include_once("../utiles/cabecera_formulario.php");
?>

		<div id="error" style="position: fixed;z-index:1000;"></div>
		<form name="detalleTrabajo" id="detalleTrabajo" method="post" action="../dao/insert/guardarTrabajo.php">
			<input type="hidden" name="solicitudId" id="solicitudId" value="<?php echo $solicitudId;?>"/>
			<h1>Realizar Trabajo</h1>
			<div style="display: inline; padding:10px;" id="departamentoLabel"><label for="email">Departamento:</label></div>
			<div style="display: inline; padding:10px;" id="subdepartamentoLabel"><label for="email">Subdepartamento:</label></div>
			<div style="display: inline; padding:10px;" id="fechaLabel"><label for="email">Fecha:</label></div>
			<div style="display: inline; padding:10px;" id="proyectoLabel"><label for="email">Proyecto/Orden:</label></div>
			<div style="display: inline; padding:10px;" id="cecoLabel"><label for="email">CeCo:</label></div>
			<div style="display: block; padding:10px;" id="solicitanteLabel"><label for="email">Solicitante:</label></div>
			<div style="display: inline; padding:10px;color:red;align:center;text-align:center;"></div>
			<div style="width:100%; margin: 0 auto;vertical-align:top;">
				<div class="encuadernacion" >
					<table border="1" width="100%" id="varios1Table">
						<thead>	
							<tr>
								<th colspan="4" width="100%" id="tipoId3">
									<center>Varios 1</center>
								</th>
							</tr>
							<tr>
								<th width="25%">
									<center>Descripcion</center>
								</th>
								<th width="25%">
									<center>Cantidad</center>
								</th>
								<th width="25%">
									<center>Pr. Unidad</center>
								</th>
								<th width="25%">
									<center>Total</center>
								</th>
							</tr>
						</thead>
						<tbody id="tbVarios1">
						</tbody>
					</table>
				</div>
				<div class="encuadernacion" >
					<table border="1" width="100%" id="colorTable">
						<thead>
							<tr>
								<th colspan="4" width="100%" id="tipoId4">
									<center>Color</center>
								</th>
							</tr>
							<tr>
								<th width="25%">
									<center>Descripcion</center>
								</th>
								<th width="25%">
									<center>Cantidad</center>
								</th>
								<th width="25%">
									<center>Pr Unidad</center>
								</th>
								<th width="25%">
									<center>Total</center>
								</th>
							</tr>
						</thead>
						<tbody id="tbColor">
						</tbody>
					</table>
					<div>
						<table border="1" width="100%" id="encuadernacionTable">
							<thead>
								<tr>
									<th colspan="4" width="100%" nowrap>
										<div id="txt1" >
											<center>Encuadernaciones</center>
										</div>
									</th>
								</tr>
								<tr id="tipoId1">
									<th>
										<center>Espiral</center>
									</th>
									<th>
										<center>Cantidad</center>
									</th>
									<th>
										<center>Pr Unidad</center>
									</th>
									<th>
										<center>Total</center>
									</th>
								</tr>
							</thead>
							<tbody id="tbEspiral">
							</tbody>
						</table>
						<table border="1" width="100%" id="encoladoTable">
							<thead>
								<tr>
									<th colspan="5" width="100%">
										<div id="txt1" >
											<center>Encolado</center>
										</div>
									</th>
								</tr>
								<tr id="tipoId2">
									<th width="40%">
										<center>Encolado</center>
									</th>
									<th width="20%">
										<center>Cantidad</center>
									</th>
									<th width="20%">
										<center>Pr Unidad</center>
									</th>
									<th width="20%">
										<center>Total</center>
									</th>
								</tr>
							</thead>
							<tbody id="tbEncolado">
							</tbody>
						</table>
						<table border="1" width="100%" id="blancoTable">
							<thead>
								<tr>
									<th width="100%" colspan="4">
										<center>Blanco y Negro</center>
									</th>
								</tr>
								<tr>
									<th width="25%">Descripcion</th>
									<th width="25%">Cantidad</th>
									<th width="25%">Pr. Unidad</th>
									<th width="25%">Total</th>
								</tr>
							</thead>
							<tbody id="tbByN">
							</tbody>
						</table>
					</div>
					<table border="1" width="100%" id="tablaVarios2">
						<thead>
						<tr>
							<th width="100%" colspan="4">
								<div style="width:100%;float:left;">
									<div style="display:inline;width:60%;float:left;">
										<div style="float:right;">
											Varios 2
										</div>
									</div>
									<div style="width:40%;float:right;">
										<input type="button" name="sumarLinea" id="sumarLinea" value="A&ntilde;adir"/>
									</div>
								</div>
							</th>
						</tr>
						<tr style="position:inherit;">
							<th colspan="4" width="100%" style="background:linear-gradient(#777, #444);border-left: 1px solid #555;border-right: 1px solid #777;border-top: 1px solid #555;border-bottom: 1px solid #333;color: #fff;font-weight: bold;padding: 10px 15px; text-shadow: 0 1px 0 #000;">
								<center>
									<p>Seleccione el trabajo Varios2
										<select name="varios2Select" id="varios2Select" class="varios2Select">
											<option value="0">Seleccione el Trabajo</option>
										</select>
									</p>
								</center>
							</th>
						</tr>
						<tr>
							<th width="25%">
								<center>Descripcion</center>
							</th>
							<th width="10%">
								<center>Cantidad</center>
							</th>
							<th width="10%">
								<center>Pr. Unidad</center>
							</th>
							<th width="20%">
								<center>Total</center>
							</th>
						</tr>
						</thead>
						<tbody id="bodyVarios2"></tbody>
						<tfoot>
							<tr>
								<td colspan="4">
									<div style="float:left;width: 50%;">
										Subtotal: 
									</div>
									<div  style="float:right;width: 50%;">
										<input type="text" name="subtotalVarios2" id="subtotalVarios2" class='subtotal'/>
									</div>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<label for="email" style="padding-left:30%"> TOTAL:</label>
			<input type="text" readonly name="total" id="total" />
			<input type="button" name="guardar" value="Guardar" id="guardar"/>
			<input type="button" name="Cerrar" value="Cerrar" id="cerrar"/>
			<input type="button" name="Volver" value="Volver" id="volver"/>
		</form>
	</body>
</html>