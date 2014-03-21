function nuevoAjax()
{ 
	var xmlhttp=false;
	try	{ xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");	}
	catch(e){
		try	{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E){
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}

function cargaContenido(action,idSelectOrigen,idSelectDestino,sede_NU_IdSede,gerencia_NU_IdGerencia)
{
	var selectOrigen=document.getElementById(idSelectOrigen);
	var opcionselect=selectOrigen.options[selectOrigen.selectedIndex].value;
	var selectDestino=document.getElementById(idSelectDestino);
	var ajax=nuevoAjax();
	if (action===1){
		ajax.open("GET", "http://localhost/VENALCASA/mercadov/app/includes/select_dependientes.php?accion=1&&idSelectDestino="+idSelectDestino+"&opcion="+opcionselect+"&sede_NU_IdSede="+sede_NU_IdSede+"&gerencia_NU_IdGerencia="+gerencia_NU_IdGerencia, true);
	}else{
		ajax.open("GET", "http://localhost/VENALCASA/mercadov/app/includes/select_dependientes.php?accion=2&&idSelectDestino="+idSelectDestino+"&opcion="+opcionselect+"&gerencia_NU_IdGerencia="+gerencia_NU_IdGerencia, true);
	}
	ajax.onreadystatechange=function() 
	{ 
		if (ajax.readyState==4)
		{
			selectDestino.parentNode.innerHTML=ajax.responseText;
		} 
	}
	ajax.send(null);
}