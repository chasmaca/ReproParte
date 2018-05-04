$(document).ready(function(){

	// recuperaPeriodo será nuestra función recuperar los perido con solicitudes    
	var comprobarLogin = function(usuario, password) {
		return $.getJSON("dao/select/loginJSON.php", {
			"usuario":usuario,
			"password":password
		});
	}
	
	$(document).on("click","#goButton",function() {
		var userPassword = $("#pwd").val();
		
		if (valida()){
			$.ajax({
				type:     'post',
				dataType : 'json',
		        data: 
		        { 
		        	usuario: $("#usuario").val(),
		        	password: userPassword,
		        	accion:"logon"
	        	},
		        url: 'dao/select/loginJSON.php',
			    success: function (response) {
			    	if (!response.success){
			    		$( "#error" ).empty();
						$('<label for="password" style="color:red;"><p>Error en la password y/o contraseña</p></label>').appendTo('#error');
			    	}else{
			    		var role = response.data[0].role_id;

			    		switch(role) {
					    case 1:
					    	location.href="formularios/homeAdministrador.php";
					        break;
					    case 2:
					    	location.href="formularios/homeGestor.php";
					        break;
					    case 3:
					    	location.href="formularios/homeValidador.php";
					        break;
					    case 4:
					    	location.href="formularios/homeTrabajo.php";
					        break;
					    case 6:
					    	location.href="formularios/homeImpresora.php";
					        break;
						}
			    		
			    	}
		        },
        		error: function(xhr, status, error) {
        			  var err = eval("(" + xhr.responseText + ")");
        			  alert(err.Message);
        			}
			});

		}else{
			$( "#error" ).empty();
			$('<label for="password" style="color:red;"><p>Error en la password y/o contraseña</p></label>').appendTo('#error');
		}
	});
	
});

function valida(){

	var validacion =  true;
	
	if ($("#usuario").val()=="")
		validacion =  false;
	
	if ($("#pwd").val()=="")
		validacion =  false;
	
	return validacion;
}