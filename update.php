<?php 
	require_once("app/includes/constantes.php");
	require_once("app/includes/conexion.class.php");
	require_once('app/model/usuarioModel.php');
	require_once('app/model/saimeModel.php');
	
	$objConexion= new conexion(SERVER,USER,PASS,DB);
	$objUsuario = new Usuario();
	$objSaime	= new Saime();

	
	$RSUsuario 	= $objUsuario->listar($objConexion);
	$cantRS		= $objConexion->cantidadRegistros($RSUsuario);
	
	///// CONVIERTE FECHA 19800704 A 1980-07-04 (FORMATO MYSQL)

	function setFecha($fecha)
	{
		$anio			= substr($fecha,0,4);		 
		$mes			= substr($fecha,4,-2);		 
		$dia			= substr($fecha,6);		 		
		return $fecha = $anio.'-'.$mes.'-'.$dia;
	}	
	
	/////////// REFORMATEAR CORREO ELECTRONICO
	function setCorreo($string) {
		$string = trim($string);
	
		$string = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$string
		);
	
		$string = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$string
		);
	
		$string = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$string
		);
	
		$string = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$string
		);
	
		$string = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$string
		);
	
		$string = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C',),
			$string
		);
	
		//Esta parte se encarga de eliminar cualquier caracter extraño
		$string = str_replace(
			array("\\", "¨", "º", "~",
				 "#", "|", "!", "\"",
				 "$", "%", "&", "/",
				 "(", ")", "?", "'",
				 "¿", "[", "^", "`", "]",
				 "+", "}", "{", "¨", "´",
				 ">", "< ", ";", ",", ":",
				 " "),
			'',
			$string
		);
	
	
		return strtolower($string);
	}	
	
	///// CONVIERTE FECHA 1980-07-04 A 04071980 (FORMATO MYSQL)
	function setAF_Clave($AF_Clave)
	{
		/* /////// PARA CUANDO LA CLAVE SEA LA FECHA DE NACIMIENTO
		$eliminar = array("/", ".", " ", "-");
		$this->AF_Clave = md5(str_replace($eliminar, "", $AF_Clave));
		*/
		//$this->AF_Clave = md5($AF_Clave);
		$eliminar 		= array("/", ".", " ", "-");
		$fecha 	  		= str_replace($eliminar, "", $AF_Clave);
		$dia			= substr(str_replace($eliminar, "", $fecha),-2);		 
		$mes			= substr(str_replace($eliminar, "", $fecha),4,-2);		 
		$anio			= substr(str_replace($eliminar, "", $fecha),0,-4);
		return md5($dia.$mes.$anio);		 		
		//return $dia.$mes.$anio;
		
	}	

?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>ID</td>  
    <td>CEDULA</td>
    <td>NOMBRE</td>
    <td>APELLIDO</td>
    <td>FECHA NAC</td>
    <td>CLAVE</td>
    <td>CORREO</td>
    <td>TELEFONO</td>  
    <td>CORREOOOO 2</td>       
  </tr>
<?php
	for($i=0;$i<$cantRS;$i++){
		$NU_IdUsuario	= $objConexion->obtenerElemento($RSUsuario,$i,"NU_IdUsuario");						
		$NU_Cedula		= $objConexion->obtenerElemento($RSUsuario,$i,"NU_Cedula");						
		$AL_Nombre		= $objConexion->obtenerElemento($RSUsuario,$i,"AL_Nombre");						
		$AL_Apellido	= $objConexion->obtenerElemento($RSUsuario,$i,"AL_Apellido");						
		$FE_FechaNac	= $objConexion->obtenerElemento($RSUsuario,$i,"FE_FechaNac");						
		$AF_Clave		= $objConexion->obtenerElemento($RSUsuario,$i,"AF_Clave");												
		$AF_Correo		= $objConexion->obtenerElemento($RSUsuario,$i,"AF_Correo");						
		$AF_Telefono	= $objConexion->obtenerElemento($RSUsuario,$i,"AF_Telefono");												

?>

  <tr>
    <td>&nbsp;<?php echo $NU_IdUsuario; ?></td>
    <td>&nbsp;<?php echo $NU_Cedula; ?></td>
    <td>&nbsp;<?php echo $AL_Nombre; ?></td>
    <td>&nbsp;<?php echo $AL_Apellido; ?></td>
    <td>&nbsp;<?php echo $FE_FechaNac; ?></td>
    <td>&nbsp;<?php echo $AF_Clave; ?></td>
    <td>&nbsp;<?php echo $AF_Correo; ?></td>
    <td>&nbsp;<?php echo $AF_Telefono; ?></td>
    <?php
// PARA FORMATEAR CORREO ELECTRONICO
	if ($AF_Correo != ''){
		$AF_Correo = setCorreo($AF_Correo);
		$objUsuario->actualizar2($objConexion,$NU_Cedula,$AF_Correo);
	}
/* PARA COLOCAR LA FECHA DE NACIMIENTO
	if ($FE_FechaNac == ''){
		$RSFecha 	= $objSaime->buscarPersona($objConexion,$NU_Cedula);
		$cantRSFecha= $objConexion->cantidadRegistros($RSFecha);
		
		if ($cantRSFecha>0){
			$fecha3 = setFecha($objConexion->obtenerElemento($RSFecha,0,"FechaNacimiento"));
			
			$objUsuario->actualizar2($objConexion,$NU_Cedula,$fecha3);
		}
	}
/*	*/
?>
    <td>&nbsp;<?php echo $AF_Correo; ?></td>    
  </tr>
  
<?php } ?>  
</table>
</body>
</html>