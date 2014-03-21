<?php
/*		echo $NU_Cedula 	= $_POST["NU_Cedula"];
		echo $AF_Clave 	= $_POST["AF_Clave"];
		echo $code 		= $_POST['code'];
		echo 'amasdf';*/
?>
<?php
	require_once("../includes/conexion.class.php");
	require_once("../includes/constantes.php");	
	require_once("../includes/captcha/securimage.php");	
	require_once("../model/usuarioModel.php");
	require_once("../model/saimeModel.php");	
?>
<?php
if(isset($_POST["submit"])){

	try{
		$NU_Cedula 	= $_POST["NU_Cedula"];
		$AF_Clave 	= $_POST["AF_Clave"];
		$code 		= $_POST['code'];

		$objConexion	= new conexion(SERVER,USER,PASS,DB);
		$objUsuario		= new Usuario();
		$objSaime		= new Saime();
		$objImgCode 	= new Securimage();

		$existe		= $objUsuario->existeUsuario($objConexion,$NU_Cedula);
		$valid 		= $objImgCode->check($code);		

		if ($existe)
		{
			$encontrado	= $objUsuario->validarUsuario($objConexion,$NU_Cedula,$AF_Clave);

			if (($encontrado) and ($valid))
			{
				$RS 			= $objUsuario->buscarUsuario($objConexion,$NU_Cedula);
				$NU_IdUsuario 	= $objConexion->obtenerElemento($RS,0,"NU_IdUsuario");
				$AL_Nombre 		= $objConexion->obtenerElemento($RS,0,"AL_Nombre");
				$AL_Apellido 	= $objConexion->obtenerElemento($RS,0,"AL_Apellido");			
				$AF_Correo 		= $objConexion->obtenerElemento($RS,0,"AF_Correo");
				$AF_Telefono 	= $objConexion->obtenerElemento($RS,0,"AF_Telefono"); 
				$BI_Admin 		= $objConexion->obtenerElemento($RS,0,"BI_Admin"); 
	
				session_start();
				$_SESSION["NU_IdUsuario"] 		= $NU_IdUsuario;
				$_SESSION["NU_Cedula"] 			= $NU_Cedula;
				$_SESSION["AL_NombreApellido"] 	= $AL_Nombre.' '.$AL_Apellido;
				$_SESSION['rol_NU_IdRol'] 		= $rol_NU_IdRol;
				$_SESSION['BI_Admin'] 			= $BI_Admin;
				
				if ($AF_Correo=='' or $AF_Telefono==''){
					$mensaje="IMPORTANTE: Recuerde actualizar su Perfil para poder continuar.";
					header("Location: ../views/index.php?mensaje=$mensaje");
				}else{
					header("Location: ../views/index.php");
				}
			}else{
				$mensaje="El nombre de Usuario, Clave o Codigo Invalido.";
				header("Location: ../../index.php?mensaje=$mensaje");	
			}
/*			
		}else{
			if ($valid){
				if ($NU_Cedula!='' and $AF_Clave!=''){
					$encontradoS = $objSaime->validarSaime($objConexion,$NU_Cedula,$AF_Clave);
				}
			}
			
			if ($encontradoS)
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
				
				header("Location: ../views/usuario/crear/index.php?AL_Apellido=$AL_Apellido&&AL_Nombre=$AL_Nombre&&FechaNacimiento=$FechaNacimiento");
*/				
			}else{
				$mensaje="Los datos introducidos no Existen en nuestra Base de Datos";
				header("Location: ../../index.php?mensaje=$mensaje");			
			//}
		}
	}
	
	catch(Exception $e){
		$mensaje=$e->getMessage();
	}	
}
?>