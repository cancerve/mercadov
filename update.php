<?php 
	require_once("app/includes/constantes.php");
	require_once("app/includes/conexion.class.php");
	require_once('app/model/usuarioModel.php');
	
	$objConexion= new conexion(SERVER,USER,PASS,DB);
	$objUsuario = new Usuario();

	
	$RSUsuario 	= $objUsuario->listar($objConexion);
	$cantRS		= $objConexion->cantidadRegistros($RSUsuario);
	
	///// CONVIERTE FECHA 19800704 A 1980-07-04 (FORMATO MYSQL)
/*
	function setFecha($fecha)
	{
		$anio			= substr($fecha,0,4);		 
		$mes			= substr($fecha,4,-2);		 
		$dia			= substr($fecha,6);		 		
		return $fecha = $anio.'-'.$mes.'-'.$dia;
	}	
	*/
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
  </tr>
<?php
	//$objUsuario->actualizar($objConexion,$NU_IdUsuario,$FE_FechaNac);
?>  
<?php } ?>  
</table>
</body>
</html>