$(document).ready(function(){

	// recuperaDepartamento será nuestra función recuperar los departamentos
	var recuperaDepartamento = function(){
		return $.getJSON("../dao/select/departamentoJSON.php", {
		});
	}

	// recuperaDepartamento será nuestra función recuperar los departamentos
	var recuperaSubDepartamento = function(departamentoId){
		return $.getJSON("../dao/select/subdepartamentoJSON.php", {
			"departamento" : departamentoId
		});
	}

	// recuperaDepartamento será nuestra función recuperar los departamentos
	var recuperaDetalleSubDepartamento = function(departamentoId, subdepartamentoId){
		return $.getJSON("../dao/select/subdepartamentoDetalleJSON.php", {
			"departamento" : departamentoId,
			"subdepartamento" : subdepartamentoId
		});
	}
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
				var valor = "--";
				var texto = "Seleccione el Departamento";
				$('#departamento').append($("<option></option>").attr("value",valor).text(texto));
				for(var x=0; x<array.length;x++){
					$('#departamento').append($("<option></option>").attr("value",array[x].identificador).text(array[x].ceco + " - " + array[x].descripcion)); 
				}
			}
		}
	})
	//Error en la consulta o comunicacion con la bbdd.
	.fail(function(jqXHR, textStatus, errorThrown) {
		alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
	});

	$(document).on("change","#departamento",function() {
		var id = $("#departamento option:selected").val();
		/*Cargamos el combo de subdepartamentos*/
		recuperaSubDepartamento(id).done(function(response){
			if (!response.success) {
				alert("Problema con el JSON");
			}else{
				var array = $.map(response.data, function(value, index) {
					return [value];
				});
				if (array.length==0){
					alert("no hay datos de departamentos");
				}else{
					var valor = "--";
					var texto = "Seleccione el SubDepartamento";
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
	});

	$(document).on("change","#subdepartamento",function() {
		var departamentoId = $("#departamento option:selected").val();
		var subdepartamentoId = $("#subdepartamento option:selected").val();
		recuperaDetalleSubDepartamento(departamentoId,subdepartamentoId).done(function(response){
			if (!response.success) {
				alert("Problema con el JSON");
			}else{
				var array = $.map(response.data, function(value, index) {
					return [value];
				});
				if (array.length==0){
					alert("no hay datos de departamentos");
				}else{
					var valor = "--";
					var texto = "Seleccione el SubDepartamento";
					for(var x=0; x<array.length;x++){
						$('#nombreSubDepartamento').val(array[x].subdepartamento_desc);
						$('#treintabarra').val(array[x].treintabarra);
					}
				}
			}
		});
	});

	$(document).on("click","#modificaSubDpto",function() {
		var esValido = true;
		if ($('#nombreSubDepartamento').val()==""){
			alert("Debes completar el nombre del subdepartamento");
			esValido = false;
		}
		if ($('#treintabarra').val()==""){
			alert("Debes completar el CECO del subdepartamento");
			esValido = false;
		}
		if (esValido)
			document.forms[0].submit();
	});

	$(document).on("click","#borraSubDpto",function() {
		document.forms[0].submit();
	});
});