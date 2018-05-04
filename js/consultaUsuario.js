$(document).ready(function(){
	
	// Recupera los usuarios segun los filtros que le pasa el formulario
	var recuperaUsuarios = function(nombre,apellido, email, role) {

		return $.getJSON("../dao/select/recuperaUsuarios.php", {

			"nombre": nombre,
			"apellido": apellido,
			"email": email,
			"role": role

		});
	}
	
	$( "#consultaUsuarioButton" ).click(function() {
	
		var nombre = $('#nombre').val();
		var apellido = $('#apellido').val();
		var email = $('#logon').val();
		var role = $('#role').val();
		
		$('#tableResultados tr').remove();
		
		recuperaUsuarios(nombre,apellido, email, role).done(function(response) {

			if (!response.success) {

				alert("Problema con el JSON");

			}else{

				var array = $.map(response.data, function(value, index) {
				return [value];
	
				});

				if (array.length==0){
					/*Mostramos el mensaje de no hay resultados(Falta asignarle estilos) y ocultamos la tabla de resultados*/
					$("#tablaResultados").css("visibility","hidden");
					$("#noResultados").css("visibility","visible");
				}else{
					/*Ocultamos el mensaje de no hay resultados(Falta asignarle estilos) y mostramos la tabla de resultados*/
					$("#noResultados").css("visibility","hidden");
					$("#tablaResultados").css("visibility","visible"); 
					
					/*Pintamos la cabecera de la tabla*/
					var thead = "<tr><td>Id de Usuario</td><td>Nombre</td><td>Apellidos</td><td>Logon</td><td>Role</td></tr>";
					$(thead).appendTo($("#tableResultados"));
					
					for(var x=0; x<array.length;x++){

						/*Recoger valores*/
						var idUsuario = array[x].usuario_id;
						var nombre = array[x].nombre;
						var apellidos = array[x].apellido;
						var email = array[x].logon;
						var role = array[x].role_id;

						/*Pintamos las lineas de la tabla con los resultados de la query*/
						var newRowContent = "<tr><td>"+idUsuario+"</td><td>"+nombre+"</td><td>"+apellidos+"</td><td>"+email+"</td><td>"+role+"</td></tr>";
						$(newRowContent).appendTo($("#tableResultados"));

					}
				}
			}
		})
		//Error en la consulta o comunicacion con la bbdd.
		.fail(function(jqXHR, textStatus, errorThrown) {
			alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
		});
	});
});