<?php 
class Novedad{
	private $NU_IdNovedad;
	private $NU_Cedula;
	private $AL_Nombre;
	private $AL_Apellido;
	private $AF_Correo;
	private $AF_Telefono;
	private $AF_Ubicacion;
	private $empresa_NU_IdEmpresa;
	private $AF_Novedad;

	function insertar($objConexion,$NU_Cedula,$AL_Nombre,$AL_Apellido,$AF_Correo,$AF_Telefono,$AF_Ubicacion,$empresa_NU_IdEmpresa,$AF_Novedad){
		$this->NU_Cedula				= $NU_Cedula;
		$this->AL_Nombre				= $AL_Nombre;
		$this->AL_Apellido				= $AL_Apellido;
		$this->AF_Correo 				= $AF_Correo;
		$this->AF_Telefono				= $AF_Telefono;
		$this->AF_Ubicacion				= $AF_Ubicacion;
		$this->empresa_NU_IdEmpresa		= $empresa_NU_IdEmpresa;		
		$this->AF_Novedad				= $AF_Novedad;

		$query="INSERT INTO novedad
				(NU_Cedula, AL_Nombre, AL_Apellido, AF_Correo, AF_Telefono, AF_Ubicacion, empresa_NU_IdEmpresa, AF_Novedad)
				VALUES
				(".$this->NU_Cedula.",'".$this->AL_Nombre."','".$this->AL_Apellido."','".$this->AF_Correo."','".$this->AF_Telefono."','".$this->AF_Ubicacion."',".$this->empresa_NU_IdEmpresa.", '".$this->AF_Novedad."')";
		
		$resultado=$objConexion->ejecutar($query);
		
		return true;
	}

/**/	
}
?>