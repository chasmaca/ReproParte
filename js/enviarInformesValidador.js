$(document).ready(function(){
	
	$( "#cerrar" ).click(function() {

		$.blockUI({ message: $('#question'), css: { width: '275px' } }); 
	});
	
	$('#yes').click(function() { 
        $.unblockUI(); 
        return false; 
    }); 

    $('#no').click(function() { 
        $.unblockUI(); 
        return false; 
    }); 
});
