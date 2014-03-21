///////////////////////////////////VALIDAR FORMULARIO EVENTO
function validarAddEvento(){
	var error='';
	if (document.form1.pais_AL_CodPais.value==''){
		error+='- Debe seleccionar un Pais.\n';
	}
	if (document.form1.ciudad_AF_CodCiudad.value==''){
		error+='- Debe seleccionar una Ciudad.\n';
	}
	if (document.form1.AF_Nombre_Evento.value==''){
		error+='- Debe indicar el Nombre del Evento.\n';
	}
	if (document.form1.AF_Lugar.value==''){
		error+='- Debe indicar el Lugar del Evento.\n';
	}
	if (document.form1.FE_Fecha_Desde.value==''){
		error+='- Debe seleccionar la Fecha de Inicio.\n';
	}
	if (document.form1.FE_Fecha_Hasta.value==''){
		error+='- Debe seleccionar la Fecha de Finalizacion.\n';
	}
	if (document.form1.NU_Cantidad_Mesa.value==''){
		error+='- Debe seleccionar la Cantidad de Mesas.\n';
	}
	
	if (error){
		alert('Se encontraron los siguientes problemas:\n'+error);
	}else{
		document.form1.submit();
	}
}