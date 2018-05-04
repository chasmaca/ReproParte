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
	
	$(document).on("click","#borraDpto",function() {
		$.ajax({
			type:     "get",
	        data: 
	        { 
	        	
	        	departamentoId:	$("#departamento").val()
	        	
        	},
	        url: "../dao/delete/deleteDepartamentoJSON.php",
		    success: function (data) {
	        	alert ("Se ha eliminado el departamento");
	        	location.href="../formularios/borraDepartamento.php";
	        },
    		error: function(xhr, status, error) {
    			if (xhr.readyState == 4){
    				alert ("Se ha eliminado el departamento");
		        	location.href="../formularios/borraDepartamento.php";
    			}else{
    			  var err = xhr.responseText;
    			  alert(err.Message);
    			}
    		}
		});
		
	});
	
});
