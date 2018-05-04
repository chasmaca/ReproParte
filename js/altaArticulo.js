function validaFormulario(){
	
	var ok = 0;
	
	if (document.getElementById('nombreArticulo').value == ""){
		alert ("Debe rellenar la Descripción del Artículo.");
		ok = 1;
	}
	
	if (document.getElementById('precio').value == ""){
		alert ("Debe rellenar el Precio del Articulo");
		ok = 1;
	}
	
	var regex  = /^\d+(?:\.\d{0,2})$/;
	
	if (!regex.test(document.getElementById('precio').value)){
		alert("El valor " + document.getElementById('precio').value + " no esta permitido. Use '.' para los decimales.");
		ok = 1;
	}

	if (ok == 0){
		document.forms[0].submit();
	}
		//
}