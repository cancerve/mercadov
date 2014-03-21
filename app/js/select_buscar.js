//////////////////////FUNCION PARA TRAER OFICINAS COMERCIALES///////////////////////////
function load_Contactar_Empresa()
{
	var xmlhttp;
	var n=document.getElementById('AF_CodEvento').value;
	
	if(n==''){
		document.getElementById("myDiv").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST","http://localhost/MERCADO VIRTUAL DE VENALCASA/app/includes/select_buscar.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("Contactar_Empresa="+n);
}
///////////////FUNCION PARA TRAER OFICINAS COMERCIALES//////////////////////////////////
function load_Oficinas()
{
	var xmlhttp;
	var n=document.getElementById('AF_CodEvento').value;
	
	if(n==''){
		document.getElementById("myDiv").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST","http://localhost/MERCADO VIRTUAL DE VENALCASA/app/includes/select_buscar.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("AF_CodEvento2="+n);
}
//FUNCION PARA TRAER EMPRESAS PARTICIPANTES CON SIMILAR COD ARANCEL///////////
function load_Emp_Cita()
{
	var xmlhttp;
	var n=document.getElementById('AF_CodEvento').value;
	
	if(n==''){
		document.getElementById("myDiv").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST","http://localhost/MERCADO VIRTUAL DE VENALCASA/app/includes/select_buscar.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("Emp_Cita="+n);
}
//FUNCION PARA TRAER EMPRESAS CANDIDATAS CON SIMILAR COD ARANCEL AL EVENTO///////////
function load_Emp_Candi()
{
	var xmlhttp;
	var n=document.getElementById('AF_CodEvento').value;
	
	if(n==''){
		document.getElementById("myDiv").innerHTML="";
		return;
	}

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST","http://localhost/MERCADO VIRTUAL DE VENALCASA/app/includes/select_buscar.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("Emp_Candi="+n);
}