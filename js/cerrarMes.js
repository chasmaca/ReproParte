$(document).ready(function(){
	
	// recuperaPeriodo será nuestra función recuperar los perido con solicitudes    
	var recuperaPeriodo = function() {

		return $.getJSON("../dao/select/periodoJSON.php", {
			opcion:"cierre"
		});

	}

	/*Cargamos el combo de periodos*/
	recuperaPeriodo().done(function(response) {
		
		if (!response.success) {

			alert("Problema con el JSON");

		}else{

			var array = $.map(response.data, function(value, index) {
				return [value];
	
			});
			
			if (array.length==0){
				
				alert("no hay datos de periodos");
			
			}else{
			
				for(var x=0; x<array.length;x++){
					
					var fecha = array[x].mes_alta + "/" + array[x].anio_alta;
					$('#periodo').append($("<option></option>").attr("value",fecha).text(fecha)); 
				
				}
			}
		}
	
	})
	//Error en la consulta o comunicacion con la bbdd.
	.fail(function(jqXHR, textStatus, errorThrown) {
		alert("Algo ha fallado: " + textStatus + "-->" + jqXHR.responseText);
	});

	$( "#cerrar" ).click(function() {
		$.blockUI({ message: $('#question'), css: { width: '275px' } }); 
	});
	
	$('#yes').click(function() { 
        $.unblockUI(); 
        // actualiza las solicitudes
        var periodo = $('#periodo').val();
        console.log('periodo');
        
        $.ajax({
			type:     "get",
	        data: 
	        { 
	        	periodo: periodo
        	},
	        url: "../dao/update/cerrarSolicitudJSON.php",
		    success: function (data) {
	        	alert ("Se ha cerrado correctamente el mes.");
	        },
    		error: function(xhr, status, error) {
    			alert ("Ha habido algun problema con el cierre del mes, por favor, consulte con el administrador.");
    			  //var err = eval("(" + xhr.responseText + ")");
    			 // alert(err.Message);
    		}
		});
//        $.ajax({
//			type:     "get",
//	        url: "../dao/update/cerrarSolicitudJSON.php",
//		    success: function () {
//	        	alert("Se han cerrado los partes.");
//	        },
//    		error: function(xhr, status, error) {
//    			alert("Problemas a la hora de cerrar los partes.");
//
//    		}
//		});
	
    }); 

    $('#no').click(function() { 
        $.unblockUI(); 
        return false; 
    }); 
});
