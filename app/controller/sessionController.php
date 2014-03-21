<?php

/*
$path = getcwd();
echo "La ruta absoluta es: ";
echo $path;
die();
*/
?>
<?php

	session_start();

	//EN LINUX
	//$ruta = '.:/php/PEAR.:/var/www/VENALCASA/app/includes.:/var/www/VENALCASA/app/model.:';
	
	//SERVICIOSHOSTING
	$ruta = ':/home/venalcas/public_html/mercadov/app/includes:/home/venalcas/public_html/mercadov/app/model:';	

	//EN WINDOWS
	//$ruta = '.;D:\xampp\php\PEAR.;D:\xampp\htdocs\VENALCASA\mercadov\app\includes;D:\xampp\htdocs\VENALCASA\mercadov\app\model;';

	set_include_path(get_include_path() . PATH_SEPARATOR . $ruta);

	require_once("constantes.php");
	require_once("conexion.class.php");
	require_once("usuarioModel.php");

?>
<?php
	$objConexion= new conexion(SERVER,USER,PASS,DB);
	$objUsuario = new usuario();

	$NU_Cedula = $_SESSION["NU_Cedula"];

	if(isset($NU_Cedula)==false)
	{
		$mensaje="Acceso Denegado.";
		header("Location: http://localhost/VENALCASA/mercadov/index.php?mensaje=$mensaje");			
	}else{
		$resUsuario	= $objUsuario->buscarUsuario($objConexion,$NU_Cedula);
		$cant 		= $objConexion->cantidadRegistros($resUsuario);

		if($cant>0)
		{
			$rol_NU_IdRol	= $objConexion->obtenerElemento($resUsuario,0,"rol_NU_IdRol");
			$AL_Nombre		= $objConexion->obtenerElemento($resUsuario,0,"AL_Nombre");
			$AL_Apellido	= $objConexion->obtenerElemento($resUsuario,0,"AL_Apellido");			
			
			$_SESSION["AL_NombreApellido"] 	= $AL_Nombre.' '.$AL_Apellido;
			$_SESSION['rol_NU_IdRol']		= $rol_NU_IdRol;
						
		}else{
			$mensaje="Acceso Denegado.";
			header("Location: ../../index.php?mensaje=$mensaje");			
		}
	}
?>
<?php
	if(isset($_GET['tmenj'])=='1'){
		$clase = 'BlancoAzul';
	}else{
		$clase = 'BlancoRojo';	
	}
?>