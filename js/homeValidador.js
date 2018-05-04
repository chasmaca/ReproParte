var selectDpto ="";
var selectSubdpto ="";
var departamentoId = "";

var recuperamosSubXDep = function(departamento){
	return $.getJSON("../dao/select/subdepartamentoJSON.php", {
		"departamento": departamento
	});
}

var modificarDepartamentosPorValidador = function(idFinal, valor, subdepartamento) {
	return $.getJSON("../dao/update/modificarDepartamentoSolicitud.php", {
		solicitud_id: idFinal,
    	departamento_id: valor,
    	subdepartamento_id: subdepartamento
	});
}

var modificarSubDepartamentosPorValidador = function(idFinal, subdepartamento) {
	return $.getJSON("../dao/update/modificarSubdepartamentoSolicitud.php", {
		solicitud_id: idFinal,
    	subdepartamento_id: subdepartamento
	});
}

var modificarStatusSolicitud = function(id, operacion) {
	return $.getJSON("../dao/update/modificarStatusSolicitud.php", {
		solicitudId: id,
		operacion: operacion
	});
}

$(document).ready(function(){

	var recuperaDepartamentosPorValidador = function() {

		return $.getJSON("../dao/select/departamentoValidadorJSON.php", {

		});

	}

	recuperaDepartamentosPorValidador().done(function(responseDpto) {
		
		if (!responseDpto.success) {

			alert("Problema con el JSON");

		}else{
			var arrayDpto = $.map(responseDpto.data, function(value, index) {
				return [value];
			});
			
			if (arrayDpto.length==0){
				
				alert("no hay datos acerca de los departamentos");
			
			}else{
				
				selectDpto = "<select name='dpto' id='dpto' class='target'>";
				
				for(var i=0; i<arrayDpto.length;i++){
					
					selectDpto = selectDpto + "<option value='"+arrayDpto[i].departamento_id+"'>"+arrayDpto[i].departamentos_desc+"</option>";
								
				}

				selectDpto = selectDpto + "</select>";
			}
		}
		
	})
	//Error en la consulta o comunicacion con la bbdd.
	.fail(function(jqXHR, textStatus, errorThrown) {
		alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
	});
	
	var solicitudId = "";
	var departamento = "";
	var subdepartamento = "";
	var nombre = "";
	var apellidos = "";
	var fechaAlta = "";
	var descripcion = "";
	
	$.ajax({
        type: "get",
        url: "../dao/select/solicitud.php",
        success: function (data) {
        	
            var array = $.map(data.data, function(value, index) {
				return [value];
			});

            if (array.length==0){
				
				alert("no hay datos en el informe");
			
			}else{
				
				for(var x=0; x<array.length;x++){
					
					departamentoId = array[x].departamento_id;
					solicitudId = array[x].solicitud_id;
					subdepartamentoId = array[x].subdepartamento_id;
					
					var comboDpto = seleccionarDpto(departamentoId,solicitudId);
					var comboSubDpto = seleccionarSubDpto(subdepartamentoId,solicitudId);
	
					var nombreSolicitante = array[x].nombre_solicitante + " " + array[x].apellidos_solicitante;
					
					var newRowContent = 
					"<tr class='trStyle'>" +
						"<td>"+solicitudId+"</td>" +
						"<td>"+comboDpto+"</td>"+
						"<td>"+comboSubDpto+"</td></td>" +
						"<td>"+nombreSolicitante+"</td>" +
						"<td>"+array[x].fecha_alta+"</td>" +
						"<td>"+array[x].descripcion_solicitante+"</td>" +
						"<td><div id='enlaces"+x+ "'>" +
								"<a id='"+array[x].solicitud_id+"' class='aprobar' style='cursor: pointer;'><span style='color:black;'>Aprobar</span></a>"+
								"/" +
								"<a id='"+array[x].solicitud_id+"' class='rechazar' style='cursor: pointer;'><span style='color:black;'>Rechazar</span></a>"
						"</td>" +
					"</tr>";
					
					//../dao/update/solicitud.php?solicitudId=" + array[x].solicitud_id + "&operacion=A
					//javascript:habilitaCapa("+ array[x].solicitud_id +");' id='rechazo_solicitudId="+ array[x].solicitud_id +"
					$(newRowContent).appendTo($("#informeValidador"));

				}
			}
        }
	});
	
	$(document).on("change",".target",function() {
		var valor = $(this).val();
		var id = $(this).attr("id");

		var idFinal = id.replace("dpto","");
		var subdepartamento = "";
		recuperamosSubXDep(valor).done(function(responseSubdpto) {

			if (!responseSubdpto.success) {

				alert("Problema con el JSON");

			}else{

				var arraySubdpto = $.map(responseSubdpto.data, function(value, index) {

					return [value];

				});

				if (arraySubdpto.length==0){

					alert("no hay datos de subdepartamentos");

				}else{

					$('#subdpto'+idFinal).empty();
					
					for(var y=0; y<arraySubdpto.length;y++){
						
						if (subdepartamento == "" )
							subdepartamento = arraySubdpto[y].subdepartamento_id;

						$('#subdpto'+idFinal).append($("<option></option>").attr("value",arraySubdpto[y].subdepartamento_id).text(arraySubdpto[y].subdepartamento_desc)); 

					}
					
					selectSubdpto = selectSubdpto + "</select>";

				}

			}
			
			modificarDepartamentosPorValidador(idFinal,valor,subdepartamento).done(function(response) {
				alert("Ha actualizado el departamento con exito");
			})
			//Error en la consulta o comunicacion con la bbdd.
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
			});
			
		})
		//Error en la consulta o comunicacion con la bbdd.
		.fail(function(jqXHR, textStatus, errorThrown) {
			alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
		});
	});
	
	
	$(document).on("change",".targetSub",function() {
		var valor = $(this).val();
		var id = $(this).attr("id");
		var idFinal = id.replace("subdpto","");
		
		modificarSubDepartamentosPorValidador(idFinal,valor).done(function(response) {
			alert("Ha actualizado el subdepartamento con exito");
		})
		//Error en la consulta o comunicacion con la bbdd.
		.fail(function(jqXHR, textStatus, errorThrown) {
			alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
		});
	});
	
	$(document).on("click","#informeDetallado",function(){
		document.forms[0].action = "detalleAutorizador.php";
		document.forms[0].submit();
	});
	
	$(document).on("click","#volver",function(){
		document.forms[0].action = "../index.php";
		document.forms[0].submit();
	});
	
	/**
	 * //../dao/update/solicitud.php?solicitudId=" + array[x].solicitud_id + "&operacion=A
	 */
	$(document).on("click",".aprobar",function() {
		
		var id = $(this).attr("id");
		var idFinal = id.replace("subdpto","");
		var operacion = "2";
		
		modificarStatusSolicitud(idFinal,operacion).done(function(response) {
			document.forms[0].action = "homeValidador.php";
			document.forms[0].submit();
		})
		//Error en la consulta o comunicacion con la bbdd.
		.fail(function(jqXHR, textStatus, errorThrown) {
			
			alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
			document.forms[0].action = "homeValidador.php";
			document.forms[0].submit();
		});
	});

	$(document).on("click",".rechazar",function() {
		var id = $(this).attr("id");
		var idFinal = id.replace("subdpto","");
		document.getElementById("capa1").style.display = "block";
		document.getElementById("capa1").style.opacity = "0.5";
		document.getElementById("solicitudId").value=idFinal;

	});

});

function seleccionarDpto(dpto, linea){

	var seleccion = dpto + "'";
	var seleccionFinal = dpto + "' selected";
	var deleteOptionSelected = "' selected>";

	var selectDptoFinal = selectDpto.replace(deleteOptionSelected, "'>");

	selectDptoFinal = selectDptoFinal.replace("<select name='dpto' id='dpto' class='target'>", "<select name='dpto"+linea+"' id='dpto"+linea+"' class='target'>");

	if (selectDptoFinal.indexOf(seleccion)!=-1){

		selectDptoFinal = selectDptoFinal.replace(seleccion, seleccionFinal);

	}

	selectSubdpto = "<select name='subdpto"+linea+"' id='subdpto"+linea+"' class='targetSub'>";
	
	return selectDptoFinal;

}

function seleccionarSubDpto(subdepartamentoId,linea){

	recuperamosSubXDep(departamentoId).done(function(responseSubdpto) {

		if (!responseSubdpto.success) {

			alert("Problema con el JSON");

		}else{

			var arraySubdpto = $.map(responseSubdpto.data, function(value, index) {

				return [value];

			});

			if (arraySubdpto.length==0){

				alert("no hay datos de subdepartamentos");

			}else{

				for(var y=0; y<arraySubdpto.length;y++){
					if (arraySubdpto[y].subdepartamento_id == subdepartamentoId)
						$('#subdpto'+linea).append($("<option></option>").attr("value",arraySubdpto[y].subdepartamento_id).attr("selected","selected").text(arraySubdpto[y].subdepartamento_desc)); 
					else
						$('#subdpto'+linea).append($("<option></option>").attr("value",arraySubdpto[y].subdepartamento_id).text(arraySubdpto[y].subdepartamento_desc)); 
				}
				selectSubdpto = selectSubdpto + "</select>";
			}

		}

	})
	//Error en la consulta o comunicacion con la bbdd.
	.fail(function(jqXHR, textStatus, errorThrown) {
		alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
	});

	return selectSubdpto;
}

function envioRechazo(){

	var id = document.getElementById("solicitudId").value;
	var comentarios = document.getElementById("razonRechazo").value;
	var accion = "../dao/update/solicitud.php?solicitudId=" + id + "&operacion=D&comentario="+comentarios;

	document.forms[0].method="get";
	document.forms[0].action=accion;
	document.forms[0].submit();
}

