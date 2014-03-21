<?php 
class Producto{
	private $NU_IdProducto;
	private $medida_NU_IdMedida;	
	private $AF_NombreProducto;
	private $NU_Max;	
	private $NU_Min;			
	private $NU_Salto;	
	private $NU_Contenido;	
	private $BS_PrecioUnitario;	
	private $AF_Foto;		
	private $NU_Activo;	
	private $FE_Registro;			

	function listarProducto($objConexion){
		$query="SELECT P.*, M.AL_Medida
				FROM producto AS P
				LEFT JOIN medida AS M ON (M.NU_IdMedida=P.medida_NU_IdMedida)
				ORDER BY P.AF_NombreProducto ASC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
/*	
	function insertar($objConexion,$empresa_NU_IdEmpresa,$FE_Inicio,$FE_Fin){
		$this->empresa_NU_IdEmpresa	= $empresa_NU_IdEmpresa;
		$this->FE_Inicio			= $FE_Inicio;				
		$this->FE_Fin				= $FE_Fin;

		$query="INSERT INTO empresa (empresa_NU_IdEmpresa,FE_Inicio,FE_Fin)
				VALUES
				(".$this->empresa_NU_IdEmpresa.",'".$this->FE_Inicio."','".$this->FE_Fin."')";
		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
	function buscar($objConexion,$NU_IdMercado){
		$this->NU_IdMercado=$NU_IdMercado;
		$query="SELECT *
				FROM mercado
				WHERE NU_IdMercado=".$this->NU_IdMercado;
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
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