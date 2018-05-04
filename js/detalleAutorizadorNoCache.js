$(document).ready(function(){

	var tipoInforme = "";
	var periodo =  "0";
	var departamento = "0";
	var subdepartamento = "0";

	var recuperaPeriodo = function() {
		return $.getJSON("../dao/select/periodoJSON.php", {
		});
	}

	var recuperaDepartamento = function(){
		return $.getJSON("../dao/select/departamentoValidadorJSON.php", {
		});
	}

	var recuperamosSubXDep = function(departamento){
		return $.getJSON("../dao/select/subdepartamentoJSON.php", {
			"departamento": departamento
		});
	}

	var recuperamosListado = function(periodoParam, departamentoParam, subdepartamentoParam, tipoInformeParam ){
		return $.getJSON("../dao/select/informeValidadorJSON.php", {
			"periodo": periodoParam,
			"departamento": departamento,
			"subdepartamento": subdepartamentoParam,
			"tipoInforme": tipoInformeParam
		});
	}

	recuperaPeriodo().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de periodos");
			}else{
				for(var x=0; x<array.length;x++){
					var fecha = array[x].mes_alta + "/" + array[x].anio_alta;
					$('#periodo').append($("<option></option>").attr("value",fecha).text(fecha)); 
				}
			}
		}
	})
	//Error en la consulta o comunicacion con la bbdd.
	.fail(function(jqXHR, textStatus, errorThrown) {
		alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
	});

	/*Cargamos el combo de departamentos*/
	recuperaDepartamento().done(function(response) {
		if (!response.success) {
			alert("Problema con el JSON");
		}else{
			var array = $.map(response.data, function(value, index) {
				return [value];
			});
			if (array.length==0){
				alert("no hay datos de departamentos");
			}else{
				for(var x=0; x<array.length;x++){
					$('#departamento').append($("<option></option>").attr("value",array[x].departamento_id).text(array[x].departamentos_desc)); 
				}
			}
		}
	})
	//Error en la consulta o comunicacion con la bbdd.
	.fail(function(jqXHR, textStatus, errorThrown) {
		alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
	});

	/*Controlamos el evento onchange del combo de departamentos*/
	$('#departamento').on('change', function() {
		var departamento = $(this).val();
		if (departamento == 0 || departamento == "aa"){
			$('#subdepartamento option').remove();
			$('#subdepartamento').append($("<option></option>").attr("value","0").text("--Seleccione el SubDepartamento--")); 
			$('#subdepartamento').append($("<option></option>").attr("value","aa").text("--Todos los SubDepartamentos--"));
		}else{
			recuperamosSubXDep(departamento).done(function(response) {
				if (!response.success) {
					alert("Problema con el JSON");
				}else{
					$('#subdepartamento option').remove();
					var array = $.map(response.data, function(value, index) {
						return [value];
					});
					if (array.length==0){
						alert("no hay datos de subdepartamentos");
					}else{
						$('#subdepartamento').append($("<option></option>").attr("value","0").text("--Seleccione el SubDepartamento--")); 
						$('#subdepartamento').append($("<option></option>").attr("value","aa").text("--Todos los SubDepartamentos--"));
						for(var x=0; x<array.length;x++){
							$('#subdepartamento').append($("<option></option>").attr("value",array[x].subdepartamento_id).text(array[x].subdepartamento_desc)); 
						}
					}
				}
			})
			//Error en la consulta o comunicacion con la bbdd.
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
			});
		}
	});

	/*Recogemos el click del tipo informe para saber que mostrar en pantalla*/
	$("#consultaInformeForm input[type=radio]").change( function() {
	    if( this.checked ) {
	    	tipoInforme = $(this).val();
	    }
	});

	/*Recogemos el click del boton de filtrado, validamos los parametros y si todo esta correcto, lanzamos el listado*/
	$( "#filtrar" ).click(function() {
		if (validacion()){
			if (tipoInforme == 'global'){
				$("#informeValidador > thead > tr > th").remove();
				$("#informeValidador > thead > tr").append( '<th>ESB</th>' );
				$("#informeValidador > thead > tr").append( '<th>CÓDIGO</th>' );
				$("#informeValidador > thead > tr").append( '<th>DEPARTAMENTO</th>' );
				$("#informeValidador > thead > tr").append( '<th>SUBDEPARTAMENTO</th>' );
				$("#informeValidador > thead > tr").append( '<th>Importe Encuadernacion</th>' );
				$("#informeValidador > thead > tr").append( '<th>Importe Blanco y Negro</th>' );
				$("#informeValidador > thead > tr").append( '<th>Importe Color</th>' );
				$("#informeValidador > thead > tr").append( '<th>Importe Varios</th>' );
				$("#informeValidador > thead > tr").append( '<th>Total</th>' );
			}else{
				$("#informeValidador > thead > tr > th").remove();
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>PARTE</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>ESB</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>CODIGO</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>DEPARTAMENTO</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>SUBDEPARTAMENTO</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>FECHA</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>ENCUADERNACIONES</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>BLANCO Y NEGRO</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>COLOR</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>VARIOS</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>NOMBRE</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>DESCRIPCION</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>ByN MAQUINA</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>COLOR MAQUINA</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>ByN IMPRESORA</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>COLOR IMPRESORA</span></div></th>' );
				$("#informeValidador > thead > tr").append( '<th class="rotate" style="padding: 0px;"><div><span>TOTAL</span></div></th>' );
			}
			$("#informeValidador > tbody > tr").remove();
			recuperamosListado(periodo,departamento,subdepartamento,tipoInforme).done(function(response) {
				if (!response.success) {
					alert("Problema con el JSON");
				}else{
					var array = $.map(response.data, function(value, index) {
						return [value];
					});
					if (array.length==0){
						alert("no hay datos en el informe");
					}else{
						var totalAbsoluto = 0;
						for(var x=0; x<array.length;x++){
							if (tipoInforme != 'global'){
							/*Pintamos las lineas de la tabla con los resultados de la query*/
							array[x].byn == null ? 0 : array[x].byn;
							array[x].color == null ? 0 : array[x].color;
							array[x].encuadernacion == null ? 0 : array[x].encuadernacion;
							array[x].varios == null ? 0 : array[x].varios;
							array[x].gastosImpresoras == null ? 0 : array[x].gastosImpresoras;
							var byn = 0;
							var color = 0;
							var encuadernacion = 0;
							var varios = 0;
							
							if (array[x].byn != null && array[x].byn != "")
								byn = array[x].byn;
							else
								byn = 0;
							
							if (array[x].color != null && array[x].color != "")
								color = array[x].color;
							else
								color = 0;
							
							if (array[x].encuadernacion != null && array[x].encuadernacion != "")
								encuadernacion = array[x].encuadernacion;
							else 
								encuadernacion = 0;
							
							if (array[x].varios != null && array[x].varios != "")
								varios = array[x].varios;
							else
								varios = 0;
								
							var totalMaquinasColor = array[x].color_maquina;
							var totalMaquinasByN = array[x].byn_maquina;
							var totalImpresorasByN = array[x].byn_impresora;
							var totalImpresorasColor = array[x].color_impresora;
							
							
							var totalLinea = parseFloat(byn) + parseFloat(color) + parseFloat(encuadernacion) + parseFloat(varios);
							
							if (totalImpresorasByN!=null)
								totalLinea = parseFloat(totalLinea) + parseFloat(totalImpresorasByN);
							
							if (totalImpresorasColor!=null)
								totalLinea = parseFloat(totalLinea) + parseFloat(totalImpresorasColor);
								
							if (totalMaquinasByN!=null)
								totalLinea = parseFloat(totalLinea) + parseFloat(totalMaquinasByN);
								
							if (totalMaquinasColor!=null)
								totalLinea = parseFloat(totalLinea) + parseFloat(totalMaquinasColor);

								
							//+ totalImpresorasByN + totalImpresorasColor + totalMaquinasByN + totalMaquinasColor;
							if (totalLinea !=0){
							var newRowContent = "<tr class='trStyle'>" +
													"<td>"+array[x].solicitudId+"</td>" +
													"<td>"+array[x].codigo+"</td>" +
													"<td>"+array[x].esb+"</td>" +
													"<td>"+array[x].departmento+"</td>" +
													"<td>"+array[x].subdepartmento+"</td>" +
													"<td>"+array[x].fecha+"</td>" +
													"<td>"+parseFloat(array[x].encuadernacion).toFixed(2)+"</td>" +
													"<td>"+parseFloat(array[x].byn).toFixed(2)+"</td>" +
													"<td>"+parseFloat(array[x].color).toFixed(2)+"</td>" +
													"<td>"+parseFloat(array[x].varios).toFixed(2)+"</td>" +
													"<td>"+array[x].nombre+"</td>" +
													"<td>"+array[x].descripcion.trim()+"</td>" +
													"<td>"+parseFloat(array[x].byn_maquina).toFixed(2)+"</td>" +
													"<td>"+parseFloat(array[x].color_maquina).toFixed(2)+"</td>" +
													"<td>"+parseFloat(array[x].byn_impresora).toFixed(2)+"</td>" +
													"<td>"+parseFloat(array[x].color_impresora).toFixed(2)+"</td>" +
													"<td>"+parseFloat(totalLinea).toFixed(2)+"</td>" +
												"</tr>";
							}else{
								var newRowContent = null;
							}
							}else{
								var byn = 0;
								var color = 0;
								var encuadernacion = 0;
								var varios = 0;
								if (array[x].byn != null)
									byn = array[x].byn;
								if (array[x].color != null)
									color = array[x].color;
								if (array[x].encuadernacion != null)
									encuadernacion = array[x].encuadernacion;
								if (array[x].varios != null)
									varios = array[x].varios;
								var totalLinea = parseFloat(byn) + parseFloat(color) + parseFloat(encuadernacion) + parseFloat(varios);
								if (totalLinea !=0){
								newRowContent = "<tr class='trStyle'>" +
									"<td>"+array[x].codigo+"</td>" +
									"<td>"+array[x].esb+"</td>" +
									"<td>"+array[x].departamento+"</td>" +
									"<td>"+array[x].subdepartamento+"</td>" +
									"<td>"+parseFloat(encuadernacion).toFixed(2)+"</td>" +
									"<td>"+parseFloat(byn).toFixed(2)+"</td>" +
									"<td>"+parseFloat(color).toFixed(2)+"</td>" +
									"<td>"+parseFloat(varios).toFixed(2)+"</td>" +
									"<td>"+parseFloat(totalLinea).toFixed(2)+"</td>" +
								"</tr>";
								}else{
									newRowContent = null;
								}
							}
							if (newRowContent!=null)
								$(newRowContent).appendTo($("#informeValidador"));
							totalAbsoluto = parseFloat(totalAbsoluto) + parseFloat(totalLinea);
						}
						if (tipoInforme == 'global'){
							var newRowTotal = "<tr class='trStyle'>"+
							"<td colspan='8'><div style='float:right;'>Total Informe:</div></td>"+
							"<td >"+parseFloat(totalAbsoluto).toFixed(2)+"</td>" +
							"</tr>";
						}else{
							var newRowTotal = "<tr class='trStyle'>"+
							"<td colspan='15'><div style='float:right;'>Total Informe:</div></td>"+
							"<td >"+parseFloat(totalAbsoluto).toFixed(2)+"</td>" +
							"</tr>";
							
						}
						$(newRowTotal).appendTo($("#informeValidador"));
					}
				}
			})
			//Error en la consulta o comunicacion con la bbdd.
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
			});
		}
	});

	$( "#excelAuth" ).click(function() {
		if (validacion()){
			location.href="../dao/select/mostramosExcelAutorizador.php?periodo="+periodo+"&departamento="+departamento+"&subdepartamento="+subdepartamento+"&tipoInforme="+tipoInforme;
		}
	});

	/*Funcion de validacion de los campos*/
	function validacion(){
		periodo =  $('#periodo').val();
		departamento =  $('#departamento').val();
		subdepartamento =  $('#subdepartamento').val();
		var errores =  false;
		if (periodo == "0"){
			errores = true;
			$('#errorMessage').show();
			$( "#errorMessage" ).html( "<center><span><h2>Por favor, seleccione el periodo</h2></span></center>" );
			return false;
		}
		if (departamento == "0"){
			errores = true;
			$('#errorMessage').show();
			$( "#errorMessage" ).html( "<center><span><h2>Por favor, seleccione el departamento</h2></span></center>" );
			return false;
		}
		if (departamento != "aa" && subdepartamento == "0" ){
			errores = true;
			$('#errorMessage').show();
			$( "#errorMessage" ).html( "<center><span><h2>Por favor, seleccione el subdepartamento</h2></span></center>" );
			return false;
		}
		if (tipoInforme == ""){
			errores = true;
			$('#errorMessage').show();
			$( "#errorMessage" ).html( "<center><span><h2>Por favor, seleccione el tipo de informe</h2></span></center>" );
			return false;
		}
		if (errores == false){
			$('#errorMessage').hide();
			return true;
		}
	}
});