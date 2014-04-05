<?php 
class Usuario{
	private $NU_IdUsuario;
	private $rol_NU_IdRol;
	private $empresa_NU_IdEmpresa;
	private $sede_NU_IdSede;
	private $gerencia_NU_IdGerencia;
	private $NU_Cedula;
	private $AL_Nombre;
	private $AL_Apellido;
	private $FE_FechaNac;
	private $AF_Clave;
	private $AF_Correo;
	private $AF_Telefono;
	private $NU_Activo;
	private $FE_Registro;	

	function setAF_Clave($AF_Clave)
	{
		 /////// PARA CUANDO LA CLAVE SEA LA FECHA DE NACIMIENTO
		$eliminar = array("/", ".", " ", "-");
		return $this->AF_Clave = md5(str_replace($eliminar, "", $AF_Clave));
	}
		
	function validarUsuario($objConexion,$NU_Cedula,$AF_Clave)
	{
		$this->NU_Cedula = $NU_Cedula;
		$this->setAF_Clave($AF_Clave);
		$query="SELECT * 
				FROM usuario 
				WHERE 
				NU_Cedula='".$this->NU_Cedula."' 
				AND 
				AF_Clave='".$this->AF_Clave."'";

		$resultado=$objConexion->ejecutar($query);
		$this->Cantidad = $objConexion->cantidadRegistros($resultado);
		
		if ($this->Cantidad>0)
			return true;
		else
			return false;
	}
		
	function verificarUsuario($objConexion,$NU_Cedula,$FE_FechaNac,$empresa_NU_IdEmpresa)
	{
		$this->NU_Cedula 			= $NU_Cedula;
		$this->FE_FechaNac 			= $FE_FechaNac;
		$this->empresa_NU_IdEmpresa = $empresa_NU_IdEmpresa;
		$query="SELECT * 
				FROM usuario 
				WHERE NU_Cedula=".$this->NU_Cedula." AND FE_FechaNac='".$this->FE_FechaNac."' AND empresa_NU_IdEmpresa='".$this->empresa_NU_IdEmpresa."'";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;
	}

	private function generarNuevo($objConexion){
		$this->id=0;
		$query="SELECT MAX(NU_IdUsuario) as id
				FROM usuario";
		$resultado=$objConexion->ejecutar($query);
		if($objConexion->cantidadRegistros($resultado)>0){
			$this->id=$objConexion->obtenerElemento($resultado,0,0);
		}
		/*
		echo $this->id = $this->id+1;
		return $this->id;
		*/
		$this->id++;
		return;		
	}
	
	function insertar($objConexion,$NU_Cedula,$FE_FechaNac,$AL_Nombre,$AL_Apellido,$AF_Telefono,$AF_Correo,$AF_Clave,$rol_NU_IdRol){
		$this->NU_Cedula				= $NU_Cedula;
		$this->FE_FechaNac				= $FE_FechaNac;
		$this->AL_Nombre				= $AL_Nombre;
		$this->AL_Apellido 				= $AL_Apellido;
		$this->AF_Telefono				= $AF_Telefono;
		$this->AF_Correo				= $AF_Correo;
		$this->AF_Clave					= md5($AF_Clave);		
		$this->rol_NU_IdRol				= $rol_NU_IdRol;

		$query="INSERT INTO usuario
				(NU_Cedula, FE_FechaNac, AL_Nombre, AL_Apellido, AF_Telefono, AF_Correo, AF_Clave, rol_NU_IdRol)
				VALUES
				(".$this->NU_Cedula.",'".$this->FE_FechaNac."','".$this->AL_Nombre."','".$this->AL_Apellido."','".$this->AF_Telefono."','".$this->AF_Correo."','".$this->AF_Clave."', ".$this->rol_NU_IdRol.")";
		
		$resultado=$objConexion->ejecutar($query);
		
		return true;
	}
	
	function buscarUsuario($objConexion,$NU_Cedula){
		$this->NU_Cedula = $NU_Cedula;
		$NU_Cedula;
		$query="SELECT U.*, E.AF_RazonSocial, S.AL_NombreSede, G.AL_NombreGerencia
				FROM usuario AS U
				LEFT JOIN empresa AS E ON (E.NU_IdEmpresa=U.empresa_NU_IdEmpresa)
				LEFT JOIN sede AS S ON (S.NU_IdSede=U.sede_NU_IdSede)
				LEFT JOIN gerencia AS G ON (G.NU_IdGerencia=U.gerencia_NU_IdGerencia)
				WHERE NU_Cedula='".$this->NU_Cedula."'";
		
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}

	function buscarUsuario2($objConexion,$NU_IdUsuario){
		$this->NU_IdUsuario = $NU_IdUsuario;
		$NU_Cedula;
		$query="SELECT U.*, E.AF_RazonSocial, S.AL_NombreSede, G.AL_NombreGerencia
				FROM usuario AS U
				LEFT JOIN empresa AS E ON (E.NU_IdEmpresa=U.empresa_NU_IdEmpresa)
				LEFT JOIN sede AS S ON (S.NU_IdSede=U.sede_NU_IdSede)
				LEFT JOIN gerencia AS G ON (G.NU_IdGerencia=U.gerencia_NU_IdGerencia)
				WHERE NU_IdUsuario='".$this->NU_IdUsuario."'";
		
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
		
	function existeUsuario($objConexion,$NU_Cedula){
		$this->NU_Cedula = $NU_Cedula;
		$NU_Cedula;
		$query="SELECT *
				FROM usuario
				WHERE NU_Cedula='".$this->NU_Cedula."'";
		$resultado=$objConexion->ejecutar($query);
		
		$this->Cantidad = $objConexion->cantidadRegistros($resultado);
		
		if ($this->Cantidad>0)
			return true;
		else
			return false;		
	}			

	function nuevaAF_Clave($objConexion,$NU_IdUsuario){
		$this->NU_IdUsuario = $NU_IdUsuario;
		$cadena = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789";
		$longitudCadena=strlen($cadena);
		$AF_Clave = "";
		$longitudPass=6;
		for($i=1 ; $i<=$longitudPass ; $i++){
			$pos = rand(0,$longitudCadena-1);
			$AF_Clave .= substr($cadena,$pos,1);
		}
		
		$this->AF_Clave	= md5($AF_Clave);

		$query="UPDATE usuario SET
				AF_Clave='".$this->AF_Clave."'
				WHERE NU_IdUsuario=".$this->NU_IdUsuario;

		$resultado=$objConexion->ejecutar($query);
		
		return $AF_Clave;
	}	
	
	function listar($objConexion){
		$query="SELECT *
				FROM usuario
				ORDER BY NU_Cedula ASC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}	
	
	function listar2($objConexion){
		$query="SELECT * FROM usuario AS U WHERE U.FE_FechaNac IS NULL";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
/*
	function buscarUsuario2($objConexion,$NU_Cedula){
		$this->NU_Cedula = $NU_Cedula;
		$NU_Cedula;
		$query="SELECT U.*
				FROM nomina4 AS U
				WHERE CEDULA=".$this->NU_Cedula."";
		
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
*/

	function actualizar2($objConexion,$NU_Cedula,$AF_Correo){
		$this->NU_Cedula	= $NU_Cedula;
		$this->AF_Correo		= $AF_Correo;
		
		$query="UPDATE usuario SET
				AF_Correo='".$this->AF_Correo."'
				WHERE NU_Cedula=".$this->NU_Cedula;
		
		$resultado=$objConexion->ejecutar($query);
		return true;
	}
			
	function actualizar($objConexion,$NU_Cedula,$AF_Clave,$AF_Correo,$AF_Telefono){
		$this->NU_Cedula	= $NU_Cedula;
		$this->AF_Clave		= $AF_Clave;
		$this->AF_Correo	= $AF_Correo;
		$this->AF_Telefono	= $AF_Telefono;		
		
		$query="UPDATE usuario SET
				AF_Clave='".$this->AF_Clave."',
				AF_Correo='".$this->AF_Correo."',
				AF_Telefono='".$this->AF_Telefono."'
				WHERE NU_Cedula=".$this->NU_Cedula;
		
		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
	function cambiarRol($objConexion,$NU_IdUsuario,$rol_NU_IdRol){
		$this->NU_IdUsuario	= $NU_IdUsuario;
		$this->rol_NU_IdRol	= $rol_NU_IdRol;
		
		$query="UPDATE usuario SET
				rol_NU_IdRol=".$this->rol_NU_IdRol."
				WHERE NU_IdUsuario=".$this->NU_IdUsuario;
		
		$resultado=$objConexion->ejecutar($query);
		return true;
	}		
/*		
	function getLibCodigo(){
		return $this->id;
	}

		



		
	
*/	
}
?>