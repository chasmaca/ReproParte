function envioPassword(){
	document.forms[0].action = "nuevaPassword.php";
	document.forms[0].submit();
}

function volverPassword(){
	document.forms[0].action = "../../index.php";
	document.forms[0].submit();
}

function actualizarPassword(){
	if (validaCamposPwd()){
		document.forms[0].action = "../../dao/update/cambioPassword.php";
		document.forms[0].submit();
	}
}

function validaCamposPwd(){
	
	var mensaje="";
	var resultado = true;
	
	var objEmail = document.forms[0].email.value;
	var objPwd = document.forms[0].pwd.value;
	var objPwdRep = document.forms[0].pwdRep.value;
	
	
	if (resultado == true){
		if (objEmail == ""){
			document.getElementById('errorEmail').innerHTML='Debe completar el correo electrónico';
			document.getElementById('errorEmail').style.visibility='visible';
			resultado = false;
		}else{
			document.getElementById('errorEmail').style.visibility='hidden';
		}
	}
	
	if (resultado == true){
		if (objPwd == "" ){
			document.getElementById('errorPassword').innerHTML='Debe completar la password';
			document.getElementById('errorPassword').style.visibility='visible';
			resultado = false;
		}else{
			document.getElementById('errorPassword').style.visibility='hidden';
		}
	}

	if (resultado == true){
		if (objPwdRep == ""){
			document.getElementById('errorPasswordRep').innerHTML='Debe completar la password';
			document.getElementById('errorPasswordRep').style.visibility='visible';
			resultado = false;
		}else{
			document.getElementById('errorPasswordRep').style.visibility='hidden';
		}
	}
	
	if (resultado == true){
		if (objPwdRep != objPwd){
			document.getElementById('errorPasswordRep').innerHTML='Ambas contraseñas deben coincidir';
			document.getElementById('errorPasswordRep').style.visibility='visible';
			resultado = false;
		}else{
			document.getElementById('errorPasswordRep').style.visibility='hidden';
		}
	}

	if (resultado == true){
		if (validarEmail(objEmail)== false){
			document.getElementById('errorEmail').innerHTML='Debe rellenar un email valido';
			document.getElementById('errorEmail').style.visibility='visible';
			resultado = false;
		}else{
			document.getElementById('errorEmail').style.visibility='hidden';
		}
	}
	return resultado;
}

function validarEmail( email ) {
	var resultado = true;
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
        resultado = false;
    return resultado;
}