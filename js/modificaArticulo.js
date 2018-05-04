function actualizaDetalle(){
	if (document.getElementById('tipoId').value != 0){
		document.forms[0].action="modificaArticulo.php";
		document.forms[0].submit();
	}
}


function actualizaDetalleBorrar(){
	if (document.getElementById('tipoId').value != 0){
		document.forms[0].action="borraArticulo.php";
		document.forms[0].submit();
	}
}


function muestraDetalle(obj){

	var valor = obj.value;
	var cadenas = valor.split("-");
	var precioDetalle = cadenas[1];
	
	var capa = document.getElementById('detalleCampos');
	var capaBoton = document.getElementById('submitM');
	var precio = document.getElementById('precioDetalle');
	var descripcion = document.getElementById('nombreDetalle');

	capa.style.visibility = 'visible';
	precio.value = precioDetalle;
	descripcion.value = obj.options[obj.selectedIndex].innerHTML; 
	
	capaBoton.style.visibility = 'visible';

}

function validaFormulario(){
	
	var ok = 0;
	
	if (document.getElementById('nombreDetalle').value == ""){
		alert ("Debe rellenar la Descripción del Artículo.");
		ok = 1;
	}
	
	if (document.getElementById('precioDetalle').value == ""){
		alert ("Debe rellenar el Precio del Articulo");
		ok = 1;
	}
	
	var regex  = /^\d+(?:\.\d{0,2})$/;
	
	if (!regex.test(document.getElementById('precioDetalle').value)){
		alert("El valor " + document.getElementById('precioDetalle').value + " no esta permitido. Use '.' para los decimales.");
		ok = 1;
	}

	if (ok == 0){
		document.forms[0].submit();
	}
		//
}