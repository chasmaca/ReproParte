$(document).ready(function(){

	var tipoInforme = "";
	var periodo =  "0";
	var departamento = "0";
	var subdepartamento = "0";
	
	// recuperaPeriodo será nuestra función recuperar los perido con solicitudes    
	var recuperaPeriodo = function() {

		return $.getJSON("../dao/select/periodoJSON.php", {

		});

	}
	
	// recuperaDepartamento será nuestra función recuperar los departamentos
	var recuperaDepartamento = function(){
		
		return $.getJSON("../dao/select/departamentoJSON.php", {
			"usuario": usuario
		});
		
	}

	//recuperamosSubXDep será nuestra función recuperar los subdepartamentos del departamento seleccionado
	var recuperamosSubXDep = function(departamento){

		return $.getJSON("../dao/select/subdepartamentoJSON.php", {
			
			"departamento": departamento
		
		});

	}
	
	
	
	//recuperamosListado Devolvemos el resultado de la consulta segun los parametros enviados. Se mostrara en una tabla.
	var recuperamosListado = function(periodoParam, departamentoParam, subdepartamentoParam, tipoInformeParam ){
		
		return $.getJSON("../dao/select/informeGestorJSON.php", {
			
			"periodo": periodoParam,
			"departamento": departamento,
			"subdepartamento": subdepartamentoParam,
			"tipoInforme": tipoInformeParam
		
		});

	}
	
	/*Cargamos el combo de periodos*/
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

					$('#departamento').append($("<option></option>").attr("value",array[x].identificador).text(array[x].descripcion)); 
				
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
			//	$("#informeGestor > thead > tr").remove();
				$("#informeGestor > thead > tr > th").remove();

				
				$("#informeGestor > thead > tr").append( '<th>Id Departamento</th>' );
				$("#informeGestor > thead > tr").append( '<th>Nombre Departamento</th>' );
				$("#informeGestor > thead > tr").append( '<th>Importe Blanco y Negro</th>' );
				$("#informeGestor > thead > tr").append( '<th>Importe Color</th>' );
				$("#informeGestor > thead > tr").append( '<th>Importe Encuadernacion</th>' );
				$("#informeGestor > thead > tr").append( '<th>Importe Varios</th>' );
				$("#informeGestor > thead > tr").append( '<th>Importe Impresoras</th>' );
				$("#informeGestor > thead > tr").append( '<th>Importe Maquinas</th>' );
				$("#informeGestor > thead > tr").append( '<th>Total</th>' );
								
			}else{
				
				$("#informeGestor > thead > tr > th").remove();

				
				$("#informeGestor > thead > tr").append( '<th>ESB</th>' );
				$("#informeGestor > thead > tr").append( '<th>CODIGO</th>' );
				$("#informeGestor > thead > tr").append( '<th>DEPARTAMENTO</th>' );
				$("#informeGestor > thead > tr").append( '<th>SUBDEPARTAMENTO</th>' );
				$("#informeGestor > thead > tr").append( '<th>BLANCO Y NEGRO</th>' );
				$("#informeGestor > thead > tr").append( '<th>COLOR</th>' );
				$("#informeGestor > thead > tr").append( '<th>ENCUADERNACIONES</th>' );
				$("#informeGestor > thead > tr").append( '<th>VARIOS</th>' );
				
				$("#informeGestor > thead > tr").append( '<th>TOTAL</th>' );

			}
			
			$("#informeGestor > tbody > tr").remove();
			
			
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
							
//							array[x].impresorasColor == null ? 0 : array[x].impresorasColor;
//							
//							array[x].maquinasByN == null ? 0 : array[x].maquinasByN;
//							
//							array[x].maquinasColor == null ? 0 : array[x].maquinasColor;

							var byn = 0;
							var color = 0;
							var encuadernacion = 0;
							var varios = 0;
							debugger;
							if (array[x].byn != null)
								byn = array[x].byn;

							if (array[x].color != null)
								color = array[x].color;

							if (array[x].encuadernacion != null)
								encuadernacion = array[x].encuadernacion;
							
							if (array[x].varios != null)
								varios = array[x].varios;
							
							var totalLinea = parseFloat(byn) + parseFloat(color) + parseFloat(encuadernacion) + parseFloat(varios);// + totalImpresorasByN;// + totalImpresorasColor + totalMaquinasByN + totalMaquinasColor;
							
							var newRowContent = "<tr class='trStyle'>" +
													"<td>"+array[x].codigo+"</td>" +
													"<td>"+array[x].ceco+"</td>" +
													"<td>"+array[x].departamentoDesc+"</td>" +
													"<td>"+array[x].subdepartamentos_desc+"</td>" +
													"<td>"+parseFloat(byn).toFixed(2)+"</td>" +
													"<td>"+parseFloat(color).toFixed(2)+"</td>" +
													"<td>"+parseFloat(encuadernacion).toFixed(2)+"</td>" +
													"<td>"+parseFloat(varios).toFixed(2)+"</td>" +
													"<td>"+parseFloat(totalLinea).toFixed(2)+"</td>" +
												"</tr>";
							}else{
								
								/*Pintamos las lineas de la tabla con los resultados de la query*/
								
								array[x].byn == null ? 0 : array[x].byn;
									
								array[x].color == null ? 0 : array[x].color;
								
								array[x].encuadernacion == null ? 0 : array[x].encuadernacion;
								
								array[x].varios == null ? 0 : array[x].varios;
								
								array[x].totalMaquinas == null ? 0 : array[x].totalMaquinas;
								
								array[x].totalImpresoras == null ? 0 : array[x].totalImpresoras;
								
								var totalLinea = array[x].byn + array[x].color + array[x].encuadernacion + array[x].varios + array[x].totalMaquinas + array[x].totalImpresoras;
								
								var byn = 0;
								var color = 0;
								var encuadernacion = 0;
								var varios = 0;
								var totalMaquinas = 0;
								var totalImpresoras = 0;
								
								if (array[x].byn != null)
									byn = array[x].byn;
								
								if (array[x].color != null)
									color = array[x].color;
									
								if (array[x].encuadernacion != null)
									encuadernacion = array[x].encuadernacion;
								
								if (array[x].varios != null)
									varios = array[x].varios;
								
								if (array[x].totalMaquinas != null)
									totalMaquinas = array[x].totalMaquinas;
								
								if (array[x].totalImpresoras != null)
									totalImpresoras = array[x].totalImpresoras;
								
								newRowContent = "<tr class='trStyle'>" +
								"<td>"+array[x].departamento_id+"</td>" +
								"<td>"+array[x].departamentos_desc+"</td>" +
								"<td>"+
									parseFloat(byn).toFixed(2)+
								"</td>" +
								"<td>"+parseFloat(color).toFixed(2)+"</td>" +
								"<td>"+parseFloat(encuadernacion).toFixed(2)+"</td>" +
								"<td>"+parseFloat(varios).toFixed(2)+"</td>" +
								"<td>"+parseFloat(totalImpresoras).toFixed(2)+"</td>" +
								"<td>"+parseFloat(totalMaquinas).toFixed(2)+"</td>" +
								"<td>"+parseFloat(totalLinea).toFixed(2)+"</td>" +
							"</tr>";
								
							}
							$(newRowContent).appendTo($("#informeGestor"));
							
							totalAbsoluto = parseFloat(totalAbsoluto) + parseFloat(totalLinea);
						}
						var newRowTotal = "<tr class='trStyle'>"+
								"<td colspan='8'><div style='float:right;'>Total Informe:</div></td>"+
								"<td >"+parseFloat(totalAbsoluto).toFixed(2)+"</td>" +
								"</tr>";
						$(newRowTotal).appendTo($("#informeGestor"));
						
					}

				}

			})
			//Error en la consulta o comunicacion con la bbdd.
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
			});
			
		}
		
	});
	
	$( "#excel" ).click(function() {
		if (validacion()){

			location.href="../dao/select/mostramosExcelGestor.php?periodo="+periodo+"&departamento="+departamento+"&subdepartamento="+subdepartamento+"&tipoInforme="+tipoInforme;
			
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