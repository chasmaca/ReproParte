/**
 * Funcion que habilita la opcion de las carreras en caso que el rol sea autorizador
 */
function habilitaCapa(){
	if (document.getElementById('role').value==3)
		document.getElementById('capaAutorizador').style.visibility = "visible";
	else
		document.getElementById('capaAutorizador').style.visibility = "hidden";
}

/**
 * Recoge todos los valores que tenga seleccionado el listado de departamentos.
 */
function guardaValores(){

	var result = [];
	  var options = document.getElementById('departamento').options;
	  var opt;
	  document.getElementById('dpto').value = "";
	  
	  for (var i=0, iLen=options.length; i<iLen; i++) {
	    opt = options[i];

	    if (opt.selected) {
	    	document.getElementById('dpto').value =	document.getElementById('dpto').value + opt.value + "|" }
	  }
}

function pasaValores(obj){

	alert (obj.value);
}

function validaFormulario(){
	
	var ok = 0;
	
	if (document.getElementById('nombre').value == ""){
		alert ("Debe rellenar el Nombre del usuario");
		ok = 1;
	}
	
	if (document.getElementById('apellido').value == ""){
		alert ("Debe rellenar el Apellido del usuario");
		ok = 1;
	}
	
	if (document.getElementById('logon').value == ""){
		alert ("Debe rellenar el Email del usuario");
		ok = 1;
	}

	if (document.getElementById('pass').value == ""){
		alert ("Debe rellenar la Password del usuario");
		ok = 1;
	}
	if (ok == 0){
		document.forms[0].submit();
	}
		//
}