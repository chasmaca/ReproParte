$(document).ready(function(){
	
	// recuperaPeriodo será nuestra función recuperar los perido con solicitudes    
	var recuperaUsuarios = function() {

		return $.getJSON("../dao/select/usuariosJSON.php", {

		});

	}
	
	$( "#exportaUsuarios" ).click(function() {
		recuperaUsuarios().done(function(response) {
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
						var newRowContent = "<tr class='trStyle'>" +
						"<td>"+array[x].nombre+"</td>" +
						"<td>"+array[x].rol+"</td>" +
						"<td>"+array[x].nombreDepartamento+"</td>" +
						"</tr>";
						$(newRowContent).appendTo($("#exportUsuarios"));
					}
				}
			}
		})
		//Error en la consulta o comunicacion con la bbdd.
		.fail(function(jqXHR, textStatus, errorThrown) {
			alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
		});
		
	});
	
	$( "#excelUsuarios" ).click(function() {

		location.href="../dao/select/excelUsuarios.php";

	});
});