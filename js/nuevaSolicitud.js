
function envioSolicitud(){
	var envio = 0;
	var emailcheck = 0;
	
	if (document.getElementById('departamento').value==0){
		document.getElementById('errorDepartamento').style.visibility = "visible";
		envio = 1;
	}else{
		document.getElementById('errorDepartamento').style.visibility = "hidden";
	}

	if (document.getElementById('subdepartamento').value==0){
		document.getElementById('errorSubDepartamento').style.visibility = "visible";
		envio = 1;
	}else{
		document.getElementById('errorSubDepartamento').style.visibility = "hidden";
	}
	
	if (document.getElementById('nombre').value==""){
		document.getElementById('errorNombre').style.visibility = "visible";
		envio = 1;
	}else{
		document.getElementById('errorNombre').style.visibility = "hidden";
	}

	if (document.getElementById('apellidos').value==""){
		document.getElementById('errorApellidos').style.visibility = "visible";
		envio = 1;
	}else{
		document.getElementById('errorApellidos').style.visibility = "hidden";
	}
	

	var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

	if (re.test(document.getElementById('email').value)==false){
		document.getElementById('errorEmail').style.visibility = "visible";
		envio = 1;
		emailcheck = 1;
	}
	
	if (document.getElementById('email').value==""){
		document.getElementById('errorEmail').style.visibility = "visible";
		envio = 1;
		emailcheck = 1;
	}
	
	if (emailcheck == 0)
		document.getElementById('errorEmail').style.visibility = "hidden";

	
	if (document.getElementById('autorizador').value==0){
		document.getElementById('errorAutorizador').style.visibility = "visible";
		envio = 1;
	}else{
		document.getElementById('errorAutorizador').style.visibility = "hidden";
	}

	if (document.getElementById('comment').value==0){
		document.getElementById('errorComment').style.visibility = "visible";
		envio = 1;
	}else{
		document.getElementById('errorComment').style.visibility = "hidden";
	}

	if (envio==0){
		document.forms[0].action = "../dao/insert/solicitud.php";
		document.forms[0].submit();
	}
}


function seleccionaDpto(){
	if (document.getElementById('autorizador').value != 0){
		document.forms[0].action="nuevaSolicitud.php";
		document.forms[0].submit();
	}
}

function pasaValores(){
	document.forms[0].action="nuevaSolicitud.php";
	document.forms[0].submit();
}