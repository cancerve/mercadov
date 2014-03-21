<?php 
class Empresa{
	private $NU_IdEmpresa;
	private $parroquia_NU_IdParroquia;	
	private $municipio_NU_IdMunicipio;
	private $estado_NU_IdEstado;	
	private $AF_RIF;
	private $AF_RazonSocial;
	private $AF_Telefono;
	private $AL_Contacto;			
	private $AF_Correo;
	private $NU_Activo;			
	private $FE_Registro;	

	private function generarNuevo($objConexion){
		$this->NU_IdEmpresa=0;
		$query="SELECT MAX(NU_IdEmpresa) as NU_IdEmpresa
				FROM empresa";
		$resultado=$objConexion->ejecutar($query);
		if($objConexion->cantidadRegistros($resultado)>0){
			$this->NU_IdEmpresa=$objConexion->obtenerElemento($resultado,0,0);
		}
		$this->NU_IdEmpresa++;
		return;
	}

	function insertar($objConexion,$NU_IdEmpresa,$parroquia_NU_IdParroquia,$municipio_NU_IdMunicipio,$estado_NU_IdEstado,$AF_RIF,$AF_RazonSocial,$AF_Telefono,$AL_Contacto,$AF_Correo){
		$this->generarNuevo($objConexion);
		$this->parroquia_NU_IdParroquia	= $parroquia_NU_IdParroquia;
		$this->municipio_NU_IdMunicipio	= $municipio_NU_IdMunicipio;				
		$this->estado_NU_IdEstado		= $estado_NU_IdEstado;
		$this->AF_RIF					= $AF_RIF;
		$this->AF_RazonSocial			= $AF_RazonSocial;
		$this->AF_Telefono				= $AF_Telefono;
		$this->AL_Contacto				= $AL_Contacto;
		$this->AF_Correo				= $AF_Correo;

		$query="INSERT INTO empresa (NU_IdEmpresa,parroquia_NU_IdParroquia,municipio_NU_IdMunicipio,estado_NU_IdEstado,AF_RIF,AF_RazonSocial,AF_Telefono,AL_Contacto,AF_Correo)
				VALUES
				(".$this->NU_IdEmpresa.",".$this->parroquia_NU_IdParroquia.",".$this->municipio_NU_IdMunicipio.",".$this->estado_NU_IdEstado.",'".$this->AF_RIF."','".$this->AF_RazonSocial."','".$this->AF_Telefono."','".$this->AL_Contacto."','".$this->AF_Correo."')";
		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	/*
	function actualizar($objConexion,$AF_RIF,$ciudad_AF_CodCiudad,$pais_AL_CodPais,$AF_Clasificacion_Empresa,$AF_Razon_Social,$AF_Direccion,$AL_Web,$AF_Correo_Electronico,$AF_Telefono,$AF_Fax){
		$this->AF_RIF					= $AF_RIF;
		$this->ciudad_AF_CodCiudad		= $ciudad_AF_CodCiudad;				
		$this->pais_AL_CodPais			= $pais_AL_CodPais;
		$this->AF_Clasificacion_Empresa	= $AF_Clasificacion_Empresa;
		$this->AF_Razon_Social			= $AF_Razon_Social;
		$this->AF_Direccion				= $AF_Direccion;
		$this->AL_Web					= $AL_Web;
		$this->AF_Correo_Electronico	= $AF_Correo_Electronico;
		$this->AF_Telefono				= $AF_Telefono;
		$this->AF_Fax					= $AF_Fax;
		
		$query="UPDATE empresa SET
				ciudad_AF_CodCiudad='".$this->ciudad_AF_CodCiudad."',				
				pais_AL_CodPais='".$this->pais_AL_CodPais."',
				AF_Clasificacion_Empresa='".$this->AF_Clasificacion_Empresa."',
				AF_Razon_Social='".$this->AF_Razon_Social."',
				AF_Direccion='".$this->AF_Direccion."',
				AL_Web='".$this->AL_Web."',
				AF_Correo_Electronico='".$this->AF_Correo_Electronico."',
				AF_Telefono='".$this->AF_Telefono."',
				AF_Fax='".$this->AF_Fax."'				
				WHERE AF_RIF='".$this->AF_RIF."'";
		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
*/
	
	function buscar($objConexion,$NU_IdEmpresa){
		$this->NU_IdEmpresa=$NU_IdEmpresa;
		$query="SELECT *
				FROM empresa
				WHERE NU_IdEmpresa=".$this->NU_IdEmpresa;
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
	function listarEmpresa($objConexion){
		$query="SELECT EMP.*,E.nombre AS estado,M.nombre AS municipio,P.nombre AS parroquia
				FROM empresa AS EMP
				LEFT JOIN estado AS E ON (E.id=EMP.estado_NU_IdEstado)
				LEFT JOIN municipio AS M ON (M.id=EMP.municipio_NU_IdMunicipio)				
				LEFT JOIN parroquia AS P ON (P.id=EMP.parroquia_NU_IdParroquia)				
				ORDER BY AF_RazonSocial ASC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
/*	
	function obtenerUltimoRIF($objConexion){
		$query="SELECT MAX(id) as id, AF_RIF
				FROM empresa";
		$resultado=$objConexion->ejecutar($query);
		if($objConexion->cantidadRegistros($resultado)>0){
			$this->AF_RIF=$objConexion->obtenerElemento($resultado,0,'AF_RIF');
		}
		
		return $this->AF_RIF;		
	}
*/		

}
?>