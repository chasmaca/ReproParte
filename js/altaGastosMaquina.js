$(document).ready(function(){

	// insertaGastosImpresora será nuestra función para enviar la solicitud de insercion y actualizacion ajax    
	var insertaGastosMaquina = function(periodo,departamento, unidades, precio, total,tipo) {

		return $.getJSON("../dao/insert/guardarGastosMaquina.php", {

			"periodo": periodo,
			"departamento": departamento,
			"unidades": unidades,
			"precio": precio,
			"total": total, 
			"tipo": tipo

		});

	}

	//recuperaGastosImpresora realizara la llamada para gestionar la consulta de los gastos
	var recuperaGastosMaquina = function(periodo){

		return $.getJSON("../dao/select/recuperaGastosMaquina.php",{

			"periodo": periodo

		});

	}

	var coma = ",";
	var punto = ".";
	var guion = "_";
	var periodo = "";
	var color = "Color";
	var byn = "ByN";

	//Controlamos el combo de periodo;
	$('select').on('change', function() {

		periodo = $(this).val();

		if (periodo != 0){

			recuperaGastosMaquina(periodo).done(function(response) {

				if (!response.success) {

					alert("Problema con el JSON");

				}else{

					var array = $.map(response.data, function(value, index) {
					return [value];
		
					});

					if (array.length==0){
						$('input.input').val('');
						$('input.valor').val('');
					}else{
						for(var x=0; x<array.length;x++){
	
							/*Recoger valores*/
							var idDepartamento = array[x].departamento_id;
							var unidadesByN = array[x].byn_unidades;
							var precioByN = array[x].byn_precio;
							var totalByN = array[x].byn_total;
							var unidadesColor = array[x].color_unidades;
							var precioColor = array[x].color_precio;
							var totalColor = array[x].color_total;
	
	
							/*Recoger nombres del campos*/
							var unidadB = '#numeroBN_' + idDepartamento;
							var precioB = '#precioBN_' + idDepartamento;
							var totalB = 	'#valorBN_' + idDepartamento;
							var unidadC = '#numeroColor_' + idDepartamento;
							var precioC = '#precioColor_' + idDepartamento;
							var totalC = 	'#valorColor_' + idDepartamento;
	
							/*Asignacion de los valores*/
							if (unidadesByN != null && unidadesByN != "")
								$(unidadB).val(unidadesByN);
							if (precioByN != null && precioByN != "" && precioByN != 0)
								$(precioB).val(precioByN);
							if (totalByN != null && totalByN != "")
								$(totalB).val(totalByN);
							if (unidadesColor != null && unidadesColor != "")
								$(unidadC).val(unidadesColor);
							if (precioColor != null && precioColor != "" &&  precioColor != 0)
								$(precioC).val(precioColor);
							if (totalColor != null && totalColor != "")
								$(totalC).val(totalColor);
						}
					}
				}
			})
			//Error en la consulta o comunicacion con la bbdd.
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
			});
		}else{
			$('input.input').val('');
			$('input.valor').val('');
		}
	});

	//Controlamos los input de las tablas
	$('input.input').on('blur', function() {

		var numero = $(this).val();
		var nombre = this.id;
		var sufijo = nombre.substr(6, nombre.lenght);
		var departamento = nombre.substr(nombre.indexOf(guion)+1, nombre.lenght);
		var tipo = "";

		//Realizamos las operaciones si el campo de texto tiene valor
		if (numero !=""){

			//Recogemos los campos asociados al elemento modificado
			var valorCampo = '#valor' + sufijo;
			var precioCampo = '#precio' + sufijo;
			var valorValue = "";

			//Reemplazamos la coma por el punto, para evitar problemas con la base de datos
			if (numero.indexOf(coma) != -1){
				numero = numero.replace (coma,punto);
			}

			//Realizamos la multiplicacion de los precios
			valorValue = numero * $(precioCampo).val();

			//Asignamos el valor al campo de Importe
			$(valorCampo).val(valorValue);

			//Controlamos el tipo de dato (Color/ ByN)
			if (sufijo.indexOf(color) == -1)
				tipo = byn;
			else
				tipo = color;

			//Realizamos la llamada para gestionar la transaccion con la bbdd.
			insertaGastosMaquina(periodo, departamento, numero, $(precioCampo).val(), $(valorCampo).val(),tipo)
			.done(function(response) {
				//done() es ejecutada cuándo se recibe la respuesta del servidor. response es el objeto JSON recibido. 
				//En caso que la operación sea correcta, no hacemos nada, en caso que sea erronea, mostramos un mensaje de error.
				if (!response) {
					alert("Elemento NO Guardado en BBDD");
				}
			})
			//Error en la consulta o comunicacion con la bbdd.
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
			});
		}
	});
});