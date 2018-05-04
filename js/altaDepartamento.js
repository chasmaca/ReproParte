$(document).ready(function(){

	$( "#guardaDepartamento" ).click(function() {

		if (validaFormulario()){
			$.ajax({
				type:     "get",
		        data: 
		        { 
		        	departamento: $("#nombreDepartamento").val(),
	        		ceco: $("#CeCo").val()
	        	},
		        url: "../dao/insert/insertDepartamentoJSON.php",
			    success: function (data) {
		        	alert ("Se ha realizado el alta del departamento");
		        	location.href="../formularios/altaDepartamento.php";
		        },
        		error: function(xhr, status, error) {
        			  var err = eval("(" + xhr.responseText + ")");
        			  alert(err.Message);
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
	
	return ok		//
}


function validaFormularioSub(){
	
	var ok = 0;
	
	if (document.getElementById('departamento').value == "0"){
		alert ("Debe seleccionar el departamento");
		ok = 1;
	}
	
	if (document.getElementById('nombreSubDepartamento').value == ""){
		alert ("Debe rellenar el departamento");
		ok = 1;
	}
	
	if (document.getElementById('treintabarra').value == "30/"){
		alert ("Debe rellenar el Código 30/");
		ok = 1;
	}

	if (ok == 0){
		document.forms[0].submit();
	}
		//
}