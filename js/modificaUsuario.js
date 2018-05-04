/**
 * Funcion para recargar la pagina de modificacion de usuarios para que 
 * se actualice con los valores seleccionados.
 */
function rellenaCampos(){
	if (document.getElementById('usuario').value != 0){
		document.forms[0].action="cargaUsuarios.php";
		document.forms[0].submit();
	}
}

/**
 * Muestra o oculta la capa de datos de usuario en funcion si tiene o no valores
 */
function muestraCapa(){
	if (document.getElementById('id').value!=""){
		document.getElementById('datosUsuario').style.visibility = "visible";
		if (document.getElementById('role').value.trim() == 3)
			document.getElementById('divDpto').style.visibility = "visible";
		else
			document.getElementById('divDpto').style.visibility = "hidden";
	}else
		document.getElementById('datosUsuario').style.visibility = "hidden";
	
}

/**Generaa el arrayt con todas las opciones marcadas**/
function sumaDpto(){
	
}

function habilitaSeleccion(){
	var obj = document.getElementById('seleccionado');
	 
	for (var i=0; i<obj.options.length; i++) {
	    obj.options[i].selected = true;
	}
	
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

	if (document.getElementById('pwd').value == ""){
		alert ("Debe rellenar la Password del usuario");
		ok = 1;
	}
	
	if (ok == 0){
		document.forms[0].submit();
	}
	
}

function ocultarCapa(obj){
	if (obj.value.trim() == 3)
		document.getElementById('divDpto').style.visibility = "visible";
	else
		document.getElementById('divDpto').style.visibility = "hidden";
	
	
}