function volverHome(){
	document.forms[0].action = "../index.php";
	document.forms[0].submit();
}

function listaExcel(){
	document.forms[0].action = "generaExcelImpr.php";
	document.forms[0].submit();
}
