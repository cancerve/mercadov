<?php 
class Saime{
	private $id;
	private $cedula;
	private $PrimerApellido;
	private $SegundoApellido;
	private $PrimerNombre;
	private $SegundoNombre;
	private $FechaNacimiento;

	function setAF_Clave($AF_Clave)
	{
		$eliminar 		= array("/", ".", " ", "-");
		$fecha 	  		= str_replace($eliminar, "", $AF_Clave);
		$anio			= substr(str_replace($eliminar, "", $fecha),-4);		 
		$mes			= substr(str_replace($eliminar, "", $fecha),2,-4);		 
		$dia			= substr(str_replace($eliminar, "", $fecha),0,-6);		 		
		return $this->AF_Clave = $anio.$mes.$dia;
	}
		
	function validarSaime($objConexion,$NU_Cedula)
	{
		$this->NU_Cedula = $NU_Cedula;
		$query="SELECT * 
				FROM saime2010 
				WHERE 
				cedula='".$this->NU_Cedula."'";
				
		$resultado=$objConexion->ejecutar($query);
		$this->Cantidad = $objConexion->cantidadRegistros($resultado);
		
		if ($this->Cantidad>0)
			return true;
		else
			return false;
	}
	
	function buscarPersona($objConexion,$NU_Cedula){
		$this->NU_Cedula=$NU_Cedula;
		$query="SELECT *
				FROM saime2010
				WHERE cedula=".$this->NU_Cedula."";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
}
?>