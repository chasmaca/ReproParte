function actualizaValores(obj){
	
	var precio = actualizaPrecio(obj)
	var id = obj.id;
	var valor = obj.value;
	
	var campo = 'tablaValores'+id.substring(9,10);
	var identificadores = id.substring(9,id.length);

	if (document.getElementById(campo).value == "")
		document.getElementById(campo).value = identificadores + "_" + valor + "_" + precio;
	else
		document.getElementById(campo).value = 
			 document.getElementById(campo).value + ";" + identificadores + "_" + valor + "_" + precio;

}

function actualizaValoresExtra(obj){
	
	var precio = actualizaPrecioExtra(obj)
	var id = obj.id;
	var valor = obj.value;
	var identificadores = id.substring(7,id.length);
	
	var campoExtra = 'tablaValores7';
	var nombre = document.getElementById("nombre_"+identificadores).value;
	var cantidad = document.getElementById("cantidad_"+identificadores).value;
	var precio = document.getElementById("precio_"+identificadores).value;
	var total = document.getElementById("total_"+identificadores).value;
	
	if (document.getElementById(campoExtra).value == "")
		document.getElementById(campoExtra).value = identificadores + "#" + nombre + "#" + cantidad + "#" + precio + "#" + total ;
	else
		document.getElementById(campoExtra).value = 
			 document.getElementById(campoExtra).value + ";" +  identificadores + "#" + nombre + "#" + cantidad + "#" + precio + "#" + total;
	
}


function  actualizaPrecio(obj){

	var id = obj.id;
	var identificadores = id.substring(9,id.length);
	var valor = obj.value;
	var precio = document.getElementById('precio_'+identificadores).value;
	var precioTotal = precio * valor;
	var precioTotal = precio * valor;
	precioTotal = parseFloat (precioTotal);
	precioTotal = precioTotal.toFixed(2);

	document.getElementById('total_' + identificadores).value = precioTotal;

	calculaSubtotal();

	return precioTotal;

}

function  actualizaPrecioExtra(obj){
	
	var id = obj.id;
	var identificadores = id.substring(7,id.length);
	var valor = document.getElementById("cantidad_"+identificadores).value;
	var precio = document.getElementById('precio_'+identificadores).value;
	var precioTotal = precio * valor;
	precioTotal = parseFloat (precioTotal);
	precioTotal = precioTotal.toFixed(2);
	
	document.getElementById('total_' + identificadores).value = precioTotal;
	
	
	
	calculaSubtotal()
	return precioTotal;
	
}

function calculaSubtotal(){
	
	var subtotalEspiral = 0;
	var subtotalEncolado = 0;
	var subtotalVarios1 = 0;
	var subtotalColor = 0;
	var subtotalVarios2 = 0;
	var subtotalByN = 0;

	for (x=0; x<document.forms[0].elements.length;x++){
		if (document.forms[0].elements[x].name.indexOf("total_1") == 0)
			subtotalEspiral = parseFloat (subtotalEspiral) + parseFloat (document.forms[0].elements[x].value);
		
		if (document.forms[0].elements[x].name.indexOf("total_2") == 0)
			subtotalEncolado = parseFloat (subtotalEncolado) + parseFloat (document.forms[0].elements[x].value);
		
		if (document.forms[0].elements[x].name.indexOf("total_3") == 0)
			subtotalVarios1 = parseFloat (subtotalVarios1) + parseFloat (document.forms[0].elements[x].value);
			
		if (document.forms[0].elements[x].name.indexOf("total_4") == 0)
			subtotalColor = parseFloat (subtotalColor) + parseFloat (document.forms[0].elements[x].value);
			
		if (document.forms[0].elements[x].name.indexOf("total_6") == 0)
			subtotalVarios2 = parseFloat (subtotalVarios2) + parseFloat (document.forms[0].elements[x].value);
		
		if (document.forms[0].elements[x].name.indexOf("total_7") == 0)
			subtotalVarios2 = parseFloat (subtotalVarios2) + parseFloat (document.forms[0].elements[x].value);
			
		
		if (document.forms[0].elements[x].name.indexOf("total_5") == 0)
			subtotalByN = parseFloat (subtotalByN) + parseFloat (document.forms[0].elements[x].value);
	}
	
		document.getElementById('subtotalEspiral').value = subtotalEspiral.toFixed(2);
		document.getElementById('subtotalEncolado').value = subtotalEncolado.toFixed(2);
		document.getElementById('subtotalVarios1').value = subtotalVarios1.toFixed(2);
		document.getElementById('subtotalColor').value = subtotalColor.toFixed(2);
		document.getElementById('subtotalByN').value = subtotalByN.toFixed(2);
		document.getElementById('subtotalVarios2').value = subtotalVarios2.toFixed(2);
		
		var totalFloat =  parseFloat(subtotalEspiral) +  parseFloat(subtotalEncolado) + 
		 parseFloat(subtotalVarios1) +  parseFloat(subtotalColor) + 
		 parseFloat(subtotalByN) +  parseFloat(subtotalVarios2);
		
		document.getElementById('total').value = parseFloat(totalFloat).toFixed(2);

}

function actualizarAction(){
	
	document.getElementById('detalleTrabajo').action = "cerrar";
	document.getElementById('detalleTrabajo').submit();
}

function rellenaTabla(obj) {
	//Recogemos la tabla
    var table = document.getElementById("tablaVarios2");
    
    //Posicionamiento de la fila
    var row = table.insertRow(table.rows.length -1);
    
    //Definicion de las celdas
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    
    //Recuperamos los datos del select para asignarlo a la celda
    var x = document.getElementById('varios2').selectedIndex;
    
    var descripcion = document.getElementsByTagName("option")[x].text;
    
    var valor = document.getElementsByTagName("option")[x].value;
    var valorSinPrecio = valor.substring(0,valor.indexOf("_"));
    var precio = valor.substring(valor.indexOf("_") +1 , valor.length);
    
    var nameCantidad = "cantidad_" + valorSinPrecio; 
    var cantidad = document.createElement("INPUT");
    cantidad.setAttribute("type", "text");
    cantidad.setAttribute("name", nameCantidad);
    cantidad.setAttribute("id", nameCantidad);
    cantidad.setAttribute("onblur", "javascript:actualizaValores(this);");
    cantidad.setAttribute("onkeypress", "return event.charCode >= 48 && event.charCode <= 57");
    
    var namePrecio = "precio_" + valorSinPrecio;
    var precioHidden =  document.createElement("INPUT");
    precioHidden.setAttribute("type", "hidden");
    precioHidden.setAttribute("name", namePrecio);
    precioHidden.setAttribute("id", namePrecio);
    precioHidden.setAttribute("value", precio);

    var nameTotal = "total_" + valorSinPrecio; 
    var precioTotal = document.createElement("INPUT");
    precioTotal.setAttribute("type", "text");
    precioTotal.setAttribute("name", nameTotal);
    precioTotal.setAttribute("id", nameTotal);
    precioTotal.setAttribute("readOnly", true);

    var qtyLabel = document.createElement("label");
    qtyLabel.innerHTML = precio;

    //Asignamos valores a las celdas
    cell1.innerHTML = descripcion
    cell2.appendChild(cantidad);
    cell3.appendChild(qtyLabel);
    cell3.appendChild(precioHidden);
    cell4.appendChild(precioTotal);
}


function sumaLinea(){
	//Recogemos la tabla
    var table = document.getElementById("tablaVarios2");
   
    //Posicionamiento de la fila
    var row = table.insertRow(table.rows.length -1);
    
    //Definicion de las celdas
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    //Nombre del campo
    var longitud = table.rows.length -1;
    
    //Definicion de las cajas de texto
    var nombreDescripcion="nombre_7-"+longitud;
    var descripcion = document.createElement("INPUT");
    descripcion.setAttribute("type", "text");
    descripcion.setAttribute("name", nombreDescripcion);
    descripcion.setAttribute("id", nombreDescripcion);

    var nombreCantidad="cantidad_7-"+longitud;
    var cantidad = document.createElement("INPUT");
    cantidad.setAttribute("type", "text");
    cantidad.setAttribute("name", nombreCantidad);
    cantidad.setAttribute("id", nombreCantidad);
    cantidad.setAttribute("onkeypress", "return event.charCode >= 48 && event.charCode <= 57");
    
    var nombreUnidad = "precio_7-"+longitud;
    var unidad = document.createElement("INPUT");
    unidad.setAttribute("type", "text");
    unidad.setAttribute("name", nombreUnidad);
    unidad.setAttribute("id", nombreUnidad);
    unidad.setAttribute("onkeyup", "javascript:check(this,event);");
    unidad.setAttribute("onblur", "javascript:actualizaValoresExtra(this);");
    
    var nombreTotal = "total_7-"+longitud;
    var precioTotal = document.createElement("INPUT");
    precioTotal.setAttribute("type", "text");
    precioTotal.setAttribute("name", nombreTotal);
    precioTotal.setAttribute("id", nombreTotal);


  //Asignamos valores a las celdas
    cell1.appendChild(descripcion);
    cell2.appendChild(cantidad);
    cell3.appendChild(unidad);
    cell4.appendChild(precioTotal);
}

function check(Sender,e){

	  var key = e.which ? e.which : e.keyCode;
	  if(key == 188){
	     Sender.value = Sender.value.substring(0,Sender.value.length-1) + '.';
	     return false;
	  }
	}

function myDeleteFunction() {
    document.getElementById("myTable").deleteRow(0);
    
 
}

function volverHome(){
	document.forms[0].action = "actualizaEstado.php";
	document.forms[0].submit();
}

function closeWork(){
	
	document.getElementById('cerramosTrabajo').value="1";
	document.forms[0].submit();
}

function guardarTrabajo(){

	document.forms[0].submit();
	
}

function habilitaCapa(capa){
	obj = document.getElementById(capa);
	
	 if (obj.style.display == "none"){
		 obj.style.display = "table-row-group";
	 }else{
		 obj.style.display = "none";
	 }
}

function calculaTotal(){
	var espiral = document.getElementById('subtotalEspiral').value;
	var encolado = document.getElementById('subtotalEncolado').value;
	var varios1 = document.getElementById('subtotalVarios1').value;
	var color = document.getElementById('subtotalColor').value;
	var blanco = document.getElementById('subtotalByN').value;
	var varios2 = document.getElementById('subtotalVarios2').value;
	
	if (isNaN(espiral))
		espiral = 0;
	
	if (isNaN(encolado))
		encolado = 0;
	
	if (isNaN(varios1))
		varios1 = 0;
	
	if (isNaN(color))
		color = 0;
	
	if (isNaN(blanco))
		blanco = 0;
	
	if (isNaN(varios2))
		varios2 = 0;

	var totalFloat = parseFloat(espiral) + parseFloat(encolado) + parseFloat(varios1) + parseFloat(color) + parseFloat(blanco) + parseFloat(varios2);
	document.getElementById('total').value = parseFloat(totalFloat).toFixed(2);  
}
