function enviar(){
	var ok = 0;
	
	if (document.getElementById('modelo').value==""){
		
		document.getElementById('errorModelo').style.visibility = "visible";
		ok = 1;
	}

	if (document.getElementById('edificio').value==""){
		document.getElementById('errorEdificio').style.visibility = "visible";
		ok = 1;
	}

	if (document.getElementById('ubicacion').value==""){
		document.getElementById('errorUbicacion').style.visibility = "visible";
		ok = 1;
	}

	if (document.getElementById('fecha').value==""){
		document.getElementById('errorFecha').style.visibility = "visible";
		ok = 1;
	}

	if (document.getElementById('serie').value==""){
		document.getElementById('errorSerie').style.visibility = "visible";
		ok = 1;
	}

	if (document.getElementById('maquina').value==""){
		document.getElementById('errorMaquina').style.visibility = "visible";
		ok = 1;
	}

	if (ok==0)
		document.forms[0].submit();
}


function actualizaCamposModi(obj){
	document.getElementById('imprParam').value = obj.value;
	document.forms[0].submit();
	
}

function validaFormulario(){
var ok = 0;
	
	if (document.getElementById('modelo').value==""){
		
		document.getElementById('errorModelo').style.visibility = "visible";
		ok = 1;
	}

	if (document.getElementById('edificio').value==""){
		document.getElementById('errorEdificio').style.visibility = "visible";
		ok = 1;
	}

	if (document.getElementById('ubicacion').value==""){
		document.getElementById('errorUbicacion').style.visibility = "visible";
		ok = 1;
	}

	if (document.getElementById('fecha').value==""){
		document.getElementById('errorFecha').style.visibility = "visible";
		ok = 1;
	}

	if (document.getElementById('serie').value==""){
		document.getElementById('errorSerie').style.visibility = "visible";
		ok = 1;
	}

	if (document.getElementById('maquina').value==""){
		document.getElementById('errorMaquina').style.visibility = "visible";
		ok = 1;
	}

	if (ok==0){
		document.forms[0].action = "../dao/update/actualizaImpresora.php";
		document.forms[0].submit();
	}
		
}