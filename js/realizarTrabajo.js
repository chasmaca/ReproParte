$(document).ready(function(){
	
	var solicitudId = $("#solicitudId").val();
	
	var recuperaDepartamento = function(){
		return $.getJSON("../dao/select/departamentoPorSolicitud.php", {
			"solicitudId":solicitudId
		});
	}
	
	var recuperaSubDepartamento = function(){
		return $.getJSON("../dao/select/subdepartamentoPorSolicitud.php", {
			"solicitudId":solicitudId
		});
	}
	
	var recuperaSolicitante = function(){
		return $.getJSON("../dao/select/solicitantePorSolicitud.php", {
			"solicitudId":solicitudId
		});
	}
	
	var recuperaVarios1 = function() {
		return $.getJSON("../dao/select/variosUnoJSON.php", {
			"solicitudId":solicitudId
		});
	}
	
	var recuperaVarios2 = function() {
		return $.getJSON("../dao/select/variosDosJSON.php", {
			"solicitudId":solicitudId,
			"accion":"combo"
		});
	}
	
	var recuperaByN = function() {
		return $.getJSON("../dao/select/blancoNegroJSON.php", {
			"solicitudId":solicitudId
		});
	}
	
	var recuperaColor = function() {
		return $.getJSON("../dao/select/colorJSON.php", {
			"solicitudId":solicitudId
		});
	}

	var recuperaEncolado = function() {
		return $.getJSON("../dao/select/encoladoJSON.php", {
			"solicitudId":solicitudId
		});
	}

	var recuperaEncuadernacion = function() {
		return $.getJSON("../dao/select/encuadernacionJSON.php", {
			"solicitudId":solicitudId
		});
	}

	var recuperaDetalleVarios2 = function(id) {
		return $.getJSON("../dao/select/detalleVarios2JSON.php", {
			"id":id
		});
	}
	
	var cargaVarios2 = function() {
		return $.getJSON("../dao/select/variosDosJSON.php", {
			"solicitudId":solicitudId,
			"accion":"tabla"
		});
	}
	
	var cargaVarios2Extra = function() {
		return $.getJSON("../dao/select/variosDosExtraJSON.php", {
			"solicitudId":solicitudId,
			"accion":"tabla"
		});
	}
	
	var operarVarios1 = function(detalle, unidades, total){
		return $.getJSON("../dao/insert/colorJSON.php", {
			"solicitudId":solicitudId,
			"tipo": "3",
			"detalle": detalle,
			"unidades" : unidades,
			"total" : total
		});
	}
	
	var operarColor = function(detalle, unidades, total){
		return $.getJSON("../dao/insert/colorJSON.php", {
			"solicitudId":solicitudId,
			"tipo": "4",
			"detalle": detalle,
			"unidades" : unidades,
			"total" : total
		});
	}

	var operarBlancoYNegro = function(detalle, unidades, total){
		return $.getJSON("../dao/insert/colorJSON.php", {
			"solicitudId":solicitudId,
			"tipo": "5",
			"detalle": detalle,
			"unidades" : unidades,
			"total" : total
		});
	}

	var operarEncolado = function(detalle, unidades, total){
		return $.getJSON("../dao/insert/colorJSON.php", {
			"solicitudId":solicitudId,
			"tipo": "2",
			"detalle": detalle,
			"unidades" : unidades,
			"total" : total
		});
	}
	
	var operarEncuadernacion = function(detalle, unidades, total){
		return $.getJSON("../dao/insert/colorJSON.php", {
			"solicitudId":solicitudId,
			"tipo": "1",
			"detalle": detalle,
			"unidades" : unidades,
			"total" : total
		});
	}
	
	var operarVarios2Combo = function(detalle, unidades, total){
		return $.getJSON("../dao/insert/colorJSON.php", {
			"solicitudId":solicitudId,
			"tipo": "6",
			"detalle": detalle,
			"unidades" : unidades,
			"total" : total
		});
	}
	
	var operarVarios2 = function(descripcion, unidades, precio, total){
		return $.getJSON("../dao/insert/varios2JSON.php", {
			"solicitudId":solicitudId,
			"tipo": "7",
			"descripcion": descripcion,
			"unidades" : unidades,
			"precio" : precio,
			"total" : total
		});
	}
	
	var subtotalVarios2 = function(){
		return true;
	}
	
	var changeStatus = function(status){
		return $.getJSON("../dao/update/solicitudStatusJSON.php", {
			"status":status,
			"solicitudId": solicitudId
		});
		
	}
	
	//cambiarSubTotales(varios1,varios2,color, blanco, totalEncuadernacion).done(function(response){
	var cambiarSubTotales = function(varios1, varios2, color, byn, espiral, encolado){
		return $.getJSON("../dao/update/subtotalesTrabajo.php", {
			"solicitudId":solicitudId,
			"varios1":varios1,
			"varios2":varios2,
			"color":color,
			"byn":byn,
			"espiral":espiral,
			"encolado":encolado
		});
	}
	
	
	/**
	 * Cambiamos de estado al acceder a la ficha.
	 */
	changeStatus(4).done(function (response){

		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			alert("Actualización realizada con exito.");
		}
	});
	
	
	/**
	 * Recuperamos el departamento y el ceco
	 */
	recuperaDepartamento().done(function (response){
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de Departamentos");
			}else{

				$( "#departamentoLabel" ).append( "<b>"+array[0].departamentos_desc+"</b>" );
				$( "#cecoLabel" ).append( "<b>"+array[0].ceco+"</b>" );
				
			}
		}
	});

	/**
	 * Recuperamos el departamento y el ceco
	 */
	recuperaSubDepartamento().done(function (response){
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de SubDepartamentos");
			}else{

				$( "#subdepartamentoLabel" ).append( "<b>"+array[0].subdepartamentos_desc+"</b>" );
				$( "#proyectoLabel" ).append( "<b>"+array[0].treintaBarra+"</b>" );
				
				var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
				var f=new Date();
				$( "#fechaLabel" ).append( "<b>"+diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear()+"</b>" );
			}
		}
	});
	
	recuperaSolicitante().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de SubDepartamentos");
			}else{
				$( "#solicitanteLabel" ).append( "<b>"+array[0].nombre+"</b>" );
			}
		}
		
	});
	
	/**
	 * Recuperamos el listado de varios1 con los datos de la solicitud
	 */
	recuperaVarios1().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de Varios1");
			}else{
				for(var x=0; x<array.length;x++){
					var unidades = array[x].unidades;
					var total = array[x].precioTotal;
					
					if (unidades == null)
						unidades = 0;
					
					if (total == null)
						total = 0;
					else
						total = parseFloat(array[x].precioTotal).toFixed(2);
					
					var precioCopia = parseFloat(array[x].precio).toFixed(2);
					
					var newRowContent = "<tr class='trStyle'>" +
											"<td>" + array[x].descripcion + "</td>" +
											"<td><input type='text' id='unidades_"+array[x].detalle+"' value='" + unidades + "' style='width:100%' class='varios1' onkeypress='return (event.charCode >= 46 && event.charCode <= 57)'/></td>" +
											"<td><span id='precio_"+array[x].detalle+"_varios1'>" + precioCopia + "</span></td>" +
											"<td><input type='text' id='total_"+array[x].detalle+"_varios1' value='" + total + "' style='width:100%' readOnly='true' class='totalVarios1'/></td>" +
										"</tr>";
					
					if (newRowContent != null)
						$(newRowContent).appendTo($("#varios1Table"));
				}
				var subtotalVarios1 = "<tr class='trStyle'>" +
											"<td colspan='3'><div style='float: right;'>Subtotal:</div></td>" +
											"<td><input type='text' id='subtotalVarios1' style='width:100%' readOnly='true' class='subtotal'/></td>" +
										"</tr>";
				$(subtotalVarios1).appendTo($("#varios1Table"));
				setSubTotalVarios1();
			}
		}
	});
	
	/**
	 * Recuperamos el listado de Color con los datos de la solicitud
	 */
	recuperaColor().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de Color");
			}else{
				for(var x=0; x<array.length;x++){
					var unidades = array[x].unidades;
					var total = array[x].precioTotal;
					
					if (unidades == null)
						unidades = 0;
					
					if (total == null)
						total = 0;
					else
						total = parseFloat(array[x].precioTotal).toFixed(2);
						
					var precioCopia = parseFloat(array[x].precio).toFixed(2);
					var newRowContent = "<tr class='trStyle'>" +
											"<td>" + array[x].descripcion + "</td>" +
											"<td><input type='text' id='unidades_"+array[x].detalle+"' value='" + unidades + "' style='width:100%' class='color'  onkeypress='return (event.charCode >= 46 && event.charCode <= 57)'/></td>" +
											"<td><span id='precio_"+array[x].detalle+"_color'>" + precioCopia + "</span></td>" +
											"<td><input type='text' id='total_"+array[x].detalle+"_color' value='" + total + "' style='width:100%' readOnly='true' class='totalColor'/></td>" +
										"</tr>";

					
					if (newRowContent != null)
						$(newRowContent).appendTo($("#colorTable"));
				}
				var subtotalColor = "<tr class='trStyle'>" +
											"<td colspan='3'><div style='float: right;'>Subtotal:</div></td>" +
											"<td><input type='text' id='subtotalColor' style='width:100%' readOnly='true' class='subtotal'/></td>" +
										"</tr>";
							$(subtotalColor).appendTo($("#colorTable"));
							setSubTotalColor();
			}
		}
	});

	/**
	 * Recuperamos el listado de Encuadernacion con los datos de la solicitud
	 */
	recuperaEncuadernacion().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de Encuadernacion");
			}else{
				for(var x=0; x<array.length;x++){
					var unidades = array[x].unidades;
					var total = array[x].precioTotal;
					
					if (unidades == null)
						unidades = 0;
					
					if (total == null)
						total = 0;
					else
						total = parseFloat(array[x].precioTotal).toFixed(2);
							
					var precioCopia = parseFloat(array[x].precio).toFixed(2);
					var newRowContent = "<tr class='trStyle'>" +
											"<td>" + array[x].descripcion + "</td>" +
											"<td><input type='text' id='unidades_"+array[x].detalle+"' value='" + unidades + "' style='width:100%' class='espiral'  onkeypress='return (event.charCode >= 46 && event.charCode <= 57)'/></td>" +
											"<td><span id='precio_"+array[x].detalle+"_espiral'>" + precioCopia + "</span></td>" +
											"<td><input type='text' id='total_"+array[x].detalle+"_espiral' value='" + total + "' style='width:100%' readOnly='true' class='totalEncuadernacion'/></td>" +
										"</tr>";
					
					if (newRowContent != null)
						$(newRowContent).appendTo($("#encuadernacionTable"));
				}
				var subtotalEncuadernacion = "<tr class='trStyle'>" +
										"<td colspan='3'><div style='float: right;'>Subtotal:</div></td>" +
										"<td><input type='text' id='subtotalEncuadernacion' style='width:100%' readOnly='true' class='subtotal'/></td>" +
									"</tr>";
						$(subtotalEncuadernacion).appendTo($("#encuadernacionTable"));
						setSubTotalEncuadernacion();

			}
		}
	});
	
	/**
	 * Recuperamos el listado de Encolado con los datos de la solicitud
	 */
	recuperaEncolado().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de Encolados");
			}else{
				for(var x=0; x<array.length;x++){
					var unidades = array[x].unidades;
					var total = array[x].precioTotal;
					
					if (unidades == null)
						unidades = 0;
					
					if (total == null)
						total = 0;
					else
						total = parseFloat(array[x].precioTotal).toFixed(2);
					
					var precioCopia = parseFloat(array[x].precio).toFixed(2);
							
					var newRowContent = "<tr class='trStyle'>" +
											"<td>" + array[x].descripcion + "</td>" +
											"<td><input type='text' id='unidades_"+array[x].detalle+"' value='" + unidades + "' style='width:100%' class='encolado'  onkeypress='return (event.charCode >= 46 && event.charCode <= 57)'/></td>" +
											"<td><span id='precio_"+array[x].detalle+"_encolado'>" + precioCopia + "</span></td>" +
											"<td><input type='text' id='total_"+array[x].detalle+"_encolado' value='" + total + "' style='width:100%' readOnly='true'  class='totalEncolado'/></td>" +
										"</tr>";
					
					if (newRowContent != null)
						$(newRowContent).appendTo($("#encoladoTable"));
				}
				var subtotalEncolado = "<tr class='trStyle'>" +
													"<td colspan='3'><div style='float: right;'>Subtotal:</div></td>" +
													"<td><input type='text' id='subtotalEncolado' style='width:100%' readOnly='true' class='subtotal'/></td>" +
												"</tr>";
									$(subtotalEncolado).appendTo($("#encoladoTable"));
									setSubTotalEncolado();

			}
		}
	});
	
	/**
	 * Recuperamos el listado de Blanco y Negro con los datos de la solicitud
	 */
	recuperaByN().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de Blanco y Negro");
			}else{
				for(var x=0; x<array.length;x++){
					var unidades = array[x].unidades;
					var total = array[x].precioTotal;
					
					if (unidades == null)
						unidades = 0;
					
					if (total == null)
						total = 0;
					else
						total = parseFloat(array[x].precioTotal).toFixed(2);
							
					var precioCopia = parseFloat(array[x].precio).toFixed(2);
					
					var newRowContent = "<tr class='trStyle'>" +
											"<td>" + array[x].descripcion + "</td>" +
											"<td><input type='text' id='unidades_"+array[x].detalle+"' value='" + unidades + "' style='width:100%' class='blanco'  onkeypress='return (event.charCode >= 46 && event.charCode <= 57)'/></td>" +
											"<td><span id='precio_"+array[x].detalle+"_blanco'>" + precioCopia + "</span></td>" +
											"<td><input type='text' id='total_"+array[x].detalle+"_blanco' value='" + total + "' style='width:100%' readOnly='true' class='totalByN'/></td>" +
										"</tr>";
					
					if (newRowContent != null)
						$(newRowContent).appendTo($("#blancoTable"));
				}
				var subtotalBlanco = "<tr class='trStyle'>" +
											"<td colspan='3'><div style='float: right;'>Subtotal:</div></td>" +
											"<td><input type='text' id='subtotalByN' style='width:100%' readOnly='true' class='subtotal'/></td>" +
										"</tr>";
				$(subtotalBlanco).appendTo($("#blancoTable"));
				setSubTotalByN();
			}
		}
	});
	
	/**
	 * Recuperamos el listado de Varios2 con los datos de la solicitud
	 */
	recuperaVarios2().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de Varios2");
			}else{
				for(var x=0; x<array.length;x++){
					$('#varios2Select').append($("<option></option>").attr("value",array[x].detalle).text(array[x].descripcion)); 
				}
			}
		}
	});
	
	/**
	 * Cargamos Varios2
	 */
	cargaVarios2().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length>0){
				for(var x=0; x<array.length;x++){
					var unidades = array[x].unidades;
					var total = array[x].precioTotal;
					
					if (unidades == null)
						unidades = 0;
					
					if (total == null)
						total = 0;
					else
						total = parseFloat(array[x].precioTotal).toFixed(2);
						
						
					if (total!=0 && unidades != 0){
						var precioCopia = parseFloat(array[x].precio).toFixed(2);
						
						var newRowContent = "<tr class='trStyle'>" +
												"<td><span id='descripcionVarios2' class='descripcionVarios2'>" + array[x].descripcion + "</span></td>" +
												"<td><input type='text' id='unidades' value='" + unidades + "' style='width:100%'/></td>" +
												"<td>" + precioCopia + "</td>" +
												"<td><input type='text' id='totalVarios2' value='" + total + "' style='width:100%' class='totalVarios2'/></td>" +
											"</tr>";
						
						if (newRowContent != null)
							$(newRowContent).appendTo($("#tablaVarios2"));
					}
					
				}
				
			}
			setSubTotalVarios2();
		}
	});
	
	/**
	 * Cargamos Varios2Extra
	 */
	cargaVarios2Extra().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length>0){
				for(var x=0; x<array.length;x++){
					var unidades = array[x].unidades;
					var total = array[x].precioTotal;
					
					if (unidades == null)
						unidades = 0;
					
					if (total == null)
						total = 0;
					else
						total = parseFloat(array[x].precioTotal).toFixed(2);
					
					if (total!=0 && unidades != 0){
						
						var precioCopia = parseFloat(array[x].precio).toFixed(2);
						
						var newRowContent = "<tr class='trStyle'>" +
												"<td><span id='descripcionVarios2' class='descripcionVarios2'>" + array[x].descripcion + "</span></td>" +
												"<td><input type='text' id='unidades' value='" + unidades + "' style='width:100%'/></td>" +
												"<td>" + precioCopia + "</td>" +
												"<td><input type='text' id='totalVarios2' value='" + total + "' style='width:100%' class='totalVarios2'/></td>" +
											"</tr>";
						
						if (newRowContent != null)
							$(newRowContent).appendTo($("#tablaVarios2"));
					}
				}
				setSubTotalVarios2();
			}
		}
	});
	
	/**
	 * Actualizamos el importe total y realizamos la insercion en caso de modificacion de varios1
	 */
	$(document).on("blur",".varios1",function() {
		var valor = $(this).val();
		var id = $(this).attr("id");
		if (!isNaN(valor)){
			id = id.replace(",",".");
			var detalle = id.substring(id.indexOf("_")+1, id.length);
			var cadenaSpan = "#precio_"+detalle+"_varios1";
			var precio = $(cadenaSpan).text();
			var precioTotal = (parseFloat(valor) * parseFloat(precio)).toFixed(2);
			$('#total_'+detalle+'_varios1').val(precioTotal);
			var mensaje = "";
			operarVarios1(detalle,valor,precioTotal).done(function(responseVarios1) {
				if (!responseVarios1.success) {
					alert("Problema con el JSON");
				}else{
					mensaje = "Operacion realizada con exito";
				}
			});
			setSubTotalVarios1();
		}else{
			alert("Debe incluir un valor numérico");
		}
		
	});

	/**
	 * Actualizamos el importe total y realizamos la insercion en caso de modificacion de color
	 */
	$(document).on("blur",".color",function() {
		var valor = $(this).val();
		var id = $(this).attr("id");
		if (!isNaN(valor)){
			var detalle = id.substring(id.indexOf("_")+1, id.length);
			var cadenaSpan = "#precio_"+detalle+"_color";
			var precio = $(cadenaSpan).text();
			var precioTotal = (parseFloat(valor) * parseFloat(precio)).toFixed(2);
			$('#total_'+detalle+'_color').val(precioTotal);
			operarColor(detalle,valor,precioTotal).done(function(responseColor) {
				if (!responseColor.success) {
					alert("Problema con el JSON");
				}else{
					mensaje = "Operacion realizada con exito";
				}
			});
			setSubTotalColor();
		}else{
			alert("Debe incluir un valor numérico");
		}
	});

	/**
	 * Actualizamos el importe total y realizamos la insercion en caso de modificacion de blanco y negro
	 */
	$(document).on("blur",".blanco",function() {
		var valor = $(this).val();
		var id = $(this).attr("id");
		if (!isNaN(valor)){
			var detalle = id.substring(id.indexOf("_")+1, id.length);
			var cadenaSpan = "#precio_"+detalle+"_blanco";
			var precio = $(cadenaSpan).text();
			var precioTotal = (parseFloat(valor) * parseFloat(precio)).toFixed(2);
			$('#total_'+detalle+'_blanco').val(precioTotal);
			operarBlancoYNegro(detalle,valor,precioTotal).done(function(responseColor) {
				if (!responseColor.success) {
					alert("Problema con el JSON");
				}else{
					mensaje = "Operacion realizada con exito";
				}
			});
			setSubTotalByN();
		}else{
			alert("Debe incluir un valor numérico");
		}
	});

	/**
	 * Actualizamos el importe total y realizamos la insercion en caso de modificacion de encolado
	 */
	$(document).on("blur",".encolado",function() {
		var valor = $(this).val();
		var id = $(this).attr("id");
		if (!isNaN(valor)){
			var detalle = id.substring(id.indexOf("_")+1, id.length);
			var cadenaSpan = "#precio_"+detalle+"_encolado";
			var precio = $(cadenaSpan).text();
			var precioTotal = (parseFloat(valor) * parseFloat(precio)).toFixed(2);
			$('#total_'+detalle+'_encolado').val(precioTotal);
			operarEncolado(detalle,valor,precioTotal).done(function(responseColor) {
				if (!responseColor.success) {
					alert("Problema con el JSON");
				}else{
					mensaje = "Operacion realizada con exito";
				}
			});
			setSubTotalEncolado();
		}else{
			alert("Debe incluir un valor numérico");
		}
	});

	/**
	 * Actualizamos el importe total y realizamos la insercion en caso de modificacion de encuadernacion
	 */
	$(document).on("blur",".espiral",function() {
		var valor = $(this).val();
		var id = $(this).attr("id");
		if (!isNaN(valor)){
			var detalle = id.substring(id.indexOf("_")+1, id.length);
			var cadenaSpan = "#precio_"+detalle+"_espiral";
			var precio = $(cadenaSpan).text();
			var precioTotal = (parseFloat(valor) * parseFloat(precio)).toFixed(2);
			$('#total_'+detalle+'_espiral').val(precioTotal);
			operarEncuadernacion(detalle,valor,precioTotal).done(function(responseColor) {
				if (!responseColor.success) {
					alert("Problema con el JSON");
				}else{
					mensaje = "Operacion realizada con exito";
				}
			});
			setSubTotalEncuadernacion();
		}else{
			alert("Debe incluir un valor numérico");
		}
	});
	
	/**
	 * Accion que se desencadena cuando el usuario selecciona una opcion de la lista de va
	 */
	$(document).on("change","#varios2Select",function() {

		var valor = $('select[name=varios2Select] option:selected').val();
		var rowCount = $('#tablaVarios2 tr').length;
		var texto = $('select[name=varios2Select] option:selected').text();
		var flagExist = false;
		var allListElements = $( ".descripcionVarios2" );

		if (valor != 0){
			for (var x=0;x<allListElements.length;x++){
				var opcion = allListElements[x];
				if (texto == opcion.textContent){
					flagExist = true;
				}
			}

			if (!flagExist){
				recuperaDetalleVarios2(valor).done(function(responseVariosCombo) {
					if (!responseVariosCombo.success) {
						alert("Problema con el JSON");
					}else{
						var array = $.map(responseVariosCombo.data, function(value, index) {
							return [value];
						});

						if (array.length>0){
							for(var x=0; x<array.length;x++){

								var newRowContent = "<tr class='trStyle'>" +
														"<td><span id='descripcionVarios2' class='descripcionVarios2'>" + array[x].descripcion + "</span></td>" +
														"<td><input type='text' id='unidades_" + array[x].detalle + "' style='width:100%' onkeypress='return (event.charCode >= 46 && event.charCode <= 57)' class='varios2Combo'/></td>" +
														"<td> <span id='precio_" + array[x].detalle + "_extra'>"+ array[x].precio + "</span></td>" +
														"<td><input type='text' id='total_" + array[x].detalle + "_extra' style='width:100%' readOnly='true' class='totalVarios2'/></td>" +
													"</tr>";

								if (newRowContent != null)
									$(newRowContent).appendTo($("#bodyVarios2"));
							}
						}
						setSubTotalVarios2();
					}
				});
			}else{
				alert("Se ha añadido esta opción con anterioridad, por favor, revisa las lineas ya creadas.");
			}
		}
	});

	/**
	 * Accion cuando se pulsa al enlace para añadir un nuevo elemento Varios 2 desde zero
	 * Añade una linea en blanco para que el usuario pueda incluir todo lo que considere.
	 */
	$(document).on("click","#sumarLinea",function() {
		var rowCount = $('#tablaVarios2 tr').length;
		
		var newRowContent = "<tr class='trStyle'>" +
								"<td><input type='text' id='descripcionVarios2_"+rowCount+"' style='width:100%' class='varios2Extra'/></td>" +
								"<td><input type='text' id='cantidadVarios2_"+rowCount+"' style='width:100%' onkeypress='return (event.charCode >= 46 && event.charCode <= 57)' class='varios2Extra'/></td>" +
								"<td><input type='text' id='precioVarios2_"+rowCount+"' style='width:100%' onkeypress='return (event.charCode >= 46 && event.charCode <= 57)' class='varios2Extra' /></td>" +
								"<td><input type='text' id='precioTotalVarios2_"+rowCount+"' style='width:100%' readOnly='true' class='totalVarios2'/></td>" +
							"</tr>";
		
		$(newRowContent).appendTo($("#bodyVarios2"));
		setSubTotalVarios2();
	});

	/**
	 * Valida y añade en las tablas detalle y trabajodetalle todo el contenido que el usuario ha incluido en las casillas en blanco de Varios2
	 */
	$(document).on("blur",".varios2Extra",function() {

		var id = $(this).attr("id");
		if (id.indexOf('precioTotalVarios2_') ==-1){
			var linea = id.substr(id.indexOf('_')+1,id.length);
			var descripcion = $("#descripcionVarios2_"+linea).val();
			var unidades = $("#cantidadVarios2_"+linea).val();
			var precio = $("#precioVarios2_"+linea).val();
			
			//Controlamos que los valores numericos esten completados
			if (unidades!="" && precio!=""){
				var precioTotal = (parseFloat(unidades) * parseFloat(precio)).toFixed(2);
				$("#precioTotalVarios2_"+linea).val(precioTotal);
				
				if (descripcion==""){
					alert("Debe rellenar la descripción");
				}
			}

			//Controlamos que todos los valores esten completados.
			if (descripcion!="" && unidades!="" && precio != "" && precioTotal!= ""){
				operarVarios2(descripcion,unidades,precio,precioTotal).done(function(responseVariosExtra) {
				});
			}
			setSubTotalVarios2();
		}
	});
	
	/**
	 * Actualizamos el valor del precio con las opciones del combo de varios2
	 */
	$(document).on("blur",".varios2Combo",function() {
		var valor = $(this).val();
		var id = $(this).attr("id");
		if (!isNaN(valor)){
			var detalle = id.substring(id.indexOf("_")+1, id.length);
			var cadenaSpan = "#precio_"+detalle+"_extra";
			var precio = $(cadenaSpan).text();
			var precioTotal = (parseFloat(valor) * parseFloat(precio)).toFixed(2);
			$('#total_'+detalle+'_extra').val(precioTotal);
			operarVarios2Combo(detalle,valor,precioTotal).done(function(responseColor) {
				if (!responseColor.success) {
					alert("Problema con el JSON");
				}else{
					mensaje = "Operacion realizada con exito";
				}
			});
			setSubTotalVarios2();
		}else{
			alert("Debe incluir un valor numérico");
		}
	});
	
	/**El Subtotal de varios 2**/
	function setSubTotalVarios2(){

		var total = 0;
		var allListElements = $( ".totalVarios2" );
		
		for (var x=0;x<allListElements.length;x++){
			var opcion = allListElements[x];
			var precio = opcion.value;
			
	//		( isNaN(precio) || total == "") ? precio=0:precio;
					
			total = (parseFloat(total) + parseFloat(precio)).toFixed(2);
		
			if (isNaN(total))
				total = 0;
			
			if (total=="")
				total = 0;
			
		}
		
		//var totalVarios2 = ( isNaN(total) || total == "") ? 0:total;
		
		$('#subtotalVarios2').val(total);
		setTotal();
	}
	
	/**El Subtotal de varios 1**/
	function setSubTotalVarios1(){
		
		var total = 0;
		var allListElements = $( ".totalVarios1" );
		
		for (var x=0;x<allListElements.length;x++){
			var opcion = allListElements[x];
			var precio = opcion.value;
			total = (parseFloat(total) + parseFloat(precio)).toFixed(2);
		}
		$('#subtotalVarios1').val(total);
		setTotal();
	}
	
	/**El Subtotal de Color**/
	function setSubTotalColor(){
		
		var total = 0;
		var allListElements = $( ".totalColor" );
		
		for (var x=0;x<allListElements.length;x++){
			var opcion = allListElements[x];
			var precio = opcion.value;
			total = (parseFloat(total) + parseFloat(precio)).toFixed(2);
		}
		$('#subtotalColor').val(total);
		setTotal();
	}

	/**El Subtotal de Encuadernacion**/
	function setSubTotalEncuadernacion(){
		
		var total = 0;
		var allListElements = $( ".totalEncuadernacion" );
		
		for (var x=0;x<allListElements.length;x++){
			var opcion = allListElements[x];
			var precio = opcion.value;
			total = (parseFloat(total) + parseFloat(precio)).toFixed(2);
		}
		$('#subtotalEncuadernacion').val(total);
		setTotal();
	}
	
	/**El Subtotal de Encolado**/
	function setSubTotalEncolado(){

		var total = 0;
		var allListElements = $( ".totalEncolado" );
		
		for (var x=0;x<allListElements.length;x++){
			var opcion = allListElements[x];
			var precio = opcion.value;
			total = (parseFloat(total) + parseFloat(precio)).toFixed(2);
		}
		$('#subtotalEncolado').val(total);
		setTotal();
	}
	
	/**El Subtotal de ByN**/
	function setSubTotalByN(){
		var total = 0;
		var allListElements = $( ".totalByN" );

		for (var x=0;x<allListElements.length;x++){
			var opcion = allListElements[x];
			var precio = opcion.value;
			total = (parseFloat(total) + parseFloat(precio)).toFixed(2);
		}
		$('#subtotalByN').val(total);
		setTotal();
	}
	
	function setTotal(){

		var varios1 = (isNaN($('#subtotalVarios1').val())) ? 0:$('#subtotalVarios1').val(); 
		
		var varios2 = (isNaN($('#subtotalVarios2').val())) ? 0:$('#subtotalVarios2').val();
		var varios2 = ($('#subtotalVarios2').val() == "") ? 0:$('#subtotalVarios2').val();

		var color =  (isNaN($('#subtotalColor').val())) ? 0:$('#subtotalColor').val();
		
		var blanco =  (isNaN($('#subtotalByN').val())) ? 0:$('#subtotalByN').val();
		
		var espiral =  (isNaN($('#subtotalEncuadernacion').val())) ? 0:$('#subtotalEncuadernacion').val();
		
		var encolado =  (isNaN($('#subtotalEncolado').val())) ? 0:$('#subtotalEncolado').val();
																		
		var sumaTotal = (parseFloat(varios1) + parseFloat(varios2) + parseFloat(color) + parseFloat(blanco) + parseFloat(espiral) + parseFloat(encolado)).toFixed(2);
						
		$('#total').val(sumaTotal);
	
	}
	
	/**
	 * Accion cuando se pulsa al enlace para añadir un nuevo elemento Varios 2 desde zero
	 * Añade una linea en blanco para que el usuario pueda incluir todo lo que considere.
	 */
	$(document).on("click","#guardar",function() {
		/**
		 * Cambiamos de estado al acceder a la ficha.
		 */
		var varios1 = (isNaN($('#subtotalVarios1').val())) ? 0:$('#subtotalVarios1').val(); 
		
		var varios2 = (isNaN($('#subtotalVarios2').val())) ? 0:$('#subtotalVarios2').val();
		var varios2 = ($('#subtotalVarios2').val() == "") ? 0:$('#subtotalVarios2').val();

		var color =  (isNaN($('#subtotalColor').val())) ? 0:$('#subtotalColor').val();
		
		var blanco =  (isNaN($('#subtotalByN').val())) ? 0:$('#subtotalByN').val();
		
		var espiral =  (isNaN($('#subtotalEncuadernacion').val())) ? 0:$('#subtotalEncuadernacion').val();
		
		var encolado =  (isNaN($('#subtotalEncolado').val())) ? 0:$('#subtotalEncolado').val();
		
		var totalEncuadernacion = (parseFloat(espiral) + parseFloat(encolado)).toFixed(2);
		
		cambiarSubTotales(varios1, varios2, color, blanco, espiral,encolado).done(function(response){
			
			if (!response.success) {
				alert("Problema con el JSON");
			}else{
				alert("Se va a guardar el parte de trabajo de la solicitud " + 
						solicitudId + " Con un importe total de " + $('#total').val() + 
						" desglosado en Varios1:" + varios1 + " Varios 2:" + varios2 + " Color:" + color + " BlancoYNegro:" + blanco + " Espiral:"+espiral+" y encolado:" + encolado);

			}
			
		});
		
		
		changeStatus(5).done(function (response){
			
			if (!response.success) {
				alert("Problema con el JSON");
			}else{
				location.href="../formularios/homeTrabajo.php";
			}
		});
	});
	
	$(document).on("click","#volver",function() {
		/**
		 * Cambiamos de estado al acceder a la ficha.
		 */
		var varios1 = (isNaN($('#subtotalVarios1').val())) ? 0:$('#subtotalVarios1').val(); 
		
		var varios2 = (isNaN($('#subtotalVarios2').val())) ? 0:$('#subtotalVarios2').val();
		var varios2 = ($('#subtotalVarios2').val() == "") ? 0:$('#subtotalVarios2').val();

		var color =  (isNaN($('#subtotalColor').val())) ? 0:$('#subtotalColor').val();
		
		var blanco =  (isNaN($('#subtotalByN').val())) ? 0:$('#subtotalByN').val();
		
		var espiral =  (isNaN($('#subtotalEncuadernacion').val())) ? 0:$('#subtotalEncuadernacion').val();
		
		var encolado =  (isNaN($('#subtotalEncolado').val())) ? 0:$('#subtotalEncolado').val();
		
		var totalEncuadernacion = (parseFloat(espiral) + parseFloat(encolado)).toFixed(2);
		
		cambiarSubTotales(varios1, varios2, color, blanco, espiral,encolado).done(function(response){
			
			if (!response.success) {
				alert("Problema con el JSON");
			}else{
				alert("Se va a Volver el parte de trabajo de la solicitud " + 
						solicitudId + " Con un importe total de " + $('#total').val() + 
						" desglosado en Varios1:" + varios1 + " Varios 2:" + varios2 + " Color:" + color + " BlancoYNegro:" + blanco + " Espiral:"+espiral+" y encolado:" + encolado);

			}
			
		});
		/**
		 * Cambiamos de estado al acceder a la ficha.
		 */
		changeStatus(5).done(function (response){

			if (!response.success) {
				alert("Problema con el JSON");
			}else{
				location.href="../formularios/homeTrabajo.php";
			}
		});
	});
	
	$(document).on("click","#cerrar",function() {
		/**
		 * Cambiamos de estado al acceder a la ficha.
		 */
		var varios1 = (isNaN($('#subtotalVarios1').val())) ? 0:$('#subtotalVarios1').val(); 
		
		var varios2 = (isNaN($('#subtotalVarios2').val())) ? 0:$('#subtotalVarios2').val();
		var varios2 = ($('#subtotalVarios2').val() == "") ? 0:$('#subtotalVarios2').val();

		var color =  (isNaN($('#subtotalColor').val())) ? 0:$('#subtotalColor').val();
		
		var blanco =  (isNaN($('#subtotalByN').val())) ? 0:$('#subtotalByN').val();
		
		var espiral =  (isNaN($('#subtotalEncuadernacion').val())) ? 0:$('#subtotalEncuadernacion').val();
		
		var encolado =  (isNaN($('#subtotalEncolado').val())) ? 0:$('#subtotalEncolado').val();
		
		var totalEncuadernacion = (parseFloat(espiral) + parseFloat(encolado)).toFixed(2);
		
		cambiarSubTotales(varios1, varios2, color, blanco, espiral,encolado).done(function(response){
			
			if (!response.success) {
				alert("Problema con el JSON");
			}else{
				alert("Se va a cerrar el parte de trabajo de la solicitud " + 
						solicitudId + " Con un importe total de " + $('#total').val() + 
						" desglosado en Varios1:" + varios1 + " Varios 2:" + varios2 + " Color:" + color + " BlancoYNegro:" + blanco + " Espiral:"+espiral+" y encolado:" + encolado);
			}
			
		});

		
		/**
		 * Cambiamos de estado al acceder a la ficha.
		 */
		changeStatus(6).done(function (response){

			if (!response.success) {
				alert("Problema con el JSON");
			}else{
				location.href="../formularios/homeTrabajo.php";
			}
		});
	
	});
});