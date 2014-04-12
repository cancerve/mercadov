/////////////////////////PESTANAS //////////////////////////		
	$(function() {
		$( "#tabs" ).tabs();
	});
////////////////////////////AGREGAR CONTACTOS EMPRESAS ///
	var nextinput = 0;
	var inicial = 0;
	function asignar(obj,valor){
		cmp = document.getElementById(obj);
		cmp.value = valor;
	}
	function AgregarCampos(cant){
		if(inicial==0){
			nextinput = cant-1;
			inicial = 1;	
		}
		nextinput++;
		asignar('cant_contac',nextinput);
			campo = '<table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro"><tr><td>&nbsp;'+(nextinput+1)+'&nbsp;</td><td><input type="text" name="NU_Cedula'+nextinput+'"></td><td><input type="text" name="AL_Nombre'+nextinput+'"></td><td><input type="text" name="AL_Apellido'+nextinput+'"></td><td><input type="text" name="AF_Cargo'+nextinput+'"></td></tr></table>';
			$("#campos").append(campo);
	}
///////////////////////////////////////CAMPOS FECHA RESTRINTIVAS////////////////////////

$(function() {
	$( "#FE_FechaNac1" ).datepicker({
		showAnim: 'slide',
		dateformat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100:+0'
	});
});

$(function() {
	$( "#fecha_egreso" ).datepicker({
		showAnim: 'slide',
		dateformat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '-100:+0'
	});
});

$(function() {
	$( "#FE_Inicio" ).datepicker({
		showAnim: 'slide',
		dateformat: 'dd-mm-yy',
		changeMonth: false,
		//defaultDate: "+1w",
		numberOfMonths: 1,
		minDate: 0, 
//		maxDate: "+1M +10D"
		onClose: function( selectedDate ) {
			$( "#FE_Fin" ).datepicker( "option", "minDate", selectedDate );
      	}
		//changeYear: true,
		//yearRange: '-100:+0'
	});
});

$(function() {
	$( "#FE_Fin" ).datepicker({
		showAnim: 'slide',
		dateformat: 'dd-mm-yy',
		//defaultDate: "+1w",
		changeMonth: false,
		numberOfMonths: 1,
		//changeYear: true,
		//yearRange: '-100:+0'
	});
});
