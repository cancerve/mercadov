<?php
	session_start();
	
	require_once("../includes/constantes.php");
	require_once("../includes/conexion.class.php");

	$objConexion= new conexion(SERVER,USER,PASS,DB);

	require_once('../model/usuarioModel.php');
	require_once('../model/saimeModel.php');
	
	$objUsuario = new Usuario();
	$objSaime 	= new Saime();
?>
<?php
	///// CONVIERTE FECHA 04/07/1980 A 1980-07-04 (FORMATO MYSQL)
	function setFechaSQL($FE_FechaNac)
	{
		$partes = explode("/", $FE_FechaNac);
		$FE_FechaNac = $partes[2].'-'.$partes[1].'-'.$partes[0];
		return $FE_FechaNac;
	}	
	///// CONVIERTE FECHA 1980-07-04 A 19800704 (FORMATO CORRIDO)
	function setFechaCorrida($FE_FechaNac)
	{
		$partes = explode("-", $FE_FechaNac);
		$FE_FechaNac = $partes[0].$partes[1].$partes[2];
		return $FE_FechaNac;
	}	
////////////////////// RECUPERAR CLAVE DE USUARIO /////////////////////////////////
	if ($_POST['origen']=='UserRecuperacion')
	{
		$NU_Cedula	     		= $_POST['NU_Cedula'];
		$FE_FechaNac 			= setFechaSQL($_POST['FE_FechaNac1']);
		$empresa_NU_IdEmpresa	= $_POST['empresa_NU_IdEmpresa'];
		
		$RS1 		= $objUsuario->verificarUsuario($objConexion,$NU_Cedula,$FE_FechaNac,$empresa_NU_IdEmpresa);
		$cantRS1 	= $objConexion->cantidadRegistros($RS1);

		if($cantRS1>0){
			$NU_IdUsuario	= $objConexion->obtenerElemento($RS1,0,"NU_IdUsuario");
			$AF_Correo		= $objConexion->obtenerElemento($RS1,0,"AF_Correo");		

			$AF_Clave = $objUsuario->nuevaAF_Clave($objConexion,$NU_IdUsuario);
			
			//////ENVIAR CORREO CON NUEVA CLAVE ///////
			$para 		= $AF_Correo;
			$asunto		= "Recuperacion de Clave";
			$headers 	= "MIME-Version: 1.0\r\n";
			$headers	.= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers	.= "From: VENALCASA <mercado@venalcasa.net.ve>\n";
			$mensaje 	= '<table width="100%" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td align="left"><img src="http://venalcasa.net.ve/mercadov/app/images/logo.png" width="246" height="95"  alt=""/></td>
    <td align="right"><img src="http://venalcasa.net.ve/mercadov/app/images/logo_mercadov.png" width="126" height="95"  alt=""/></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><p>Usted ha solicitado recuperar su clave de acceso al sistema <b>Mercado Virtual de VENALCASA</b>. </p>
	<p>Su nueva clave de acceso es: <b>'.$AF_Clave.'</b></p>
	<p>Se le recomienda cambiar su clave de acceso regularmente para evitar inconvenientes futuros.</a></p></td>
  </tr>
</table>';
			if(!mail($para,$asunto,$mensaje,$headers)){
				$mensaje = "Error al tratar de enviar el Correo \n";
			}else{
				$mensaje = "Correo Enviado Correctamente \n";			
			}
			
			header("Location: ../views/usuario/recuperacion/fin.php?AF_Correo=$AF_Correo");
		}else{
			header("Location: ../views/usuario/recuperacion/fin.php");			
		}
		
	}
	
//////////////////////  CREAR USUARIO /////////////////////////////////
	if ($_POST['origen']=='UserCrear1')
	{
		$NU_Cedula = $_POST["NU_Cedula"];
		$Cod = md5(pi());
		////////////// BUSQUEDA EN LA TABLA USUARIO /////////////////////////////////////////
		$rsUsuario 		= $objUsuario->buscarUsuario($objConexion,$NU_Cedula);
		$CantrsNomina 	= $objConexion->cantidadRegistros($rsUsuario);
		if ($CantrsNomina>0)
		{
			//session_start();
			$_SESSION["NU_Cedula"] = $NU_Cedula;				

			$AL_Nombre 			= $objConexion->obtenerElemento($rsUsuario,0,"AL_Nombre");
			$AL_Apellido 		= $objConexion->obtenerElemento($rsUsuario,0,"AL_Apellido");			
			$FE_FechaNac		= setFechaCorrida($objConexion->obtenerElemento($rsUsuario,0,"FE_FechaNac"));
			$AF_RazonSocial		= $objConexion->obtenerElemento($rsUsuario,0,"AF_RazonSocial");
			$AL_NombreSede 		= $objConexion->obtenerElemento($rsUsuario,0,"AL_NombreSede");			
			$AL_NombreGerencia	= $objConexion->obtenerElemento($rsUsuario,0,"AL_NombreGerencia");
			$AF_Correo 			= $objConexion->obtenerElemento($rsUsuario,0,"AF_Correo");			
			$AF_Telefono		= $objConexion->obtenerElemento($rsUsuario,0,"AF_Telefono");
			
			if ($AF_Correo=='' and $AF_Telefono==''){
				header("Location: ../views/usuario/crear/index2.php?Cod=$Cod&&Cod=$Cod&&Cod=$Cod&&Cod=$Cod&&Cod=$Cod&&Cod=$Cod&&AL_Apellido=$AL_Apellido&&AL_Nombre=$AL_Nombre&&FE_FechaNac=$FE_FechaNac&&AF_RazonSocial=$AF_RazonSocial&&AL_NombreSede=$AL_NombreSede&&AL_NombreGerencia=$AL_NombreGerencia");
			}else{
				$mensaje="Usted ya esta registrado en el Sistema. Si no recuerda su clave, haga clic en el boton Recuperar.";
				header("Location: ../../index.php?mensaje=$mensaje");			
			}
		}else{
			/*
			////////////// BUSQUEDA EN EL SAIME 2010 /////////////////////////////////////////////////
			$encontradoS = $objSaime->validarSaime($objConexion,$NU_Cedula);
			if ($encontradoS>0)
			{
				session_start();
				$_SESSION["NU_Cedula"] = $NU_Cedula;				
	
				$RS2 				= $objSaime->buscarPersona($objConexion,$NU_Cedula);
				$NU_Cedula			= $objConexion->obtenerElemento($RS2,0,"cedula");
				$AL_Apellido		= $objConexion->obtenerElemento($RS2,0,"PrimerApellido");
				$AL_Apellido		.= ' '.$objConexion->obtenerElemento($RS2,0,"SegundoApellido");				
				$AL_Nombre			= $objConexion->obtenerElemento($RS2,0,"PrimerNombre");
				$AL_Nombre			.= ' '.$objConexion->obtenerElemento($RS2,0,"SegundoNombre");				
				$FechaNacimiento	= $objConexion->obtenerElemento($RS2,0,"FechaNacimiento");
				
				header("Location: ../views/usuario/crear/index2.php?Cod=$Cod&&Cod=$Cod&&Cod=$Cod&&Cod=$Cod&&Cod=$Cod&&Cod=$Cod&&AL_Apellido=$AL_Apellido&&AL_Nombre=$AL_Nombre&&FE_FechaNac=$FechaNacimiento");
							
			}else{
		*/		
				$mensaje="Los datos introducidos no Existen en nuestra Base de Datos. Comuniquese con su Jefe Inmediato.";
				header("Location: ../../index.php?mensaje=$mensaje");			
			}
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//}
	}
	if ($_POST['origen']=='UserCrear2')
	{
	
		$NU_Cedula	     		= $_POST['NU_Cedula'];
		$FE_FechaNac 			= setFechaSQL($_POST['FE_FechaNac']);
		$AL_Nombre				= $_POST['AL_Nombre'];
		$AL_Apellido	     	= $_POST['AL_Apellido'];
		$empresa_NU_IdEmpresa	= $_POST['empresa_NU_IdEmpresa'];
		$sede_NU_IdSede			= $_POST['sede_NU_IdSede'];
		$gerencia_NU_IdGerencia	= $_POST['gerencia_NU_IdGerencia'];
		$AF_Telefono 			= $_POST['AF_Telefono'];
		$AF_Correo				= $_POST['AF_Correo'];
		$AF_Clave 				= md5($_POST['AF_Clave']);
		$rol_NU_IdRol			= $_POST['rol_NU_IdRol'];

		$rsUsuario 		= $objUsuario->buscarUsuario($objConexion,$NU_Cedula);
		$CantrsNomina 	= $objConexion->cantidadRegistros($rsUsuario);
		if ($CantrsNomina>0)
		{
			$objUsuario->actualizar($objConexion,$NU_Cedula,$AF_Clave,$AF_Correo,$AF_Telefono);
		}else{		
			//$objUsuario->insertar($objConexion,$NU_Cedula,$FE_FechaNac,$AL_Nombre,$AL_Apellido,$AF_Telefono,$AF_Correo,$AF_Clave,$rol_NU_IdRol);
		}

		//ENVIAR CORREO CON CLAVE ///////
		$para 		= $AF_Correo;
		$asunto		= "Registro en el Sistema de Mercado Virtual";
		$headers 	= "MIME-Version: 1.0\r\n";
		$headers	.= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers	.= "From: VENALCASA <mercado@venalcasa.net.ve>\n";
		$mensaje 	= '<table width="100%" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td align="left"><img src="http://venalcasa.net.ve/mercadov/app/images/logo.png" width="246" height="95"  alt=""/></td>
    <td align="right"><img src="http://venalcasa.net.ve/mercadov/app/images/logo_mercadov.png" width="126" height="95"  alt=""/></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><p>Usted ha sido registrado exitosamente en el sistema de <b>Mercado Virtual de VENALCASA</b>. </p>
      <p>Su clave de acceso es: <b>'.$_POST['AF_Clave'].'</b></p>
    <p>Se le recomienda cambiar su clave de acceso regularmente para evitar inconvenientes futuros.</p></td>
  </tr>
</table>';
		if(!mail($para,$asunto,$mensaje,$headers)){
			$mensaje = "Error al tratar de enviar el Correo \n";
		}else{
			$mensaje = "Correo Enviado Correctamente \n";			
		}

		$mensaje = "Usuario Creado Correctamente \n";	
		header("Location: ../views/usuario/crear/fin.php?AF_Correo=$AF_Correo");
	}
	
?>