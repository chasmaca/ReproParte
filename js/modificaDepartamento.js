$(document).ready(function(){
	
	// recuperaDepartamento será nuestra función recuperar los departamentos
	var recuperaDepartamento = function(){
		
		return $.getJSON("../dao/select/departamentoJSON.php", {

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

		var texto = $("#departamento option:selected").text();
		var ceco = texto.substring(0, texto.indexOf('-'));
		var departamento = texto.substring(texto.indexOf('-')+1, texto.length);
		
		$("#nombreDepartamento").val(departamento.trim());
		
		$("#CeCo").val(ceco.trim());

	});

	$(document).on("click","#modificaDpto",function() {
		if (validaFormulario()){
			$.ajax({
				type:     "get",
		        data: 
		        { 
		        	
		        	departamentoId:	$("#departamento").val(),
		        	departamentoNombre: $("#nombreDepartamento").val(),
		        	departamentoCeco: $("#CeCo").val()

	        	},
		        url: "../dao/update/updateDepartamentoJSON.php",
			    success: function (data) {
		        	alert ("Se ha realizado la modificación del departamento");
		        	location.href="../formularios/modificaDepartamento.php";
		        },
        		error: function(xhr, status, error) {
        			if (xhr.readyState == 4){
        				alert ("Se ha realizado la modificación del departamento");
    		        	location.href="../formularios/modificaDepartamento.php";
        			}else{
        			  var err = xhr.responseText;
        			  alert(err.Message);
        			}
        		}
			});
		}
		
	});
	
});

function validaFormulario(){
	
	var ok = true;
	
	if (document.getElementById('nombreDepartamento').value == ""){
		alert ("Debe rellenar el departamento");
		ok = false;
	}
	
	if (document.getElementById('CeCo').value == ""){
		alert ("Debe rellenar el CeCo");
		ok = false;
	}

	return ok;
}

