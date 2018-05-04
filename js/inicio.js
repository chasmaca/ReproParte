function envioLogin(){
	document.forms[0].action = "formularios/login.php";
	document.forms[0].method = "post";
	document.forms[0].submit();
}

function envioSolicitud(){
	document.forms[0].action = "formularios/nuevaSolicitud.php";
	document.forms[0].method = "post";
	document.forms[0].submit();
}

function accesoLogin(){
	document.forms[0].action = "index_usuarios.php";
	document.forms[0].method = "post";
	document.forms[0].submit();
}